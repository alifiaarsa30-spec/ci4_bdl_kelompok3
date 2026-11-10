<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Penjualan' ?> - Kelompok 3</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-primary: #198754;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --body-bg: #f8fafc;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: #334155;
        }
        /* Sidebar Styling */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background: var(--sidebar-bg);
            color: #fff;
            transition: all 0.3s;
            min-height: 100vh;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: #0f172a;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid #334155;
        }
        #sidebar ul.components {
            padding: 15px 0;
        }
        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 0.95rem;
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.2s;
        }
        #sidebar ul li a:hover, #sidebar ul li.active > a {
            color: #fff;
            background: var(--sidebar-hover);
            border-left: 4px solid var(--bs-primary);
        }
        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        /* Main Content */
        #content {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-top {
            background: #fff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        .card-stat {
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- SIDEBAR -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-cash-register text-success me-2"></i> SI Penjualan BDL
        </div>
        <ul class="list-unstyled components">
            <li class="<?= (service('uri')->getSegment(1) == '' || service('uri')->getSegment(1) == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('/') ?>"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            </li>
            <li class="<?= (service('uri')->getSegment(1) == 'produk') ? 'active' : '' ?>">
                <a href="<?= base_url('/produk') ?>"><i class="fa-solid fa-boxes-stacked"></i> Produk</a>
            </li>
            <li class="<?= (service('uri')->getSegment(1) == 'pelanggan') ? 'active' : '' ?>">
                <a href="<?= base_url('/pelanggan') ?>"><i class="fa-solid fa-users"></i> Pelanggan</a>
            </li>
            <li class="<?= (service('uri')->getSegment(1) == 'supplier') ? 'active' : '' ?>">
                <a href="<?= base_url('/supplier') ?>"><i class="fa-solid fa-truck-field"></i> Supplier</a>
            </li>
            <li class="<?= (service('uri')->getSegment(1) == 'penjualan') ? 'active' : '' ?>">
                <a href="<?= base_url('/penjualan') ?>"><i class="fa-solid fa-cart-shopping"></i> Transaksi Penjualan</a>
            </li>
            <li class="<?= (service('uri')->getSegment(1) == 'pembelian') ? 'active' : '' ?>">
                <a href="<?= base_url('/pembelian') ?>"><i class="fa-solid fa-bag-shopping"></i> Transaksi Pembelian</a>
            </li>
            <li class="<?= (service('uri')->getSegment(1) == 'laporan') ? 'active' : '' ?>">
                <a href="<?= base_url('/laporan') ?>"><i class="fa-solid fa-file-invoice-dollar"></i> Laporan & Analisis</a>
            </li>
        </ul>
    </nav>

    <!-- CONTENT WRAPPER -->
    <div id="content">
        <!-- TOP NAVBAR -->
        <nav class="navbar navbar-expand navbar-light navbar-top px-4 py-3">
            <div class="container-fluid px-0">
                <span class="navbar-brand mb-0 h5 text-secondary fw-semibold">
                    <?= $subtitle ?? 'Sistem Informasi Penjualan Berbasis PostgreSQL' ?>
                </span>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <span class="text-dark fw-medium small"><i class="fa-solid fa-user-shield text-success me-1"></i> Admin Kelompok 3</span>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- MAIN VIEW CONTENT -->
        <main class="container-fluid p-4">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>

        <!-- FOOTER -->
        <footer class="text-center py-3 text-muted small mt-auto bg-white border-top">
            <span>Tugas Basis Data Lanjut • UIN Sunan Ampel Surabaya &copy; 2026</span>
        </footer>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>