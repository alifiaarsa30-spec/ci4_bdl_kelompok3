
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .sales-page { color: #303B32; }

    .sales-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }

    .sales-heading h2 {
        font-size: 25px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .sales-heading p {
        color: #777D75;
        font-size: 14px;
        margin: 0;
    }

    .sales-button {
        display: inline-block;
        background: #465748;
        color: #FFFFFF;
        padding: 10px 15px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .sales-button:hover { background: #303B32; color: #FFFFFF; }

    .sales-card {
        background: #FFFFFF;
        border: 1px solid #EAE9E2;
        border-radius: 10px;
        overflow: hidden;
    }

    .sales-card-title {
        padding: 18px 22px;
        border-bottom: 1px solid #EAE9E2;
        font-size: 15px;
        font-weight: 700;
    }

    .sales-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .sales-table th {
        background: #F5F4EF;
        color: #626B61;
        padding: 14px 16px;
        text-align: left;
        white-space: nowrap;
    }

    .sales-table td {
        padding: 15px 16px;
        border-top: 1px solid #EEEDE7;
        color: #465047;
        vertical-align: middle;
    }

    .sales-table tbody tr:hover { background: #FAFAF7; }

    .sales-code { font-weight: 700; color: #465748 !important; }

    .sales-action {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 31px;
        height: 31px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .sales-detail { background: #EAEDE7; color: #465748; }
    .sales-delete { background: #F5E8E4; color: #A34B3D; }

    .sales-empty {
        text-align: center;
        padding: 30px !important;
        color: #858B82 !important;
    }

    @media(max-width: 768px) {
        .sales-card { overflow-x: auto; }
    }
</style>

<div class="sales-page">

    <div class="sales-heading">
        <div>
            <h2>Transaksi Penjualan</h2>
            <p>Kelola dan lihat riwayat transaksi penjualan.</p>
        </div>

        <a href="<?= base_url('/penjualan/create') ?>" class="sales-button">
            <i class="fa-solid fa-plus me-1"></i> Transaksi Baru
        </a>
    </div>

    <div class="sales-card">
        <div class="sales-card-title">
            <i class="fa-solid fa-receipt me-2"></i>
            Riwayat Penjualan
        </div>

        <table class="sales-table">
            <thead>
                <tr>
                    <th>No. Penjualan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total (Rp)</th>
                    <th>Keterangan</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($penjualan)) : ?>
                    <?php foreach ($penjualan as $row) : ?>
                        <tr>
                            <td class="sales-code"><?= esc($row['no_penjualan']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tgl_penjualan'])) ?></td>
                            <td><?= esc($row['nama_pelanggan'] ?? 'Umum') ?></td>
                            <td><strong>Rp <?= number_format($row['total'], 0, ',', '.') ?></strong></td>
                            <td><?= esc($row['keterangan'] ?: '-') ?></td>
                            <td style="text-align:center; white-space:nowrap">
                                <a
                                    href="<?= base_url('/penjualan/detail/' . $row['no_penjualan']) ?>"
                                    class="sales-action sales-detail"
                                    title="Detail"
                                >
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <form
                                    action="<?= base_url('/penjualan/delete/' . $row['no_penjualan']) ?>"
                                    method="post"
                                    style="display:inline"
                                    onsubmit="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')"
                                >
                                    <?= csrf_field() ?>
                                    <button type="submit" class="sales-action sales-delete" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="sales-empty">
                            Belum ada transaksi penjualan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>
