<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Terjual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Laporan Kuantitas & Nilai Penjualan per Produk</h2>
    <hr>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Total Terjual (Qty)</th>
                <th>Total Nilai Rupiah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan as $l): ?>
            <tr>
                <td><?= $l['kode_produk']; ?></td>
                <td><?= $l['nama_produk']; ?></td>
                <td><?= $l['total_qty']; ?></td>
                <td><?= number_format($l['total_nilai'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>