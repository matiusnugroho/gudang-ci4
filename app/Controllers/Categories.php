<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // GET /categories
    public function index()
    {
        $data = [
            'title' => 'Kategori',
            'categories' => $this->categoryModel->orderBy('id', 'DESC')->findAll()
        ];
        return view('categories/index', $data);
    }

    // GET /categories/new
    public function new()
    {
        return view('categories/create', ['title' => 'Tambah Kategori']);
    }

    // POST /categories
    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]|is_unique[categories.name]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors())->withInput();
        }

        $this->categoryModel->save([
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/categories')->with('message', 'Kategori berhasil ditambahkan.');
    }

    // GET /categories/{id}/edit
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kategori dengan ID $id tidak ditemukan.");
        }

        return view('categories/edit', [
            'title' => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    // PUT/PATCH /categories/{id}
    public function update($id)
    {
        $rules = [
            'name' => "required|min_length[3]|is_unique[categories.name,id,{$id}]"
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors())->withInput();
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/categories')->with('message', 'Kategori berhasil diperbarui.');
    }

    // DELETE /categories/{id}
    public function delete($id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/categories')->with('message', 'Kategori berhasil dihapus.');
    }
}
