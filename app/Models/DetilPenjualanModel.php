<?php

namespace App\Models;

use CodeIgniter\Model;

class DetilPenjualanModel extends Model
{
    protected $table = 'detil_penjualan';
    protected $primaryKey = 'no_penjualan';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'no_penjualan',
        'no_urut',
        'kode_produk',
        'jumlah',
        'harga',
        'subtotal'
    ];
}