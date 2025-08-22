<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="mb-4"><?= $title ?></h1>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<a href="<?= site_url('products/new') ?>" class="btn btn-primary mb-3">+ Tambah Produk</a>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Kode</th>
      <th>Nama</th>
      <th>Kategori</th>
      <th>Unit</th>
      <th>Stok</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $p): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['code'] ?></td>
        <td><?= $p['name'] ?></td>
        <td><?= $p['category_name'] ?? '-' ?></td>
        <td><?= $p['unit'] ?></td>
        <td><?= $p['stock'] ?></td>
        <td>
          <a href="<?= site_url('products/'.$p['id'].'/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
          <form action="<?= site_url('products/'.$p['id']) ?>" method="post" style="display:inline;">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Hapus produk ini?')">Hapus</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?= $this->endSection() ?>
