<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Statistik Cards Row 1 -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat p-3 bg-white border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-1">Total Produk</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($jumlah_produk, 0, ',', '.') ?></h3>
                </div>
                <div class="fs-1 text-success opacity-75"><i class="fa-solid fa-boxes-stacked"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat p-3 bg-white border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-1">Total Pelanggan</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($jumlah_pelanggan, 0, ',', '.') ?></h3>
                </div>
                <div class="fs-1 text-primary opacity-75"><i class="fa-solid fa-users"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat p-3 bg-white border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-1">Total Supplier</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($jumlah_supplier, 0, ',', '.') ?></h3>
                </div>
                <div class="fs-1 text-warning opacity-75"><i class="fa-solid fa-truck-field"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat p-3 bg-white border-start border-4 border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted fw-semibold mb-1">Total Transaksi</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($jumlah_penjualan + $jumlah_pembelian, 0, ',', '.') ?></h3>
                </div>
                <div class="fs-1 text-info opacity-75"><i class="fa-solid fa-receipt"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards Row 2 (Nilai Finansial) -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card card-stat p-4 bg-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50 fw-semibold mb-1">Akumulasi Nilai Penjualan</h6>
                    <h2 class="fw-bold mb-0">Rp <?= number_format($total_nilai_penjualan, 0, ',', '.') ?></h2>
                </div>
                <div class="fs-1 opacity-50"><i class="fa-solid fa-money-bill-trend-up"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stat p-4 bg-dark text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50 fw-semibold mb-1">Akumulasi Nilai Pembelian</h6>
                    <h2 class="fw-bold mb-0">Rp <?= number_format($total_nilai_pembelian, 0, ',', '.') ?></h2>
                </div>
                <div class="fs-1 opacity-50"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Transaksi Penjualan Terbaru -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-clock-rotate-left me-2 text-success"></i> Transaksi Penjualan Terbaru</h5>
        <a href="<?= base_url('/penjualan') ?>" class="btn btn-sm btn-outline-success">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No. Penjualan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total (Rp)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transaksi_terbaru)) : ?>
                        <?php foreach ($transaksi_terbaru as $row) : ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-success"><?= $row['no_penjualan'] ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tgl_penjualan'])) ?></td>
                                <td><?= $row['nama_pelanggan'] ?? 'Umum / Tidak Dikenal' ?></td>
                                <td class="fw-bold">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $row['keterangan'] ?: '-' ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data transaksi penjualan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>