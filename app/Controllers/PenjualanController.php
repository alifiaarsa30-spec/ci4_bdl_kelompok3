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
            ->join('pelanggan', 'pelanggan.kode_pelanggan = penjualan.kode_pelanggan', 'left')
            ->orderBy('tgl_penjualan', 'DESC')
            ->get()
            ->getResultArray();

        return view('penjualan/index', [
            'title'     => 'Transaksi Penjualan',
            'subtitle'  => 'Riwayat Penjualan Barang',
            'penjualan' => $penjualan
        ]);
    }

    public function create()
    {
        $pelangganModel = new PelangganModel();
        $produkModel = new ProdukModel();

        return view('penjualan/create', [
            'title'     => 'Buat Penjualan Baru',
            'subtitle'  => 'Form Transaksi Penjualan',
            'pelanggan' => $pelangganModel->findAll(),
            'produk'    => $produkModel->findAll()
        ]);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart(); // Mulai Database Transaction (BEGIN)

        try {
            $no_penjualan   = $this->request->getPost('no_penjualan');
            $tgl_penjualan  = $this->request->getPost('tgl_penjualan');
            $kode_pelanggan = $this->request->getPost('kode_pelanggan');
            $keterangan     = $this->request->getPost('keterangan');
            
            $items          = $this->request->getPost('items'); // Array produk yang dibeli

            if (empty($items)) {
                throw new \Exception('Belum ada produk yang dipilih dalam transaksi.');
            }

            $total_transaksi = 0;
            $detilData = [];
            $produkModel = new ProdukModel();

            foreach ($items as $index => $item) {
                if (empty($item['kode_produk']) || empty($item['jumlah']) || $item['jumlah'] <= 0) {
                    continue;
                }

                $produk = $produkModel->find($item['kode_produk']);
                if (!$produk) {
                    throw new \Exception("Produk dengan kode {$item['kode_produk']} tidak ditemukan.");
                }

                // Validasi Stok
                if ($produk['stok'] < $item['jumlah']) {
                    throw new \Exception("Stok produk {$produk['nama_produk']} tidak mencukupi! Sisa stok: {$produk['stok']}");
                }

                $harga    = $produk['harga_jual'];
                $jumlah   = (int) $item['jumlah'];
                $subtotal = $harga * $jumlah;
                $total_transaksi += $subtotal;

                // Siapkan data detail
                $detilData[] = [
                    'no_penjualan' => $no_penjualan,
                    'no_urut'      => $index + 1,
                    'kode_produk'  => $item['kode_produk'],
                    'jumlah'       => $jumlah,
                    'harga'        => $harga,
                    'subtotal'     => $subtotal
                ];

                // Kurangi stok produk secara otomatis
                $stok_baru = $produk['stok'] - $jumlah;
                $produkModel->update($item['kode_produk'], ['stok' => $stok_baru]);
            }

            // Simpan Header Penjualan
            $penjualanModel = new PenjualanModel();
            $penjualanModel->insert([
                'no_penjualan'   => $no_penjualan,
                'tgl_penjualan'  => $tgl_penjualan,
                'kode_pelanggan' => $kode_pelanggan,
                'total'          => $total_transaksi,
                'keterangan'     => $keterangan
            ]);

            // Simpan Detail Penjualan
            $detilModel = new DetilPenjualanModel();
            foreach ($detilData as $detil) {
                $detilModel->insert($detil);
            }

            $db->transComplete(); // Selesai & Commit transaksi

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan transaksi ke database.');
            }

            return redirect()->to('/penjualan')->with('success', 'Transaksi penjualan berhasil disimpan dan stok telah diperbarui.');

        } catch (\Exception $e) {
            $db->transRollback(); // Batalkan semua jika ada error (ROLLBACK)
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function detail($no_penjualan)
    {
        $db = \Config\Database::connect();
        $penjualan = $db->table('penjualan')
            ->select('penjualan.*, pelanggan.nama_pelanggan, pelanggan.alamat, pelanggan.no_telepon')
            ->join('pelanggan', 'pelanggan.kode_pelanggan = penjualan.kode_pelanggan', 'left')
            ->where('no_penjualan', $no_penjualan)
            ->get()
            ->getRowArray();

        $detil = $db->table('detil_penjualan')
            ->select('detil_penjualan.*, produk.nama_produk, produk.satuan')
            ->join('produk', 'produk.kode_produk = detil_penjualan.kode_produk', 'left')
            ->where('no_penjualan', $no_penjualan)
            ->get()
            ->getResultArray();

        return view('penjualan/detail', [
            'title'     => 'Detail Penjualan',
            'subtitle'  => 'Informasi Rinci Transaksi',
            'penjualan' => $penjualan,
            'detil'     => $detil
        ]);
    }

    public function delete($no_penjualan)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Ambil data detail untuk mengembalikan stok produk
            $detilModel = new DetilPenjualanModel();
            $produkModel = new ProdukModel();
            $detilItems = $detilModel->where('no_penjualan', $no_penjualan)->findAll();

            foreach ($detilItems as $item) {
                $produk = $produkModel->find($item['kode_produk']);
                if ($produk) {
                    $stok_kembali = $produk['stok'] + $item['jumlah'];
                    $produkModel->update($item['kode_produk'], ['stok' => $stok_kembali]);
                }
            }

            // Hapus detail & header
            $detilModel->where('no_penjualan', $no_penjualan)->delete();
            $penjualanModel = new PenjualanModel();
            $penjualanModel->delete($no_penjualan);

            $db->transComplete();

            return redirect()->to('/penjualan')->with('success', 'Transaksi penjualan berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/penjualan')->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}