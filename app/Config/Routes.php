<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'DashboardController::index');
$routes->get('praktikum/produk', 'PraktikumController::produk');
$routes->post('praktikum/produk/simpan', 'PraktikumController::simpanProduk');
$routes->get('praktikum/penjualan', 'PraktikumController::transaksiPenjualan');
$routes->get('praktikum/agregasi', 'PraktikumController::agregasiPelanggan');
$routes->get('praktikum/laporan', 'PraktikumController::laporanProduk');
$routes->get('praktikum/uji-transaksi', 'PraktikumController::simpanTransaksiMasterDetail');

$routes->get('/produk', 'ProdukController::index');
$routes->get('/produk/create', 'ProdukController::create');
$routes->post('/produk/store', 'ProdukController::store');
$routes->get('/produk/edit/(:segment)', 'ProdukController::edit/$1');
$routes->post('/produk/update/(:segment)', 'ProdukController::update/$1');
$routes->post('/produk/delete/(:segment)', 'ProdukController::delete/$1');

$routes->get('/pelanggan', 'PelangganController::index');
$routes->get('/pelanggan/create', 'PelangganController::create');
$routes->post('/pelanggan/store', 'PelangganController::store');
$routes->get('/pelanggan/edit/(:segment)', 'PelangganController::edit/$1');
$routes->post('/pelanggan/update/(:segment)', 'PelangganController::update/$1');
$routes->post('/pelanggan/delete/(:segment)', 'PelangganController::delete/$1');

$routes->get('/supplier', 'SupplierController::index');
$routes->get('/supplier/create', 'SupplierController::create');
$routes->post('/supplier/store', 'SupplierController::store');
$routes->get('/supplier/edit/(:segment)', 'SupplierController::edit/$1');
$routes->post('/supplier/update/(:segment)', 'SupplierController::update/$1');
$routes->post('/supplier/delete/(:segment)', 'SupplierController::delete/$1');
// Penjualan
$routes->get('/penjualan', 'PenjualanController::index');
$routes->get('/penjualan/create', 'PenjualanController::create');
$routes->post('/penjualan/store', 'PenjualanController::store');
$routes->get('/penjualan/detail/(:segment)', 'PenjualanController::detail/$1');
$routes->post('/penjualan/delete/(:segment)', 'PenjualanController::delete/$1');

// Pembelian
$routes->get('/pembelian', 'PembelianController::index');
$routes->get('/pembelian/create', 'PembelianController::create');
$routes->post('/pembelian/store', 'PembelianController::store');
$routes->get('/pembelian/detail/(:segment)', 'PembelianController::detail/$1');
$routes->post('/pembelian/delete/(:segment)', 'PembelianController::delete/$1');

// Laporan
$routes->get('/laporan', 'LaporanController::index');