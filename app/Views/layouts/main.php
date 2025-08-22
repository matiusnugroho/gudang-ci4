<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'GudangApp' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= site_url('/') ?>">GudangApp</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('products') ?>">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('categories') ?>">Kategori</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('vendors') ?>">Vendor</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('purchases') ?>">Pembelian</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('incoming') ?>">Barang Masuk</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('outgoing') ?>">Barang Keluar</a></li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Reports
              </a>
              <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                  <li><a class="dropdown-item" href="<?= site_url('reports/incoming') ?>">Barang Masuk</a></li>
                  <li><a class="dropdown-item" href="<?= site_url('reports/outgoing') ?>">Barang Keluar</a></li>
                  <li><a class="dropdown-item" href="<?= site_url('reports/stock') ?>">Stok Barang</a></li>
              </ul>
          </li>
        </ul>
        <span class="navbar-text me-3">
          Halo, <strong><?= session('username') ?></strong> (<?= session('role') ?>)
        </span>
        <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container py-4">
    <?= $this->renderSection('content') ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
