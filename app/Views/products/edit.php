<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="mb-4"><?= $title ?></h1>

<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form action="<?= site_url('products/'.$product['id']) ?>" method="post">
  <input type="hidden" name="_method" value="PUT">
  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="category_id" class="form-control">
      <option value="">-- Pilih Kategori --</option>
      <?php foreach ($categories as $c): ?>
        <option value="<?= $c['id'] ?>" 
          <?= old('category_id', $product['category_id'])==$c['id']?'selected':'' ?>>
          <?= $c['name'] ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Kode</label>
    <input type="text" name="code" class="form-control" value="<?= old('code', $product['code']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="name" class="form-control" value="<?= old('name', $product['name']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Unit</label>
    <input type="text" name="unit" class="form-control" value="<?= old('unit', $product['unit']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" step="0.01" name="stock" class="form-control" value="<?= old('stock', $product['stock']) ?>">
  </div>
  <button type="submit" class="btn btn-success">Update</button>
  <a href="<?= site_url('products') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
