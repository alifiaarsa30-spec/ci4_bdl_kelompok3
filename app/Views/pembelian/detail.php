<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-cart-flatbed me-2 text-warning"></i> Form Transaksi Pembelian Stok Baru</h5>
    </div>
    <div class="card-body">
        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> <?= session()->get('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/pembelian/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">No. Pembelian</label>
                    <input type="text" name="no_pembelian" class="form-control" value="PB-<?= date('YmdHis') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Pembelian</label>
                    <input type="date" name="tgl_pembelian" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Supplier</label>
                    <select name="kode_supplier" class="form-select" required>
                        <option value="">Pilih Supplier</option>
                        <?php foreach ($supplier as $s) : ?>
                            <option value="<?= $s['kode_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-boxes-stacked me-2"></i> Pilih Produk untuk Ditambah Stok</h6>
            
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th width="150">Jumlah Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produk as $i => $pr) : ?>
                            <tr>
                                <td>
                                    <strong><?= $pr['nama_produk'] ?></strong> (Stok Saat Ini: <?= $pr['stok'] ?> | Harga Beli: Rp <?= number_format($pr['harga_beli'], 0, ',', '.') ?>)
                                    <input type="hidden" name="items[<?= $i ?>][kode_produk]" value="<?= $pr['kode_produk'] ?>">
                                </td>
                                <td>
                                    <input type="number" name="items[<?= $i ?>][jumlah]" class="form-control form-control-sm" value="0" min="0">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan pembelian..."></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('/pembelian') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-save me-1"></i> Simpan Pembelian</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>