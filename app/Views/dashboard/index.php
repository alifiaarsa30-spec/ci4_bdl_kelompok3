
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-page {
        color: #303B32;
    }

    .dashboard-heading {
        margin-bottom: 28px;
    }

    .dashboard-heading h2 {
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #303B32;
    }

    .dashboard-heading p {
        color: #777D75;
        margin: 0;
        font-size: 14px;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .dashboard-stat {
        background: #FFFFFF;
        border: 1px solid #EAE9E2;
        border-radius: 10px;
        padding: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-stat p {
        color: #777D75;
        font-size: 14px;
        margin: 0 0 8px;
    }

    .dashboard-stat h3 {
        font-size: 27px;
        font-weight: 700;
        margin: 0;
        color: #303B32;
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        background: #EAEDE7;
        color: #465748;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .dashboard-summary {
        background: #465748;
        color: #F5F4EF;
        padding: 24px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .dashboard-summary p {
        margin: 0 0 8px;
        color: #D5DDD4;
        font-size: 14px;
    }

    .dashboard-summary h3 {
        margin: 0;
        font-size: 27px;
        font-weight: 700;
    }

    .dashboard-table {
        background: #FFFFFF;
        border: 1px solid #EAE9E2;
        border-radius: 10px;
        overflow: hidden;
    }

    .dashboard-table-header {
        padding: 19px 22px;
        border-bottom: 1px solid #EAE9E2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .dashboard-table-header h5 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #303B32;
    }

    .dashboard-table-header a {
        color: #465748;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .dashboard-table table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 14px;
    }

    .dashboard-table th {
        background: #F5F4EF;
        color: #626B61;
        font-weight: 600;
        text-align: left;
        padding: 14px 18px;
        white-space: nowrap;
    }

    .dashboard-table td {
        padding: 15px 18px;
        border-top: 1px solid #EEEDE7;
        color: #465047;
    }

    .dashboard-table tbody tr:hover {
        background: #FAFAF7;
    }

    .dashboard-empty {
        text-align: center !important;
        padding: 30px !important;
        color: #858B82 !important;
    }

    @media (max-width: 768px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-table {
            overflow-x: auto;
        }

        .dashboard-table-header {
            align-items: flex-start;
        }
    }
</style>

<div class="dashboard-page">

    <div class="dashboard-heading">
        <h2>Dashboard</h2>
        <p>Ringkasan informasi dan aktivitas sistem penjualan.</p>
    </div>

    <div class="dashboard-stats">

        <div class="dashboard-stat">
            <div>
                <p>Total Produk</p>
                <h3><?= number_format($jumlah_produk, 0, ',', '.') ?></h3>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>

        <div class="dashboard-stat">
            <div>
                <p>Total Pelanggan</p>
                <h3><?= number_format($jumlah_pelanggan, 0, ',', '.') ?></h3>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="dashboard-stat">
            <div>
                <p>Total Supplier</p>
                <h3><?= number_format($jumlah_supplier, 0, ',', '.') ?></h3>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-truck"></i>
            </div>
        </div>

    </div>

    <div class="dashboard-summary">
        <p>Akumulasi Nilai Penjualan</p>
        <h3>Rp <?= number_format($total_nilai_penjualan, 0, ',', '.') ?></h3>
    </div>

    <div class="dashboard-table">

        <div class="dashboard-table-header">
            <h5>
                <i class="fa-solid fa-clock-rotate-left me-2"></i>
                Transaksi Penjualan Terbaru
            </h5>

            <a href="<?= base_url('/penjualan') ?>">
                Lihat Semua &rarr;
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No. Penjualan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total (Rp)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($transaksi_terbaru)) : ?>

                    <?php foreach ($transaksi_terbaru as $row) : ?>
                        <tr>
                            <td>
                                <strong><?= esc($row['no_penjualan']) ?></strong>
                            </td>

                            <td>
                                <?= date('d/m/Y', strtotime($row['tgl_penjualan'])) ?>
                            </td>

                            <td>
                                <?= esc($row['nama_pelanggan'] ?? 'Umum / Tidak Dikenal') ?>
                            </td>

                            <td>
                                Rp <?= number_format($row['total'], 0, ',', '.') ?>
                            </td>

                            <td>
                                <?= esc($row['keterangan'] ?: '-') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="5" class="dashboard-empty">
                            Belum ada data transaksi penjualan.
                        </td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>

<?= $this->endSection() ?>
