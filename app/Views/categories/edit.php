<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= site_url('categories/'.$category['id']) ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="mb-3">
        <label for="name">Nama Kategori</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= old('name', $category['name']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= site_url('categories') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
