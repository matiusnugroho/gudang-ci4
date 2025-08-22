<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OutgoingItemModel;
use App\Models\ProductModel;

class Outcoming extends BaseController
{
    protected $outgoingModel;
    protected $productModel;
    protected $db;

    public function __construct()
    {
        $this->outgoingModel = new OutgoingItemModel();
        $this->productModel  = new ProductModel();
        $this->db            = \Config\Database::connect();
    }

    // GET /outgoing
    public function index()
    {
        $data = [
            'title' => 'Transaksi Barang Keluar',
            'outgoing' => $this->outgoingModel
                ->select('outgoing_items.*, products.name as product_name')
                ->join('products', 'products.id = outgoing_items.product_id')
                ->orderBy('outgoing_items.date', 'DESC')
                ->findAll()
        ];
        return view('outgoing/index', $data);
    }

    // GET /outgoing/new
    public function new()
    {
        return view('outgoing/create', [
            'title'    => 'Tambah Barang Keluar',
            'products' => $this->productModel->findAll(),
        ]);
    }

    // POST /outgoing
    public function create()
    {
        $productId = (int) $this->request->getPost('product_id');
        $quantity  = (float) $this->request->getPost('quantity');
        $note      = $this->request->getPost('note');

        if (!$productId || $quantity <= 0) {
            return redirect()->back()->with('error', 'Produk & jumlah harus diisi.')->withInput();
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.')->withInput();
        }

        // cek stok cukup
        if ($product['stock'] < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.')->withInput();
        }

        $this->db->transStart();

        // insert outgoing
        $this->outgoingModel->insert([
            'product_id' => $productId,
            'date'       => date('Y-m-d H:i:s'),
            'quantity'   => $quantity,
            'note'       => $note,
        ]);

        // kurangi stok
        $this->db->table('products')
            ->set('stock', 'stock - ' . $quantity, false)
            ->where('id', $productId)
            ->update();

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal mencatat barang keluar.')->withInput();
        }

        return redirect()->to('/outgoing')->with('message', 'Barang keluar berhasil dicatat & stok diperbarui.');
    }

    // GET /outgoing/{id}
    public function show($id)
    {
        $outgoing = $this->outgoingModel
            ->select('outgoing_items.*, products.name as product_name')
            ->join('products', 'products.id = outgoing_items.product_id')
            ->where('outgoing_items.id', (int) $id)
            ->first();

        if (!$outgoing) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Barang keluar dengan ID $id tidak ditemukan");
        }

        return view('outgoing/show', [
            'title'    => 'Detail Barang Keluar',
            'outgoing' => $outgoing,
        ]);
    }

    // DELETE /outgoing/{id}
    public function delete($id)
    {
        $outgoing = $this->outgoingModel->find($id);
        if (!$outgoing) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $this->db->transStart();

        // rollback stok
        $this->db->table('products')
            ->set('stock', 'stock + ' . (float) $outgoing['quantity'], false)
            ->where('id', (int) $outgoing['product_id'])
            ->update();

        // hapus outgoing
        $this->outgoingModel->delete($id);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi & rollback stok.');
        }

        return redirect()->to('/outgoing')->with('message', 'Transaksi dihapus & stok dikembalikan.');
    }
}
