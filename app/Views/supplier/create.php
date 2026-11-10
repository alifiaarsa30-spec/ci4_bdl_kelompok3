<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-truck-ramp-box me-2 text-warning"></i> Form Tambah Supplier</h5>
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

                <form action="<?= base_url('/supplier/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Supplier (PK)</label>
                        <input type="text" name="kode_supplier" class="form-control" value="<?= old('kode_supplier') ?>" placeholder="Contoh: SUP001" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Supplier</label>
                        <input type="text" name="nama_supplier" class="form-control" value="<?= old('nama_supplier') ?>" placeholder="Contoh: PT Sumber Pangan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="<?= old('no_telepon') ?>" placeholder="Contoh: 0315557788" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap supplier..." required><?= old('alamat') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('/supplier') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-save me-1"></i> Simpan Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>