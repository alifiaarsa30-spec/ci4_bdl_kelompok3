<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'kode_produk';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['kode_produk', 'nama_produk', 'satuan', 'harga_jual',
    'harga_beli', 'stok', 'deskripsi'];

    // Fungsi untuk pencarian produk (Case-Insensitive di PostgreSQL)
 public function search($keyword)
    {
        if (empty($keyword)) {
            return $this->findAll();
        }

        return $this->groupStart()
                    ->where('LOWER(nama_produk) LIKE', '%' . strtolower($keyword) . '%')
                    ->orWhere('LOWER(kode_produk) LIKE', '%' . strtolower($keyword) . '%')
                    ->groupEnd()
                    ->findAll();
    }
}