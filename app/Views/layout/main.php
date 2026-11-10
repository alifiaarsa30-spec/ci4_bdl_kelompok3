
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Sistem Penjualan' ?> | CI4</title>

    <!-- Bootstrap untuk grid dan komponen halaman -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- CSS utama mengikuti PHP Native -->
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        .flash-message {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<?php
$segment = service('uri')->getSegment(1) ?? '';
?>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">

        <a href="<?= base_url('/') ?>" class="brand">
            <span class="brand-icon">S</span>
            <span>
                <strong>Sistem Penjualan</strong>
                <small>CodeIgniter 4</small>
            </span>
        </a>

        <div class="nav-menu">

            <a href="<?= base_url('/') ?>"
               class="<?= $segment === '' ? 'active' : '' ?>">
                Dashboard
            </a>

            <a href="<?= base_url('/produk') ?>"
               class="<?= $segment === 'produk' ? 'active' : '' ?>">
                Produk
            </a>

            <a href="<?= base_url('/penjualan') ?>"
               class="<?= $segment === 'penjualan' ? 'active' : '' ?>">
                Transaksi Penjualan
            </a>

            <a href="<?= base_url('/laporan') ?>"
               class="<?= $segment === 'laporan' ? 'active' : '' ?>">
                Laporan
            </a>

        </div>
    </div>
</nav>

<!-- KONTEN -->
<main class="container">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert flash-message">
            <i class="fa-solid fa-circle-check me-2"></i>
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert-error flash-message">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>

</main>

<!-- FOOTER -->
<footer class="footer">
    Sistem Penjualan | CodeIgniter 4
    &copy; 2026
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
