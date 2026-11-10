
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .detail-page {
        max-width: 950px;
        margin: 0 auto;
        color: #303B32;
    }

    .detail-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .detail-heading h2 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .detail-heading p {
        color: #777D75;
        font-size: 14px;
        margin: 0;
    }

    .detail-back {
        background: #EAE9E2;
        color: #303B32;
        text-decoration: none;
        padding: 9px 14px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
    }

    .detail-card {
        background: #FFFFFF;
        border: 1px solid #EAE9E2;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .detail-section-title {
        font-size: 15px;
        font-weight: 700;
        padding-bottom: 15px;
        border-bottom: 1px solid #EAE9E2;
        margin-bottom: 18px;
    }

    .detail-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .detail-info-item p {
        color: #858B82;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .detail-info-item strong {
        color: #303B32;
        font-size: 14px;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .detail-table th {
        background: #F5F4EF;
        color: #626B61;
        text-align: left;
        padding: 13px;
        white-space: nowrap;
    }

    .detail-table td {
        padding: 14px 13px;
        border-bottom: 1px solid #EEEDE7;
        color: #465047;
    }

    .detail-total {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 35px;
        padding-top: 20px;
        font-weight: 700;
    }

    .detail-total strong {
        color: #465748;
        font-size: 20px;
    }

    @media(max-width: 650px) {
        .detail-card { padding: 17px; }
        .detail-info-grid { grid-template-columns: 1fr; }
        .detail-table-wrap { overflow-x: auto; }
        .detail-total { gap: 12px; flex-wrap: wrap; }
    }
</style>

<div class="detail-page">

    <div class="detail-heading">
        <div>
            <h2>Detail Penjualan</h2>
            <p>Rincian transaksi <?= esc($penjualan['no_penjualan']) ?>.</p>
        </div>

        <a href="<?= base_url('/penjualan') ?>" class="detail-back">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="detail-card">
        <div class="detail-section-title">
            <i class="fa-solid fa-file-invoice me-2"></i>
            Informasi Transaksi
        </div>

        <div class="detail-info-grid">
            <div class="detail-info-item">
                <p>Nomor Penjualan</p>
                <strong><?= esc($penjualan['no_penjualan']) ?></strong>
            </div>

            <div class="detail-info-item">
                <p>Tanggal Penjualan</p>
                <strong><?= date('d/m/Y', strtotime($penjualan['tgl_penjualan'])) ?></strong>
            </div>

            <div class="detail-info-item">
                <p>Nama Pelanggan</p>
                <strong><?= esc($penjualan['nama_pelanggan'] ?? 'Umum') ?></strong>
            </div>

            <div class="detail-info-item">
                <p>No. Telepon</p>
                <strong><?= esc($penjualan['no_telepon'] ?? '-') ?></strong>
            </div>

            <div class="detail-info-item">
                <p>Keterangan</p>
                <strong><?= esc($penjualan['keterangan'] ?: '-') ?></strong>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-section-title">
            <i class="fa-solid fa-boxes-stacked me-2"></i>
            Rincian Produk
        </div>

        <div class="detail-table-wrap">
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($detil as $i => $d) : ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($d['kode_produk']) ?></td>
                            <td><strong><?= esc($d['nama_produk']) ?></strong></td>
                            <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                            <td><?= esc($d['jumlah']) . ' ' . esc($d['satuan']) ?></td>
                            <td>
                                <strong>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($detil)) : ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:25px;color:#858B82">
                                Belum ada rincian produk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="detail-total">
            <span>Total Pembayaran</span>
            <strong>Rp <?= number_format($penjualan['total'], 0, ',', '.') ?></strong>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
