<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <!-- Produk Terlaris -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-fire me-2 text-danger"></i> Produk Paling Banyak Terjual</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Nama Produk</th>
                                <th class="text-center">Total Terjual</th>
                                <th class="text-end pe-3">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produk_terlaris)) : ?>
                                <?php foreach ($produk_terlaris as $p) : ?>
                                    <tr>
                                        <td class="ps-3 fw-semibold"><?= $p['nama_produk'] ?></td>
                                        <td class="text-center"><span class="badge bg-success"><?= $p['total_terjual'] ?></span></td>
                                        <td class="text-end pe-3 fw-bold">Rp <?= number_format($p['total_pendapatan'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada data penjualan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Penjualan Pelanggan -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-users-rectangle me-2 text-primary"></i> Penjualan per Pelanggan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Nama Pelanggan</th>
                                <th class="text-center">Jml Transaksi</th>
                                <th class="text-end pe-3">Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($penjualan_pelanggan)) : ?>
                                <?php foreach ($penjualan_pelanggan as $pl) : ?>
                                    <tr>
                                        <td class="ps-3 fw-semibold"><?= $pl['nama_pelanggan'] ?></td>
                                        <td class="text-center"><span class="badge bg-primary"><?= $pl['jml_transaksi'] ?></span></td>
                                        <td class="text-end pe-3 fw-bold">Rp <?= number_format($pl['total_belanja'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada transaksi pelanggan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>