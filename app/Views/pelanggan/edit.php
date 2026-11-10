<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Form Edit Pelanggan</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/pelanggan/update/' . $pelanggan['kode_pelanggan']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Pelanggan (Primary Key)</label>
                        <input type="text" class="form-control bg-light" value="<?= $pelanggan['kode_pelanggan'] ?>" disabled>
                        <small class="text-muted">Kode pelanggan tidak dapat diubah.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="form-control" value="<?= old('nama_pelanggan', $pelanggan['nama_pelanggan']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="<?= old('no_telepon', $pelanggan['no_telepon']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= old('alamat', $pelanggan['alamat']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('/pelanggan') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-save me-1"></i> Perbarui Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>