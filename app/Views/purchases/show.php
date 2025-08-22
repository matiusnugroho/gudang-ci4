<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<div class="card mb-3">
  <div class="card-body">
    <p><strong>ID:</strong> <?= $purchase['id'] ?></p>
    <p><strong>Tanggal:</strong> <?= $purchase['purchase_date'] ?></p>
    <p><strong>Vendor:</strong> <?= esc($purchase['vendor_name']) ?></p>
    <p><strong>Pembeli:</strong> <?= esc($purchase['buyer_name']) ?></p>
    <p><strong>Status:</strong> <?= esc($purchase['status']) ?></p>
    <p><strong>Catatan:</strong> <?= esc($purchase['notes']) ?></p>
  </div>
</div>

<h3>Detail Barang</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Produk</th>
      <th>Jumlah</th>
      <th>Harga Satuan</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $i): ?>
      <tr>
        <td><?= esc($i['product_name']) ?></td>
        <td><?= $i['quantity'] ?></td>
        <td><?= number_format($i['unit_price'], 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?= site_url('purchases') ?>" class="btn btn-secondary">Kembali</a>

<?= $this->endSection() ?>
