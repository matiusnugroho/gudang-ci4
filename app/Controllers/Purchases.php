<?php

namespace App\Controllers;

use App\Models\PurchaseModel;
use App\Models\PurchaseItemModel;
use App\Models\ProductModel;
use App\Models\VendorModel;
use CodeIgniter\Controller;

class Purchases extends Controller
{
    protected $purchaseModel;
    protected $purchaseItemModel;
    protected $productModel;
    protected $vendorModel;

    public function __construct()
    {
        $this->purchaseModel     = new PurchaseModel();
        $this->purchaseItemModel = new PurchaseItemModel();
        $this->productModel      = new ProductModel();
        $this->vendorModel       = new VendorModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Daftar Pembelian',
            'purchases' => $this->purchaseModel
                ->select('purchases.*, vendors.name as vendor_name')
                ->join('vendors', 'vendors.id = purchases.vendor_id')
                ->findAll()
        ];
        return view('purchases/index', $data);
    }

    public function new()
    {
        $data = [
            'title'   => 'Tambah Pembelian',
            'vendors' => $this->vendorModel->findAll(),
            'products'=> $this->productModel->findAll(),
        ];
        return view('purchases/create', $data);
    }

    public function create()
    {
        $purchaseData = [
            'vendor_id'     => $this->request->getPost('vendor_id'),
            'purchase_date' => $this->request->getPost('purchase_date'),
            'buyer_name'    => $this->request->getPost('buyer_name'),
            'status'        => 'OPEN',
            'notes'         => $this->request->getPost('notes'),
        ];

        $purchaseId = $this->purchaseModel->insert($purchaseData);

        $items = $this->request->getPost('items');
        if ($items) {
            foreach ($items as $item) {
                $this->purchaseItemModel->insert([
                    'purchase_id' => $purchaseId,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                ]);
            }
        }

        return redirect()->to('/purchases');
    }

    public function show($id)
    {
        $purchase = $this->purchaseModel
            ->select('purchases.*, vendors.name as vendor_name')
            ->join('vendors', 'vendors.id = purchases.vendor_id')
            ->find($id);

        if (!$purchase) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Pembelian dengan ID $id tidak ditemukan");
        }

        $items = $this->purchaseItemModel
            ->select('purchase_items.*, products.name as product_name')
            ->join('products', 'products.id = purchase_items.product_id')
            ->where('purchase_items.purchase_id', $id)
            ->findAll();

        $data = [
            'title'    => 'Detail Pembelian',
            'purchase' => $purchase,
            'items'    => $items,
        ];

        return view('purchases/show', $data);
    }
    public function edit($id)
    {
        $purchase = $this->purchaseModel->find($id);
        if (!$purchase) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Pembelian dengan ID $id tidak ditemukan");
        }

        $items = $this->purchaseItemModel
            ->where('purchase_id', $id)
            ->findAll();

        $data = [
            'title'    => 'Edit Pembelian',
            'purchase' => $purchase,
            'items'    => $items,
            'vendors'  => $this->vendorModel->findAll(),
            'products' => $this->productModel->findAll(),
        ];

        return view('purchases/edit', $data);
    }

    public function update($id)
    {
        $purchase = $this->purchaseModel->find($id);
        if (!$purchase) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Pembelian dengan ID $id tidak ditemukan");
        }

        $purchaseData = [
            'vendor_id'     => $this->request->getPost('vendor_id'),
            'purchase_date' => $this->request->getPost('purchase_date'),
            'buyer_name'    => $this->request->getPost('buyer_name'),
            'notes'         => $this->request->getPost('notes'),
        ];

        $this->purchaseModel->update($id, $purchaseData);

        // hapus item lama
        $this->purchaseItemModel->where('purchase_id', $id)->delete();

        // insert item baru
        $items = $this->request->getPost('items');
        if ($items) {
            foreach ($items as $item) {
                $this->purchaseItemModel->insert([
                    'purchase_id' => $id,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                ]);
            }
        }

        return redirect()->to('/purchases/'.$id);
    }

}
