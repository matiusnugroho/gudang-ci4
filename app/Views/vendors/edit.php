<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= esc($title) ?></h1>

<form action="<?= site_url('vendors/' . $vendor['id']) ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="mb-3">
        <label for="name" class="form-label">Nama Vendor</label>
        <input type="text" class="form-control" name="name" value="<?= old('name', $vendor['name']) ?>" required>
        <?php if (session('errors.name')): ?>
            <div class="text-danger"><?= session('errors.name') ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea class="form-control" name="address"><?= old('address', $vendor['address']) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Telepon</label>
        <input type="text" class="form-control" name="phone" value="<?= old('phone', $vendor['phone']) ?>">
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="<?= site_url('vendors') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
