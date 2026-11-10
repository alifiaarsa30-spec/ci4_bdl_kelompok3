<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5 class="mb-0 fw-bold text-secondary"><i class="fa-solid fa-boxes-stacked me-2 text-success"></i> Data Produk</h5>
        <div class="d-flex gap-2">
            <!-- Form Pencarian -->
            <form action="" method="get" class="d-flex">
                <input type="text" name="keyword" class="form-control form-control-sm me-2" placeholder="Cari produk..." value="<?= esc($keyword ?? '') ?>">
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-search"></i></button>
            </form>
            <a href="<?= base_url('/produk/create') ?>" class="btn btn-sm btn-success"><i class="fa-solid fa-plus me-1"></i> Tambah Produk</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($produk)) : ?>
                        <?php foreach ($produk as $row) : ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-success"><?= esc($row['kode_produk']) ?></td>
                                <td>
                                    <strong><?= esc($row['nama_produk']) ?></strong>
                                    <?php if (!empty($row['deskripsi'])) : ?>
                                        <br><small class="text-muted"><?= esc($row['deskripsi']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= esc($row['satuan']) ?></span></td>
                                <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                                <td class="fw-bold text-success">Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($row['stok'] <= 5) : ?>
                                        <span class="badge bg-danger"><?= $row['stok'] ?> (Menipis)</span>
                                    <?php else : ?>
                                        <span class="badge bg-success"><?= $row['stok'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('/produk/edit/' . $row['kode_produk']) ?>" class="btn btn-sm btn-warning text-white me-1" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="<?= base_url('/produk/delete/' . $row['kode_produk']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data produk ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>