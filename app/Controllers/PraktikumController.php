<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Controller;

class PraktikumController extends Controller
{
    // ==========================================
    // 1. FITUR CRUD PRODUK
    // ==========================================
    public function produk()
    {
        $model = new ProdukModel();
        
        // Fitur pencarian produk berdasarkan nama
        $keyword = $this->request->getGet('keyword');
        if ($keyword) {
            $data['produk'] = $model->like('nama_produk', $keyword)->findAll();
        } else {
            $data['produk'] = $model->findAll();
        }
        
        // Untuk sementara kita return JSON atau teks dulu sebelum membuat View
        return view('produk_view', $data); // Nanti kita buat file view-nya
    }

    public function simpanProduk()
    {
        $model = new ProdukModel();
        $model->save([
            'kode_produk' => $this->request->getPost('kode_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'satuan'      => $this->request->getPost('satuan'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ]);
        return redirect()->to('/praktikum/produk');
    }

    // ==========================================
    // 2. FITUR JOIN TRANSAKSI PENJUALAN
    // Menampilkan penjualan dengan JOIN ke tabel pelanggan[cite: 1, 2]
    // ==========================================
    public function transaksiPenjualan()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->select('penjualan.no_penjualan, penjualan.tgl_penjualan, pelanggan.nama_pelanggan, penjualan.total');
        $builder->join('pelanggan', 'pelanggan.kode_pelanggan = penjualan.kode_pelanggan');
        
        $data['penjualan'] = $builder->get()->getResultArray();
        return view('penjualan_view', $data);
    }

    // ==========================================
    // 3. FITUR AGREGASI PENJUALAN PER PELANGGAN
    // Menggunakan COUNT(), SUM(), GROUP BY, dan JOIN[cite: 1, 2]
    // ==========================================
    public function agregasiPelanggan()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pelanggan');
        $builder->select('pelanggan.kode_pelanggan, pelanggan.nama_pelanggan, COUNT(penjualan.no_penjualan) as jumlah_transaksi, COALESCE(SUM(penjualan.total), 0) as total_nilai_penjualan');
        $builder->join('penjualan', 'penjualan.kode_pelanggan = pelanggan.kode_pelanggan', 'left');
        $builder->groupBy('pelanggan.kode_pelanggan, pelanggan.nama_pelanggan');
        
        $data['agregasi'] = $builder->get()->getResultArray();
        return view('agregasi_pelanggan_view', $data);
    }

    // ==========================================
    // 4. FITUR LAPORAN PENJUALAN PER PRODUK
    // Menggabungkan produk, detil_penjualan, dan agregasi[cite: 1, 2]
    // ==========================================
    public function laporanProduk()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('produk');
        $builder->select('produk.kode_produk, produk.nama_produk, COALESCE(SUM(detil_penjualan.jumlah), 0) as total_qty, COALESCE(SUM(detil_penjualan.subtotal), 0) as total_nilai');
        $builder->join('detil_penjualan', 'detil_penjualan.kode_produk = produk.kode_produk', 'left');
        $builder->groupBy('produk.kode_produk, produk.nama_produk');
        
        $data['laporan'] = $builder->get()->getResultArray();
        return view('laporan_produk_view', $data);
    }

    // ==========================================
    // 5. MANAJEMEN TRANSAKSI DATABASE (COMMIT & ROLLBACK)
    // Skenario Berhasil vs Gagal[cite: 1]
    // ==========================================
    public function simpanTransaksiMasterDetail()
    {
        $db = \Config\Database::connect();
        
        // Memulai transaksi database[cite: 1]
        $db->transBegin();

        try {
            $noPenjualan = 'PJ-999';

            // Simpan header penjualan[cite: 1]
            $db->table('penjualan')->insert([
                'no_penjualan'   => $noPenjualan,
                'tgl_penjualan'  => date('Y-m-d'),
                'kode_pelanggan' => 'P001', // Pastikan kode pelanggan ini ada di DB
                'total'          => 150000,
                'keterangan'     => 'Uji Transaksi'
            ]);

            // Simpan detail penjualan (minimal 2 baris)[cite: 1]
            // Baris 1: Produk valid
            // Baris 2: Sengaja diisi kode produk salah untuk menguji ROLLBACK[cite: 1]
            $details = [
                [
                    'no_penjualan' => $noPenjualan,
                    'no_urut'      => 1,
                    'kode_produk'  => 'PRD001', // Ganti dengan kode produk yang asli di database-mu
                    'jumlah'       => 1,
                    'harga'        => 100000,
                    'subtotal'     => 100000
                ],
                [
                    'no_penjualan' => $noPenjualan,
                    'no_urut'      => 2,
                    'kode_produk'  => 'PRODUK_SALAH_GAGAL', // Sengaja invalid agar gagal[cite: 1]
                    'jumlah'       => 1,
                    'harga'        => 50000,
                    'subtotal'     => 50000
                ]
            ];

            foreach ($details as $row) {
                $db->table('detil_penjualan')->insert($row);
            }

            // Cek status transaksi[cite: 1]
            if ($db->transStatus() === FALSE) {
                $db->transRollback(); // Batalkan semua jika ada error[cite: 1]
                return "Uji Coba Gagal (Rollback Berhasil): Header dan Detail batal masuk ke database karena ada kesalahan pada data detail.";
            } else {
                $db->transCommit(); // Simpan permanen jika sukses[cite: 1]
                return "Transaksi Berhasil Disimpan dengan Commit!";
            }

        } catch (\Exception $e) {
            $db->transRollback();
            return "Terjadi Kesalahan: " . $e->getMessage();
        }
    }
}