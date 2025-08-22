<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<a href="<?= site_url('categories/new') ?>" class="btn btn-primary mb-3">Tambah Kategori</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= esc($c['name']) ?></td>
            <td>
                <a href="<?= site_url('categories/'.$c['id'].'/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                <form action="<?= site_url('categories/'.$c['id']) ?>" method="post" style="display:inline-block" onsubmit="return confirm('Yakin hapus?')">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
