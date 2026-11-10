<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Data Produk (CRUD CodeIgniter 4)</h2>
    <hr>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Harga Jual</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $p): ?>
            <tr>
                <td><?= $p['kode_produk']; ?></td>
                <td><?= $p['nama_produk']; ?></td>
                <td><?= $p['satuan']; ?></td>
                <td><?= number_format($p['harga_jual'], 0, ',', '.'); ?></td>
                <td><?= $p['stok']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>