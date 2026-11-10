<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-truck-field me-2 text-warning"></i> Data Supplier</h5>
        <div class="d-flex gap-2">
            <!-- Form Pencarian -->
            <form action="" method="get" class="d-flex">
                <input type="text" name="keyword" class="form-control form-control-sm me-2" placeholder="Cari supplier..." value="<?= esc($keyword ?? '') ?>">
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-search"></i></button>
            </form>
            <a href="<?= base_url('/supplier/create') ?>" class="btn btn-sm btn-warning text-white"><i class="fa-solid fa-plus me-1"></i> Tambah Supplier</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Nama Supplier</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($supplier)) : ?>
                        <?php foreach ($supplier as $row) : ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-warning"><?= esc($row['kode_supplier']) ?></td>
                                <td class="fw-bold"><?= esc($row['nama_supplier']) ?></td>
                                <td><i class="fa-solid fa-phone text-muted me-1 small"></i> <?= esc($row['no_telepon']) ?></td>
                                <td><?= esc($row['alamat']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('/supplier/edit/' . $row['kode_supplier']) ?>" class="btn btn-sm btn-warning text-white me-1" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="<?= base_url('/supplier/delete/' . $row['kode_supplier']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada data supplier ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>