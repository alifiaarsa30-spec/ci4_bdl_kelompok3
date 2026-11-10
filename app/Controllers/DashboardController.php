<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Mengambil statistik ringkasan menggunakan Query Builder
        $data['jumlah_produk']    = $db->table('produk')->countAllResults();
        $data['jumlah_pelanggan'] = $db->table('pelanggan')->countAllResults();
        $data['jumlah_supplier']  = $db->table('supplier')->countAllResults();
        
        $data['jumlah_penjualan'] = $db->table('penjualan')->countAllResults();
        $data['jumlah_pembelian'] = $db->table('pembelian')->countAllResults();

        // Menghitung total nilai penjualan & pembelian
        $data['total_nilai_penjualan'] = $db->table('penjualan')->selectSum('total')->get()->getRow()->total ?? 0;
        $data['total_nilai_pembelian'] = $db->table('pembelian')->selectSum('total')->get()->getRow()->total ?? 0;

        // Mengambil 5 transaksi penjualan terbaru dengan JOIN ke tabel pelanggan
        $data['transaksi_terbaru'] = $db->table('penjualan')
            ->select('penjualan.*, pelanggan.nama_pelanggan')
            ->join('pelanggan', 'pelanggan.kode_pelanggan = penjualan.kode_pelanggan', 'left')
            ->orderBy('tgl_penjualan', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data['title']    = 'Dashboard';
        $data['subtitle'] = 'Ringkasan Sistem Penjualan';

        return view('dashboard/index', $data);
    }
}