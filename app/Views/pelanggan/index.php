<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-users me-2 text-primary"></i> Data Pelanggan</h5>
        <div class="d-flex gap-2">
            <!-- Form Pencarian -->
            <form action="" method="get" class="d-flex">
                <input type="text" name="keyword" class="form-control form-control-sm me-2" placeholder="Cari pelanggan..." value="<?= esc($keyword ?? '') ?>">
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-search"></i></button>
            </form>
            <a href="<?= base_url('/pelanggan/create') ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah Pelanggan</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pelanggan)) : ?>
                        <?php foreach ($pelanggan as $row) : ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-primary"><?= esc($row['kode_pelanggan']) ?></td>
                                <td class="fw-bold"><?= esc($row['nama_pelanggan']) ?></td>
                                <td><i class="fa-solid fa-phone text-muted me-1 small"></i> <?= esc($row['no_telepon']) ?></td>
                                <td><?= esc($row['alamat']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('/pelanggan/edit/' . $row['kode_pelanggan']) ?>" class="btn btn-sm btn-warning text-white me-1" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="<?= base_url('/pelanggan/delete/' . $row['kode_pelanggan']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada data pelanggan ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>