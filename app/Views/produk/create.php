<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-circle-plus me-2 text-success"></i> Form Tambah Produk</h5>
            </div>
            <div class="card-body">
                <?php if (session()->has('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->get('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="<?= base_url('/produk/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Produk (PK)</label>
                        <input type="text" name="kode_produk" class="form-control" value="<?= old('kode_produk') ?>" placeholder="Contoh: P001" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?= old('nama_produk') ?>" placeholder="Contoh: Minyak Goreng 2L" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="<?= old('satuan') ?>" placeholder="Contoh: Pcs / Dus / Liter" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok Awal</label>
                            <input type="number" name="stok" class="form-control" value="<?= old('stok', 0) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga Beli (Rp)</label>
                            <input type="number" name="harga_beli" class="form-control" value="<?= old('harga_beli') ?>" placeholder="Contoh: 15000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                            <input type="number" name="harga_jual" class="form-control" value="<?= old('harga_jual') ?>" placeholder="Contoh: 18000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Keterangan singkat produk..."><?= old('deskripsi') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('/produk') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-save me-1"></i> Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>