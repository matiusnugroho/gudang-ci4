<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<form action="<?= site_url('purchases') ?>" method="post">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Vendor</label>
    <select name="vendor_id" class="form-select" required>
      <option value="">-- pilih vendor --</option>
      <?php foreach ($vendors as $v): ?>
        <option value="<?= $v['id'] ?>"><?= esc($v['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="purchase_date" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Nama Pembeli</label>
    <input type="text" name="buyer_name" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control"></textarea>
  </div>

  <h3>Detail Barang</h3>
  <table class="table" id="itemsTable">
    <thead>
      <tr>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <select name="items[0][product_id]" class="form-select">
            <?php foreach ($products as $p): ?>
              <option value="<?= $p['id'] ?>"><?= esc($p['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
        <td><input type="number" step="0.01" name="items[0][unit_price]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
      </tr>
    </tbody>
  </table>
  <button type="button" class="btn btn-secondary mb-3" id="addRow">+ Tambah Barang</button>

  <button type="submit" class="btn btn-success">Simpan</button>
  <a href="<?= site_url('purchases') ?>" class="btn btn-secondary">Batal</a>
</form>

<script>
let rowIndex = 1;
document.getElementById('addRow').addEventListener('click', function () {
  const tbody = document.querySelector('#itemsTable tbody');
  const newRow = document.createElement('tr');
  newRow.innerHTML = `
    <td>
      <select name="items[${rowIndex}][product_id]" class="form-select">
        <?php foreach ($products as $p): ?>
          <option value="<?= $p['id'] ?>"><?= esc($p['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </td>
    <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control" required></td>
    <td><input type="number" step="0.01" name="items[${rowIndex}][unit_price]" class="form-control"></td>
    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
  `;
  tbody.appendChild(newRow);
  rowIndex++;
});

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('removeRow')) {
    e.target.closest('tr').remove();
  }
});
</script>

<?= $this->endSection() ?>
