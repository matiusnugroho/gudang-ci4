<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<a href="<?= site_url('vendors/new') ?>" class="btn btn-primary mb-3">Tambah Vendor</a>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($vendors as $v): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= esc($v['name']) ?></td>
            <td><?= esc($v['address']) ?></td>
            <td><?= esc($v['phone']) ?></td>
            <td>
                <a href="<?= site_url('vendors/' . $v['id'] . '/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
                <form action="<?= site_url('vendors/' . $v['id']) ?>" method="post" style="display:inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus vendor ini?')">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
