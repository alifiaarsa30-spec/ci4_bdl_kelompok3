<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;

class SupplierController extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $supplier = $this->supplierModel->like('nama_supplier', $keyword)
                                            ->orLike('kode_supplier', $keyword)
                                            ->orLike('no_telepon', $keyword)
                                            ->findAll();
        } else {
            $supplier = $this->supplierModel->findAll();
        }

        $data = [
            'title'    => 'Manajemen Supplier',
            'subtitle' => 'Daftar Seluruh Supplier Toko',
            'supplier' => $supplier,
            'keyword'  => $keyword
        ];

        return view('supplier/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Supplier',
            'subtitle'   => 'Form Input Supplier Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('supplier/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_supplier' => 'required|is_unique[supplier.kode_supplier]',
            'nama_supplier' => 'required',
            'no_telepon'    => 'required|numeric',
            'alamat'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->supplierModel->save([
            'kode_supplier' => $this->request->getPost('kode_supplier'),
            'nama_supplier' => $this->request->getPost('nama_supplier'),
            'no_telepon'    => $this->request->getPost('no_telepon'),
            'alamat'        => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/supplier')->with('success', 'Data supplier berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return redirect()->to('/supplier')->with('error', 'Supplier tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Supplier',
            'subtitle'   => 'Form Perbarui Data Supplier',
            'supplier'   => $supplier,
            'validation' => \Config\Services::validation()
        ];

        return view('supplier/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_supplier' => 'required',
            'no_telepon'    => 'required|numeric',
            'alamat'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->supplierModel->update($id, [
            'nama_supplier' => $this->request->getPost('nama_supplier'),
            'no_telepon'    => $this->request->getPost('no_telepon'),
            'alamat'        => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/supplier')->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->supplierModel->delete($id);
        return redirect()->to('/supplier')->with('success', 'Data supplier berhasil dihapus.');
    }
}