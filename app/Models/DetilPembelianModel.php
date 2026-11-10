<?php
namespace App\Models;
use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table            = 'pembelian';
    protected $primaryKey       = 'no_pembelian';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['no_pembelian', 'tgl_pembelian', 'kode_supplier', 'total', 'keterangan'];
}