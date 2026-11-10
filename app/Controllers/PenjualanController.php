<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenjualanModel;
use App\Models\DetilPenjualanModel;
use App\Models\PelangganModel;
use App\Models\ProdukModel;

class PenjualanController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $penjualan = $db->table('penjualan')
            ->select('penjualan.*, pelanggan.nama_pelanggan')
            ->join(
                'pelanggan',
                'pelanggan.kode_pelanggan = penjualan.kode_pelanggan',
                'left'
            )
            ->orderBy('tgl_penjualan', 'DESC')
            ->get()
            ->getResultArray();

        return view('penjualan/index', [
            'title' => 'Transaksi Penjualan',
            'subtitle' => 'Riwayat Penjualan Barang',
            'penjualan' => $penjualan
        ]);
    }

    public function create()
    {
        return view('penjualan/create', [
            'title' => 'Buat Penjualan Baru',
            'subtitle' => 'Form Transaksi Penjualan',
            'pelanggan' => (new PelangganModel())->findAll(),
            'produk' => (new ProdukModel())->findAll()
        ]);
    }

    public function store()
    {
        $db = \Config\Database::connect();

        $db->transBegin();

        try {
            $noPenjualan = trim($this->request->getPost('no_penjualan') ?? '');
            $tanggal = $this->request->getPost('tgl_penjualan');
            $kodePelanggan = $this->request->getPost('kode_pelanggan');
            $keterangan = $this->request->getPost('keterangan');
            $items = $this->request->getPost('items') ?? [];

            if ($noPenjualan === '' || !$tanggal || !$kodePelanggan) {
                throw new \Exception('Data transaksi wajib dilengkapi.');
            }

            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
                throw new \Exception('Format tanggal tidak valid.');
            }

            if (!(new PelangganModel())->find($kodePelanggan)) {
                throw new \Exception('Pelanggan tidak ditemukan.');
            }

            $produkModel = new ProdukModel();
            $detilModel = new DetilPenjualanModel();
            $penjualanModel = new PenjualanModel();

            $detilData = [];
            $total = 0;
            $noUrut = 1;

            foreach ($items as $item) {
                $kodeProduk = trim($item['kode_produk'] ?? '');
                $jumlah = filter_var(
                    $item['jumlah'] ?? null,
                    FILTER_VALIDATE_INT
                );

                if ($kodeProduk === '' || $jumlah === false || $jumlah < 0) {
                    throw new \Exception('Kode atau jumlah produk tidak valid.');
                }

                // Jumlah 0 berarti produk tidak dipilih.
                if ($jumlah === 0) {
                    continue;
                }

                $produk = $produkModel->find($kodeProduk);

                if (!$produk) {
                    throw new \Exception(
                        "Produk dengan kode {$kodeProduk} tidak ditemukan."
                    );
                }

                if ($jumlah > (int) $produk['stok']) {
                    throw new \Exception(
                        "Stok {$produk['nama_produk']} tidak mencukupi."
                    );
                }

                $harga = (float) $produk['harga_jual'];
                $subtotal = $harga * $jumlah;
                $total += $subtotal;

                $detilData[] = [
                    'no_penjualan' => $noPenjualan,
                    'no_urut' => $noUrut++,
                    'kode_produk' => $kodeProduk,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'subtotal' => $subtotal
                ];
            }

            if (count($detilData) < 2) {
                throw new \Exception(
                    'Transaksi harus memiliki minimal 2 jenis produk.'
                );
            }

            // Simpan header penjualan.
            if (!$penjualanModel->insert([
                'no_penjualan' => $noPenjualan,
                'tgl_penjualan' => $tanggal,
                'kode_pelanggan' => $kodePelanggan,
                'total' => $total,
                'keterangan' => $keterangan
            ])) {
                throw new \Exception('Gagal menyimpan header penjualan.');
            }

            // Simpan detail dan kurangi stok.
            foreach ($detilData as $detil) {
                if (!$detilModel->insert($detil)) {
                    throw new \Exception('Gagal menyimpan detail penjualan.');
                }

                $stokBaru = (int) $produkModel
                    ->find($detil['kode_produk'])['stok'] - $detil['jumlah'];

                if (!$produkModel->update(
                    $detil['kode_produk'],
                    ['stok' => $stokBaru]
                )) {
                    throw new \Exception('Gagal memperbarui stok produk.');
                }
            }

            if ($db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal.');
            }

            $db->transCommit();

            return redirect()->to('/penjualan')
                ->with('success', 'COMMIT: Transaksi berhasil disimpan dan stok diperbarui.');

        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'ROLLBACK: ' . $e->getMessage());
        }
    }

    public function detail($no_penjualan)
    {
        $db = \Config\Database::connect();

        $penjualan = $db->table('penjualan')
            ->select('penjualan.*, pelanggan.nama_pelanggan, pelanggan.alamat, pelanggan.no_telepon')
            ->join(
                'pelanggan',
                'pelanggan.kode_pelanggan = penjualan.kode_pelanggan',
                'left'
            )
            ->where('penjualan.no_penjualan', $no_penjualan)
            ->get()
            ->getRowArray();

        if (!$penjualan) {
            return redirect()->to('/penjualan')
                ->with('error', 'Data penjualan tidak ditemukan.');
        }

        $detil = $db->table('detil_penjualan')
            ->select('detil_penjualan.*, produk.nama_produk, produk.satuan')
            ->join(
                'produk',
                'produk.kode_produk = detil_penjualan.kode_produk',
                'left'
            )
            ->where('detil_penjualan.no_penjualan', $no_penjualan)
            ->orderBy('no_urut', 'ASC')
            ->get()
            ->getResultArray();

        return view('penjualan/detail', [
            'title' => 'Detail Penjualan',
            'subtitle' => 'Informasi Rinci Transaksi',
            'penjualan' => $penjualan,
            'detil' => $detil
        ]);
    }

    public function delete($no_penjualan)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $detilModel = new DetilPenjualanModel();
            $produkModel = new ProdukModel();
            $penjualanModel = new PenjualanModel();

            $detilItems = $detilModel
                ->where('no_penjualan', $no_penjualan)
                ->findAll();

            foreach ($detilItems as $item) {
                $produk = $produkModel->find($item['kode_produk']);

                if ($produk) {
                    $stokBaru = (int) $produk['stok'] + (int) $item['jumlah'];

                    $produkModel->update(
                        $item['kode_produk'],
                        ['stok' => $stokBaru]
                    );
                }
            }

            $detilModel->where('no_penjualan', $no_penjualan)->delete();
            $penjualanModel->delete($no_penjualan);

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menghapus transaksi.');
            }

            $db->transCommit();

            return redirect()->to('/penjualan')
                ->with('success', 'Transaksi dihapus dan stok dikembalikan.');

        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()->to('/penjualan')
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
