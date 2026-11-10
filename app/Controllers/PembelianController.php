<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PembelianModel;
use App\Models\DetilPembelianModel;
use App\Models\SupplierModel;
use App\Models\ProdukModel;

class PembelianController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $pembelian = $db->table('pembelian')
            ->select('pembelian.*, supplier.nama_supplier')
            ->join('supplier', 'supplier.kode_supplier = pembelian.kode_supplier', 'left')
            ->orderBy('tgl_pembelian', 'DESC')
            ->get()
            ->getResultArray();

        return view('pembelian/index', [
            'title'     => 'Transaksi Pembelian',
            'subtitle'  => 'Riwayat Pembelian Stok Barang',
            'pembelian' => $pembelian
        ]);
    }

    public function create()
    {
        $supplierModel = new SupplierModel();
        $produkModel = new ProdukModel();

        return view('pembelian/create', [
            'title'     => 'Buat Pembelian Baru',
            'subtitle'  => 'Form Transaksi Pembelian Stok',
            'supplier'  => $supplierModel->findAll(),
            'produk'    => $produkModel->findAll()
        ]);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $no_pembelian  = $this->request->getPost('no_pembelian');
            $tgl_pembelian = $this->request->getPost('tgl_pembelian');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $keterangan    = $this->request->getPost('keterangan');
            $items         = $this->request->getPost('items');

            if (empty($items)) {
                throw new \Exception('Belum ada produk yang dipilih.');
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
                    throw new \Exception("Produk tidak ditemukan.");
                }

                $harga    = $produk['harga_beli']; // Menggunakan harga beli
                $jumlah   = (int) $item['jumlah'];
                $subtotal = $harga * $jumlah;
                $total_transaksi += $subtotal;

                $detilData[] = [
                    'no_pembelian' => $no_pembelian,
                    'no_urut'      => $index + 1,
                    'kode_produk'  => $item['kode_produk'],
                    'jumlah'       => $jumlah,
                    'harga'        => $harga,
                    'subtotal'     => $subtotal
                ];

                // Tambah stok produk secara otomatis
                $stok_baru = $produk['stok'] + $jumlah;
                $produkModel->update($item['kode_produk'], ['stok' => $stok_baru]);
            }

            $pembelianModel = new PembelianModel();
            $pembelianModel->insert([
                'no_pembelian'  => $no_pembelian,
                'tgl_pembelian' => $tgl_pembelian,
                'kode_supplier' => $kode_supplier,
                'total'         => $total_transaksi,
                'keterangan'    => $keterangan
            ]);

            $detilModel = new DetilPembelianModel();
            foreach ($detilData as $detil) {
                $detilModel->insert($detil);
            }

            $db->transComplete();

            return redirect()->to('/pembelian')->with('success', 'Transaksi pembelian berhasil disimpan dan stok bertambah.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function detail($no_pembelian)
    {
        $db = \Config\Database::connect();
        $pembelian = $db->table('pembelian')
            ->select('pembelian.*, supplier.nama_supplier, supplier.alamat, supplier.no_telepon')
            ->join('supplier', 'supplier.kode_supplier = pembelian.kode_supplier', 'left')
            ->where('no_pembelian', $no_pembelian)
            ->get()
            ->getRowArray();

        $detil = $db->table('detil_pembelian')
            ->select('detil_pembelian.*, produk.nama_produk, produk.satuan')
            ->join('produk', 'produk.kode_produk = detil_pembelian.kode_produk', 'left')
            ->where('no_pembelian', $no_pembelian)
            ->get()
            ->getResultArray();

        return view('pembelian/detail', [
            'title'     => 'Detail Pembelian',
            'subtitle'  => 'Informasi Rinci Pembelian',
            'pembelian' => $pembelian,
            'detil'     => $detil
        ]);
    }

    public function delete($no_pembelian)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $detilModel = new DetilPembelianModel();
            $produkModel = new ProdukModel();
            $detilItems = $detilModel->where('no_pembelian', $no_pembelian)->findAll();

            foreach ($detilItems as $item) {
                $produk = $produkModel->find($item['kode_produk']);
                if ($produk) {
                    $stok_baru = max(0, $produk['stok'] - $item['jumlah']);
                    $produkModel->update($item['kode_produk'], ['stok' => $stok_baru]);
                }
            }

            $detilModel->where('no_pembelian', $no_pembelian)->delete();
            $pembelianModel = new PembelianModel();
            $pembelianModel->delete($no_pembelian);

            $db->transComplete();

            return redirect()->to('/pembelian')->with('success', 'Transaksi pembelian dihapus dan stok disesuaikan.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/pembelian')->with('error', 'Gagal menghapus pembelian.');
        }
    }
}