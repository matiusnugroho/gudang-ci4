<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<a href="<?= site_url('incoming/new') ?>" class="btn btn-primary mb-3">+ Barang Masuk</a>

<?php if (session()->getFlashdata('message')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('message') ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tanggal</th>
      <th>Produk</th>
      <th>Jumlah</th>
      <th>ID Pembelian</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($incoming)): ?>
      <?php foreach ($incoming as $i): ?>
        <tr>
          <td><?= $i['id'] ?></td>
          <td><?= $i['date'] ?></td>
          <td><?= esc($i['product_name']) ?></td>
          <td><?= $i['quantity'] ?></td>
          <td>#<?= $i['purchase_id'] ?></td>
          <td>
            <a href="<?= site_url('incoming/'.$i['id']) ?>" class="btn btn-info btn-sm">Detail</a>
            <form action="<?= site_url('incoming/'.$i['id']) ?>" method="post" style="display:inline-block" onsubmit="return confirm('Yakin hapus transaksi ini?')">
              <?= csrf_field() ?>
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach ?>
    <?php else: ?>
      <tr>
        <td colspan="6" class="text-center">Belum ada data barang masuk</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?= $this->endSection() ?>
