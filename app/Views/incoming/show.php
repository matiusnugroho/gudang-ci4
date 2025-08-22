<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Transaksi #<?= $incoming['id'] ?></h5>
    <p><strong>Tanggal:</strong> <?= $incoming['date'] ?></p>
    <p><strong>Produk:</strong> <?= esc($incoming['product_name']) ?></p>
    <p><strong>Jumlah:</strong> <?= $incoming['quantity'] ?></p>
    <p><strong>Pembelian ID:</strong> #<?= $incoming['purchase_id'] ?> (<?= $incoming['purchase_date'] ?>)</p>
    <p><strong>Vendor:</strong> <?= esc($incoming['vendor_name']) ?></p>
    <p><strong>Pembeli:</strong> <?= esc($incoming['buyer_name']) ?></p>
  </div>
</div>

<a href="<?= site_url('incoming') ?>" class="btn btn-secondary mt-3">Kembali</a>

<?= $this->endSection() ?>
