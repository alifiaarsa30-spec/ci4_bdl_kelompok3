<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelangganModel;

class PelangganController extends BaseController
{
    protected $pelangganModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $pelanggan = $this->pelangganModel->like('nama_pelanggan', $keyword)
                                              ->orLike('kode_pelanggan', $keyword)
                                              ->orLike('no_telepon', $keyword)
                                              ->findAll();
        } else {
            $pelanggan = $this->pelangganModel->findAll();
        }

        $data = [
            'title'     => 'Manajemen Pelanggan',
            'subtitle'  => 'Daftar Seluruh Pelanggan Toko',
            'pelanggan' => $pelanggan,
            'keyword'   => $keyword
        ];

        return view('pelanggan/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Pelanggan',
            'subtitle'   => 'Form Input Pelanggan Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('pelanggan/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_pelanggan' => 'required|is_unique[pelanggan.kode_pelanggan]',
            'nama_pelanggan' => 'required',
            'no_telepon'     => 'required|numeric',
            'alamat'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pelangganModel->save([
            'kode_pelanggan' => $this->request->getPost('kode_pelanggan'),
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'no_telepon'     => $this->request->getPost('no_telepon'),
            'alamat'         => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = $this->pelangganModel->find($id);

        if (!$pelanggan) {
            return redirect()->to('/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Pelanggan',
            'subtitle'   => 'Form Perbarui Data Pelanggan',
            'pelanggan'  => $pelanggan,
            'validation' => \Config\Services::validation()
        ];

        return view('pelanggan/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_pelanggan' => 'required',
            'no_telepon'     => 'required|numeric',
            'alamat'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pelangganModel->update($id, [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'no_telepon'     => $this->request->getPost('no_telepon'),
            'alamat'         => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->pelangganModel->delete($id);
        return redirect()->to('/pelanggan')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}