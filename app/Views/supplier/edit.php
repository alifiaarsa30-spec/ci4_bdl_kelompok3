<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Form Edit Supplier</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/supplier/update/' . $supplier['kode_supplier']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Supplier (Primary Key)</label>
                        <input type="text" class="form-control bg-light" value="<?= $supplier['kode_supplier'] ?>" disabled>
                        <small class="text-muted">Kode supplier tidak dapat diubah.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Supplier</label>
                        <input type="text" name="nama_supplier" class="form-control" value="<?= old('nama_supplier', $supplier['nama_supplier']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="<?= old('no_telepon', $supplier['no_telepon']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= old('alamat', $supplier['alamat']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('/supplier') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-save me-1"></i> Perbarui Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>