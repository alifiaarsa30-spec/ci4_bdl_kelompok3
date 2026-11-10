<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan (JOIN)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Laporan Transaksi Penjualan (JOIN Tabel Penjualan & Pelanggan)</h2>
    <hr>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No Penjualan</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($penjualan as $j): ?>
            <tr>
                <td><?= $j['no_penjualan']; ?></td>
                <td><?= $j['tgl_penjualan']; ?></td>
                <td><?= $j['nama_pelanggan']; ?></td>
                <td><?= number_format($j['total'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>