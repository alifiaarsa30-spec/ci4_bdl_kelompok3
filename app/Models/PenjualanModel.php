<?php
namespace App\Models;
use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table            = 'penjualan';
    protected $primaryKey       = 'no_penjualan';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['no_penjualan', 'tgl_penjualan', 'kode_pelanggan', 'total', 'keterangan'];
}