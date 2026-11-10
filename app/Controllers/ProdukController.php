<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class ProdukController extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        
        if ($keyword) {
            $produk = $this->produkModel->like('nama_produk', $keyword)
                                        ->orLike('kode_produk', $keyword)
                                        ->findAll();
        } else {
            $produk = $this->produkModel->findAll();
        }

        $data = [
            'title'    => 'Manajemen Produk',
            'subtitle' => 'Daftar Seluruh Produk Toko',
            'produk'   => $produk,
            'keyword'  => $keyword
        ];

        return view('produk/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Produk',
            'subtitle' => 'Form Input Produk Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('produk/create', $data);
    }

    public function store()
    {
        // Validasi input termasuk cek duplikasi kode_produk
        $rules = [
            'kode_produk' => 'required|is_unique[produk.kode_produk]',
            'nama_produk' => 'required',
            'satuan'      => 'required',
            'harga_jual'  => 'required|numeric',
            'harga_beli'  => 'required|numeric',
            'stok'        => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->produkModel->save([
            'kode_produk' => $this->request->getPost('kode_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'satuan'      => $this->request->getPost('satuan'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/produk')->with('success', 'Data produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (!$produk) {
            return redirect()->to('/produk')->with('error', 'Produk tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Produk',
            'subtitle'   => 'Form Perbarui Data Produk',
            'produk'     => $produk,
            'validation' => \Config\Services::validation()
        ];

        return view('produk/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_produk' => 'required',
            'satuan'      => 'required',
            'harga_jual'  => 'required|numeric',
            'harga_beli'  => 'required|numeric',
            'stok'        => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->produkModel->update($id, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'satuan'      => $this->request->getPost('satuan'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/produk')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->produkModel->delete($id);
        return redirect()->to('/produk')->with('success', 'Data produk berhasil dihapus.');
    }
}