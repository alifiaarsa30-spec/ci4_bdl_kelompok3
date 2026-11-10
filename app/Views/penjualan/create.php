<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-cart-plus me-2 text-success"></i> Form Transaksi Penjualan Baru</h5>
    </div>
    <div class="card-body">
        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger"><i class="fa-solid triangle-exclamation me-2"></i> <?= session()->get('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/penjualan/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">No. Penjualan</label>
                    <input type="text" name="no_penjualan" class="form-control" value="TRX-<?= date('YmdHis') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Penjualan</label>
                    <input type="date" name="tgl_penjualan" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pelanggan</label>
                    <select name="kode_pelanggan" class="form-select" required>
                        <option value="">Pilih Pelanggan</option>
                        <?php foreach ($pelanggan as $p) : ?>
                            <option value="<?= $p['kode_pelanggan'] ?>"><?= $p['nama_pelanggan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-boxes-stacked me-2"></i> Pilih Produk</h6>
            
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th width="150">Jumlah Beli</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produk as $i => $pr) : ?>
                            <tr>
                                <td>
                                    <strong><?= $pr['nama_produk'] ?></strong> (Stok: <?= $pr['stok'] ?> | Harga: Rp <?= number_format($pr['harga_jual'], 0, ',', '.') ?>)
                                    <input type="hidden" name="items[<?= $i ?>][kode_produk]" value="<?= $pr['kode_produk'] ?>">
                                </td>
                                <td>
                                    <input type="number" name="items[<?= $i ?>][jumlah]" class="form-control form-control-sm" value="0" min="0" max="<?= $pr['stok'] ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan transaksi..."></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('/penjualan') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-save me-1"></i> Proses Penjualan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>