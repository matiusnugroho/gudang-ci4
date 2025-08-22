<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<form action="/outgoing" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="product_id" class="form-label">Pilih Produk</label>
        <select name="product_id" id="product_id" class="form-select" required>
            <option value="">-- pilih --</option>
            <?php foreach ($products as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['name'] ?> (Stok: <?= $p['stock'] ?>)
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Jumlah</label>
        <input type="number" step="0.01" min="0" name="quantity" id="quantity" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="note" class="form-label">Catatan</label>
        <input type="text" name="note" id="note" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="/outgoing" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
