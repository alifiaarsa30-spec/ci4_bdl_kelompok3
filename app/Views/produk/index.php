
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    .produk-page {
        color: #303B32;
    }

    .produk-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .produk-heading h2 {
        font-size: 25px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .produk-heading p {
        color: #777D75;
        font-size: 14px;
        margin: 0;
    }

    .produk-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .produk-search {
        display: flex;
        gap: 7px;
    }

    .produk-search input {
        width: 220px;
        border: 1px solid #EAE9E2;
        border-radius: 7px;
        padding: 9px 12px;
        font-size: 13px;
    }

    .produk-search button,
    .btn-produk {
        border: none;
        border-radius: 7px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .produk-search button {
        background: #EAE9E2;
        color: #303B32;
    }

    .btn-produk-primary {
        background: #465748;
        color: #FFFFFF;
    }

    .btn-produk-primary:hover {
        background: #303B32;
        color: #FFFFFF;
    }

    .produk-table-card {
        background: #FFFFFF;
        border: 1px solid #EAE9E2;
        border-radius: 10px;
        overflow: hidden;
    }

    .produk-table-title {
        padding: 18px 22px;
        border-bottom: 1px solid #EAE9E2;
        font-size: 15px;
        font-weight: 700;
    }

    .produk-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .produk-table th {
        background: #F5F4EF;
        color: #626B61;
        font-weight: 600;
        text-align: left;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .produk-table td {
        padding: 14px 16px;
        border-top: 1px solid #EEEDE7;
        color: #465047;
        vertical-align: middle;
    }

    .produk-table tbody tr:hover {
        background: #FAFAF7;
    }

    .produk-code {
        color: #465748;
        font-weight: 700;
    }

    .produk-name {
        font-weight: 600;
        color: #303B32;
    }

    .produk-description {
        display: block;
        color: #858B82;
        font-size: 12px;
        margin-top: 4px;
    }

    .produk-stock {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 5px;
        background: #EAEDE7;
        color: #465748;
        font-size: 12px;
        font-weight: 600;
    }

    .produk-stock-low {
        background: #F5E8E4;
        color: #A34B3D;
    }

    .produk-btn-edit,
    .produk-btn-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 31px;
        height: 31px;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
    }

    .produk-btn-edit {
        background: #EAE9E2;
        color: #465748;
    }

    .produk-btn-delete {
        background: #F5E8E4;
        color: #A34B3D;
    }

    .produk-empty {
        text-align: center;
        padding: 30px !important;
        color: #858B82 !important;
    }

    @media (max-width: 768px) {
        .produk-search input {
            width: 160px;
        }

        .produk-table-card {
            overflow-x: auto;
        }
    }
</style>

<div class="produk-page">

    <div class="produk-heading">
        <div>
            <h2>Data Produk</h2>
            <p>Kelola data produk dan persediaan barang.</p>
        </div>

        <div class="produk-actions">
            <form action="<?= base_url('/produk') ?>" method="get" class="produk-search">
                <input
                    type="text"
                    name="keyword"
                    placeholder="Cari nama produk..."
                    value="<?= esc($keyword ?? '') ?>"
                >
                <button type="submit" title="Cari">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>

            <a href="<?= base_url('/produk/create') ?>" class="btn-produk btn-produk-primary">
                <i class="fa-solid fa-plus me-1"></i> Tambah Produk
            </a>
        </div>
    </div>

    <div class="produk-table-card">

        <div class="produk-table-title">
            <i class="fa-solid fa-boxes-stacked me-2"></i>
            Daftar Produk
        </div>

        <table class="produk-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($produk)) : ?>

                    <?php foreach ($produk as $row) : ?>
                        <tr>
                            <td class="produk-code">
                                <?= esc($row['kode_produk']) ?>
                            </td>

                            <td>
                                <span class="produk-name">
                                    <?= esc($row['nama_produk']) ?>
                                </span>

                                <?php if (!empty($row['deskripsi'])) : ?>
                                    <span class="produk-description">
                                        <?= esc($row['deskripsi']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td><?= esc($row['satuan']) ?></td>

                            <td>
                                Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?>
                            </td>

                            <td>
                                <strong>
                                    Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?>
                                </strong>
                            </td>

                            <td>
                                <?php if ($row['stok'] <= 5) : ?>
                                    <span class="produk-stock produk-stock-low">
                                        <?= esc($row['stok']) ?> (Menipis)
                                    </span>
                                <?php else : ?>
                                    <span class="produk-stock">
                                        <?= esc($row['stok']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td style="text-align:center; white-space:nowrap">
                                <a
                                    href="<?= base_url('/produk/edit/' . $row['kode_produk']) ?>"
                                    class="produk-btn-edit"
                                    title="Edit produk"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form
                                    action="<?= base_url('/produk/delete/' . $row['kode_produk']) ?>"
                                    method="post"
                                    style="display:inline"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                >
                                    <?= csrf_field() ?>

                                    <button type="submit" class="produk-btn-delete" title="Hapus produk">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>
                    <tr>
                        <td colspan="7" class="produk-empty">
                            Tidak ada data produk ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<?= $this->endSection() ?>
