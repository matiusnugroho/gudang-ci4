<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>

<a href="/outgoing/new" class="btn btn-primary mb-3">Tambah Barang Keluar</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($outgoing as $o): ?>
        <tr>
            <td><?= $o['id'] ?></td>
            <td><?= $o['date'] ?></td>
            <td><?= $o['product_name'] ?></td>
            <td><?= $o['quantity'] ?></td>
            <td><?= $o['note'] ?></td>
            <td>
                <a href="/outgoing/<?= $o['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                <form action="/outgoing/<?= $o['id'] ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
