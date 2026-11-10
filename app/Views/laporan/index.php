
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .report-page {
        color: #303B32;
    }

    .report-heading {
        margin-bottom: 24px;
    }

    .report-heading h2 {
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .report-heading p {
        color: #858B82;
        margin: 0;
        font-size: 14px;
    }

    .report-card {
        background: #fff;
        border: 1px solid #EEEDE7;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 3px 12px rgba(48, 59, 50, 0.04);
    }

    .report-card-header {
        padding: 20px;
        border-bottom: 1px solid #EEEDE7;
    }

    .report-card-header h5 {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 5px;
        color: #303B32;
    }

    .report-card-header p {
        font-size: 12px;
        color: #92978F;
        margin: 0;
    }

    .report-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #EAEDE7;
        color: #465748;
        margin-right: 10px;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th {
        background: #F8F8F5;
        color: #858B82;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 14px 18px;
        white-space: nowrap;
    }

    .report-table td {
        padding: 15px 18px;
        font-size: 13px;
        border-bottom: 1px solid #F0F0EB;
        color: #465047;
    }

    .report-table tbody tr:last-child td {
        border-bottom: none;
    }

    .report-table .name {
        font-weight: 600;
        color: #303B32;
    }

    .report-number {
        display: inline-block;
        background: #EAEDE7;
        color: #465748;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .report-empty {
        text-align: center;
        padding: 35px 15px !important;
        color: #92978F !important;
    }

    @media (max-width: 768px) {
        .report-card-header {
            padding: 16px;
        }

        .report-table th,
        .report-table td {
            padding: 12px;
        }
    }
</style>

<div class="report-page">

    <div class="report-heading">
        <h2>Laporan Penjualan</h2>
        <p>Ringkasan penjualan produk dan aktivitas pelanggan.</p>
    </div>

    <div class="row g-4">

        <!-- Laporan Produk Terlaris -->
        <div class="col-lg-6">
            <div class="report-card">
                <div class="report-card-header">
                    <div class="d-flex align-items-center">
                        <span class="report-icon">
                            <i class="fa-solid fa-chart-column"></i>
                        </span>
                        <div>
                            <h5>Produk Paling Banyak Terjual</h5>
                            <p>5 produk dengan jumlah penjualan tertinggi</p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Terjual</th>
                                <th class="text-end">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produk_terlaris)) : ?>
                                <?php foreach ($produk_terlaris as $p) : ?>
                                    <tr>
                                        <td class="name">
                                            <?= esc($p['nama_produk']) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="report-number">
                                                <?= esc($p['total_terjual']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp <?= number_format((float) $p['total_pendapatan'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="report-empty">
                                        Belum ada data penjualan produk.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Laporan Penjualan per Pelanggan -->
        <div class="col-lg-6">
            <div class="report-card">
                <div class="report-card-header">
                    <div class="d-flex align-items-center">
                        <span class="report-icon">
                            <i class="fa-solid fa-users"></i>
                        </span>
                        <div>
                            <h5>Penjualan per Pelanggan</h5>
                            <p>Rekap jumlah transaksi dan total belanja</p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Nama Pelanggan</th>
                                <th class="text-center">Transaksi</th>
                                <th class="text-end">Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($penjualan_pelanggan)) : ?>
                                <?php foreach ($penjualan_pelanggan as $pl) : ?>
                                    <tr>
                                        <td class="name">
                                            <?= esc($pl['nama_pelanggan']) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="report-number">
                                                <?= esc($pl['jml_transaksi']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp <?= number_format((float) $pl['total_belanja'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="report-empty">
                                        Belum ada transaksi pelanggan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
