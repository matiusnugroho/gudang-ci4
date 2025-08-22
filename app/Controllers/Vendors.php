<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VendorModel;

class Vendors extends BaseController
{
    protected $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new VendorModel();
    }

    // GET /vendors
    public function index()
    {
        $data = [
            'title'   => 'Daftar Vendor',
            'vendors' => $this->vendorModel->findAll()
        ];
        return view('vendors/index', $data);
    }

    // GET /vendors/new
    public function new()
    {
        return view('vendors/create', [
            'title' => 'Tambah Vendor'
        ]);
    }

    // POST /vendors
    public function create()
    {
        if (!$this->validate([
            'name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->vendorModel->save([
            'name'    => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'phone'   => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/vendors')->with('message', 'Vendor berhasil ditambahkan.');
    }

    // GET /vendors/{id}/edit
    public function edit($id)
    {
        $vendor = $this->vendorModel->find($id);
        if (!$vendor) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Vendor $id tidak ditemukan");
        }

        return view('vendors/edit', [
            'title'  => 'Edit Vendor',
            'vendor' => $vendor,
        ]);
    }

    // PUT /vendors/{id}
    public function update($id)
    {
        if (!$this->validate([
            'name' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->vendorModel->update($id, [
            'name'    => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'phone'   => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/vendors')->with('message', 'Vendor berhasil diperbarui.');
    }

    // DELETE /vendors/{id}
    public function delete($id)
    {
        $this->vendorModel->delete($id);
        return redirect()->to('/vendors')->with('message', 'Vendor berhasil dihapus.');
    }
}
