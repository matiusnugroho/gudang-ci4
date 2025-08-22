<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<a href="<?= site_url('purchases/new') ?>" class="btn btn-primary mb-3">Tambah Pembelian</a>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tanggal</th>
      <th>Vendor</th>
      <th>Pembeli</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($purchases): ?>
      <?php foreach ($purchases as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= $p['purchase_date'] ?></td>
          <td><?= esc($p['vendor_name']) ?></td>
          <td><?= esc($p['buyer_name']) ?></td>
          <td><?= esc($p['status']) ?></td>
          <td>
            <a href="<?= site_url('purchases/'.$p['id']) ?>" class="btn btn-info btn-sm">Detail</a>
            <a href="<?= site_url('purchases/'.$p['id'].'/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
            <form action="<?= site_url('purchases/'.$p['id']) ?>" method="post" style="display:inline;">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pembelian ini?')">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6">Belum ada data pembelian</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?= $this->endSection() ?>
