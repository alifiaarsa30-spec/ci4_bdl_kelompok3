<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-cart-shopping me-2 text-success"></i> Riwayat Transaksi Penjualan</h5>
        <a href="<?= base_url('/penjualan/create') ?>" class="btn btn-sm btn-success"><i class="fa-solid fa-plus me-1"></i> Transaksi Baru</a>
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
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penjualan)) : ?>
                        <?php foreach ($penjualan as $row) : ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-success"><?= $row['no_penjualan'] ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tgl_penjualan'])) ?></td>
                                <td><?= $row['nama_pelanggan'] ?? 'Umum' ?></td>
                                <td class="fw-bold">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $row['keterangan'] ?: '-' ?></span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('/penjualan/detail/' . $row['no_penjualan']) ?>" class="btn btn-sm btn-info text-white me-1" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                    <form action="<?= base_url('/penjualan/delete/' . $row['no_penjualan']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi penjualan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>