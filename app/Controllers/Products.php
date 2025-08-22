<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // GET /products
    public function index()
    {
        $products = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->findAll();

        return view('products/index', [
            'title'    => 'Daftar Produk',
            'products' => $products,
        ]);
    }

    // GET /products/new
    public function new()
    {
        $categories = $this->categoryModel->findAll();

        return view('products/create', [
            'title'      => 'Tambah Produk',
            'categories' => $categories,
        ]);
    }

    // POST /products
    public function create()
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'code'  => 'required|is_unique[products.code]',
            'unit'  => 'required',
            'stock' => 'required|decimal',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        $this->productModel->insert([
            'category_id' => $data['category_id'] ?? null,
            'name'        => $data['name'],
            'code'        => $data['code'],
            'unit'        => $data['unit'],
            'stock'       => $data['stock'],
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan');
    }

    // GET /products/{id}
    public function show($id)
    {
        $product = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->find($id);

        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk dengan ID $id tidak ditemukan");
        }

        return view('products/show', [
            'title'   => 'Detail Produk',
            'product' => $product,
        ]);
    }

    // GET /products/{id}/edit
    public function edit($id)
    {
        $product    = $this->productModel->find($id);
        $categories = $this->categoryModel->findAll();

        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk dengan ID $id tidak ditemukan");
        }

        return view('products/edit', [
            'title'      => 'Edit Produk',
            'product'    => $product,
            'categories' => $categories,
        ]);
    }

    // PUT /products/{id}
    public function update($id)
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'code'  => "required|is_unique[products.code,id,{$id}]",
            'unit'  => 'required',
            'stock' => 'required|decimal',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        $this->productModel->update($id, [
            'category_id' => $data['category_id'] ?? null,
            'name'        => $data['name'],
            'code'        => $data['code'],
            'unit'        => $data['unit'],
            'stock'       => $data['stock'],
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil diperbarui');
    }

    // DELETE /products/{id}
    public function delete($id)
    {
        $this->productModel->delete($id);
        return redirect()->to('/products')->with('success', 'Produk berhasil dihapus');
    }
}
