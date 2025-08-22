<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>
<form method="get" action="<?= site_url('reports/incoming') ?>" class="row g-3 mb-3">
    <div class="col-auto">
        <input type="date" name="start_date" class="form-control" value="<?= esc($start_date ?? '') ?>">
    </div>
    <div class="col-auto">
        <input type="date" name="end_date" class="form-control" value="<?= esc($end_date ?? '') ?>">
    </div>
    <div class="col-auto">
        <button class="btn btn-primary" type="submit">Filter</button>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Tanggal Pembelian</th>
            <th>Produk</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php if (! empty($incoming)): ?>
            <?php foreach ($incoming as $row): ?>
                <tr>
                    <td><?= esc($row['purchase_date']) ?></td> <!-- pakai purchase_date -->
                    <td><?= esc($row['product_name']) ?></td>
                    <td><?= esc($row['quantity']) ?></td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center">Tidak ada data</td></tr>
        <?php endif ?>
    </tbody>
</table>

<?= $this->endSection() ?>