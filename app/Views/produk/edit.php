<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Form Edit Produk</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/produk/update/' . $produk['kode_produk']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Produk (Primary Key)</label>
                        <input type="text" class="form-control bg-light" value="<?= $produk['kode_produk'] ?>" disabled>
                        <small class="text-muted">Kode produk tidak dapat diubah.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?= old('nama_produk', $produk['nama_produk']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="<?= old('satuan', $produk['satuan']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= old('stok', $produk['stok']) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga Beli (Rp)</label>
                            <input type="number" name="harga_beli" class="form-control" value="<?= old('harga_beli', $produk['harga_beli']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                            <input type="number" name="harga_jual" class="form-control" value="<?= old('harga_jual', $produk['harga_jual']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $produk['deskripsi']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('/produk') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-save me-1"></i> Perbarui Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>