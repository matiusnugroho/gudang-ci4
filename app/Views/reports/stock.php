<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Produk</th>
            <th>Stok Terkini</th>
        </tr>
    </thead>
    <tbody>
        <?php if (! empty($stock)): ?>
            <?php foreach ($stock as $row): ?>
                <tr>
                    <td><?= esc($row['code']) ?></td>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= esc($row['stock']) ?></td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center">Tidak ada data</td></tr>
        <?php endif ?>
    </tbody>
</table>

<?= $this->endSection() ?>