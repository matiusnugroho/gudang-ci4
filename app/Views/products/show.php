<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="mb-4"><?= $title ?></h1>

<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?= esc($product['name']) ?></h5>
    <p><strong>Kode:</strong> <?= esc($product['code']) ?></p>
    <p><strong>Kategori:</strong> <?= esc($product['category_name'] ?? '-') ?></p>
    <p><strong>Unit:</strong> <?= esc($product['unit']) ?></p>
    <p><strong>Stok:</strong> <?= esc($product['stock']) ?></p>
  </div>
</div>

<a href="<?= site_url('products/'.$product['id'].'/edit') ?>" class="btn btn-warning mt-3">Edit</a>
<a href="<?= site_url('products') ?>" class="btn btn-secondary mt-3">Kembali</a>

<?= $this->endSection() ?>
