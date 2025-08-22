<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IncomingItemModel;
use App\Models\PurchaseItemModel;
use App\Models\ProductModel;
use App\Models\PurchaseModel;

class IncomingItems extends BaseController
{
    protected $incomingModel;
    protected $purchaseModel;
    protected $purchaseItemModel;
    protected $productModel;
    protected $db;

    public function __construct()
    {
        $this->incomingModel     = new IncomingItemModel();
        $this->purchaseModel     = new PurchaseModel();
        $this->purchaseItemModel = new PurchaseItemModel();
        $this->productModel      = new ProductModel();
        $this->db                = \Config\Database::connect();
    }

    // GET /incoming
    public function index()
    {
        $data = [
            'title' => 'Transaksi Barang Masuk',
            'incoming' => $this->incomingModel
                ->select('incoming_items.*, products.name as product_name, purchases.id as purchase_id')
                ->join('products', 'products.id = incoming_items.product_id')
                ->join('purchase_items', 'purchase_items.id = incoming_items.purchase_item_id', 'left')
                ->join('purchases', 'purchases.id = purchase_items.purchase_id', 'left')
                ->orderBy('incoming_items.date', 'DESC')
                ->findAll()
        ];
        return view('incoming/index', $data);
    }

    // GET /incoming/new
    public function new()
    {
        return view('incoming/create', [
            'title'     => 'Tambah Barang Masuk',
            'purchases' => $this->purchaseModel->findAll(),
        ]);
    }

    // POST /incoming
    public function create()
    {
        $purchaseItemId = (int) $this->request->getPost('purchase_item_id');
        if (!$purchaseItemId) {
            return redirect()->back()->with('error', 'Silakan pilih item pembelian yang valid.')->withInput();
        }

        $pi = $this->purchaseItemModel
            ->select('purchase_items.*, purchases.id as purchase_id')
            ->join('purchases', 'purchases.id = purchase_items.purchase_id')
            ->find($purchaseItemId);

        if (!$pi) {
            return redirect()->back()->with('error', 'Purchase item tidak ditemukan.')->withInput();
        }

        // pastikan belum pernah dicatat masuk
        $already = $this->incomingModel->where('purchase_item_id', $purchaseItemId)->first();
        if ($already) {
            return redirect()->back()->with('error', 'Barang masuk untuk item ini sudah dicatat.')->withInput();
        }

        $this->db->transStart();

        // 1) insert incoming_items (qty = qty beli)
        $this->incomingModel->insert([
            'product_id'       => $pi['product_id'],
            'purchase_item_id' => $purchaseItemId,
            'date'             => date('Y-m-d H:i:s'),
            'quantity'         => $pi['quantity'],
        ]);

        // 2) update stok produk: stock = stock + qty
        $this->db->table('products')
            ->set('stock', 'stock + ' . (float) $pi['quantity'], false)
            ->where('id', (int) $pi['product_id'])
            ->update();

        // 3) auto-close purchase jika semua item sudah diterima
        $totalItems = $this->purchaseItemModel->where('purchase_id', (int) $pi['purchase_id'])->countAllResults();
        $receivedItems = $this->incomingModel
            ->join('purchase_items', 'purchase_items.id = incoming_items.purchase_item_id')
            ->where('purchase_items.purchase_id', (int) $pi['purchase_id'])
            ->countAllResults();

        if ($totalItems > 0 && $receivedItems === $totalItems) {
            $this->purchaseModel->update((int) $pi['purchase_id'], ['status' => 'CLOSED']);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi barang masuk.')->withInput();
        }

        return redirect()->to('/incoming')->with('message', 'Barang masuk berhasil dicatat & stok diperbarui.');
    }

    // GET /incoming/{id}
    public function show($id)
    {
        $incoming = $this->incomingModel
            ->select('incoming_items.*, products.name as product_name, purchases.id as purchase_id, purchases.purchase_date, purchases.buyer_name, vendors.name as vendor_name')
            ->join('products', 'products.id = incoming_items.product_id')
            ->join('purchase_items', 'purchase_items.id = incoming_items.purchase_item_id', 'left')
            ->join('purchases', 'purchases.id = purchase_items.purchase_id', 'left')
            ->join('vendors', 'vendors.id = purchases.vendor_id', 'left')
            ->where('incoming_items.id', (int) $id)
            ->first();

        if (!$incoming) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Barang masuk dengan ID $id tidak ditemukan");
        }

        return view('incoming/show', [
            'title'    => 'Detail Barang Masuk',
            'incoming' => $incoming,
        ]);
    }

    // DELETE /incoming/{id}
    public function delete($id)
    {
        $incoming = $this->incomingModel
            ->select('incoming_items.*, purchase_items.purchase_id')
            ->join('purchase_items', 'purchase_items.id = incoming_items.purchase_item_id', 'left')
            ->where('incoming_items.id', (int) $id)
            ->first();

        if (!$incoming) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $this->db->transStart();

        // 1) rollback stok: stock = stock - qty
        $this->db->table('products')
            ->set('stock', 'stock - ' . (float) $incoming['quantity'], false)
            ->where('id', (int) $incoming['product_id'])
            ->update();

        // 2) hapus incoming
        $this->incomingModel->delete((int) $id);

        // 3) jika sebelumnya purchase CLOSED, cek lagi — buka jika belum semua diterima
        $purchaseId = (int) $incoming['purchase_id'];
        if ($purchaseId) {
            $totalItems = $this->purchaseItemModel->where('purchase_id', $purchaseId)->countAllResults();
            $receivedItems = $this->incomingModel
                ->join('purchase_items', 'purchase_items.id = incoming_items.purchase_item_id')
                ->where('purchase_items.purchase_id', $purchaseId)
                ->countAllResults();

            if ($receivedItems < $totalItems) {
                $this->purchaseModel->update($purchaseId, ['status' => 'OPEN']);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi & rollback stok.');
        }

        return redirect()->to('/incoming')->with('message', 'Transaksi dihapus & stok di-rollback.');
    }
}
