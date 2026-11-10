<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Agregasi Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Agregasi Penjualan per Pelanggan (COUNT, SUM, GROUP BY)</h2>
    <hr>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Kode Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Jumlah Transaksi</th>
                <th>Total Nilai Penjualan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agregasi as $a): ?>
            <tr>
                <td><?= $a['kode_pelanggan']; ?></td>
                <td><?= $a['nama_pelanggan']; ?></td>
                <td><?= $a['jumlah_transaksi']; ?></td>
                <td><?= number_format($a['total_nilai_penjualan'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>