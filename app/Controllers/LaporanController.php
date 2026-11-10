<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class LaporanController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Produk Paling Banyak Terjual (GROUP BY & SUM)
        $produk_terlaris = $db->table('detil_penjualan')
            ->select('produk.nama_produk, SUM(detil_penjualan.jumlah) as total_terjual, SUM(detil_penjualan.subtotal) as total_pendapatan')
            ->join('produk', 'produk.kode_produk = detil_penjualan.kode_produk')
            ->groupBy('produk.kode_produk, produk.nama_produk')
            ->orderBy('total_terjual', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // 2. Rekap Penjualan per Pelanggan
        $penjualan_pelanggan = $db->table('penjualan')
            ->select('pelanggan.nama_pelanggan, COUNT(penjualan.no_penjualan) as jml_transaksi, SUM(penjualan.total) as total_belanja')
            ->join('pelanggan', 'pelanggan.kode_pelanggan = penjualan.kode_pelanggan')
            ->groupBy('pelanggan.kode_pelanggan, pelanggan.nama_pelanggan')
            ->get()
            ->getResultArray();

        return view('laporan/index', [
            'title'               => 'Laporan & Analisis Data',
            'subtitle'            => 'Rekapitulasi dan Statistik Basis Data',
            'produk_terlaris'     => $produk_terlaris,
            'penjualan_pelanggan' => $penjualan_pelanggan
        ]);
    }
}