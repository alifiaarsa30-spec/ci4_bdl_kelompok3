<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-file-invoice me-2 text-success"></i> Detail Penjualan: <?= $penjualan['no_penjualan'] ?></h5>
        <a href="<?= base_url('/penjualan') ?>" class="btn btn-sm btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <p class="mb-1"><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($penjualan['tgl_penjualan'])) ?></p>
                <p class="mb-1"><strong>Pelanggan:</strong> <?= $penjualan['nama_pelanggan'] ?? 'Umum' ?></p>
                <p class="mb-1"><strong>No. Telepon:</strong> <?= $penjualan['no_telepon'] ?? '-' ?></p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1"><strong>Keterangan:</strong> <?= $penjualan['keterangan'] ?: '-' ?></p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detil as $i => $d) : ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $d['kode_produk'] ?></td>
                            <td><?= $d['nama_produk'] ?></td>
                            <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                            <td><?= $d['jumlah'] . ' ' . $d['satuan'] ?></td>
                            <td class="fw-bold">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total Pembayaran:</td>
                        <td class="fw-bold text-success fs-5">Rp <?= number_format($penjualan['total'], 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>