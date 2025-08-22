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

<form action="<?= site_url('products') ?>" method="post">
  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="category_id" class="form-control">
      <option value="">-- Pilih Kategori --</option>
      <?php foreach ($categories as $c): ?>
        <option value="<?= $c['id'] ?>" <?= old('category_id')==$c['id']?'selected':'' ?>>
          <?= $c['name'] ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Kode</label>
    <input type="text" name="code" class="form-control" value="<?= old('code') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Unit</label>
    <input type="text" name="unit" class="form-control" value="<?= old('unit') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Stok Awal</label>
    <input type="number" step="0.01" name="stock" class="form-control" value="<?= old('stock', 0) ?>">
  </div>
  <button type="submit" class="btn btn-success">Simpan</button>
  <a href="<?= site_url('products') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
