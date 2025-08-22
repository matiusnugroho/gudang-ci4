<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
  <h1 class="mb-4">Dashboard Gudang x</h1>
  <div class="row">
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <h5 class="card-title">Produk</h5>
          <p class="display-6"><?= $totalProducts ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <h5 class="card-title">Barang Masuk</h5>
          <p class="display-6"><?= $totalIncoming ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <div class="card-body">
          <h5 class="card-title">Barang Keluar</h5>
          <p class="display-6"><?= $totalOutgoing ?></p>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>
