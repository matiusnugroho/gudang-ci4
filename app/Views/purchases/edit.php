<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<form action="<?= site_url('purchases/'.$purchase['id']) ?>" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="_method" value="PUT">

  <div class="mb-3">
    <label class="form-label">Vendor</label>
    <select name="vendor_id" class="form-select" required>
      <?php foreach ($vendors as $v): ?>
        <option value="<?= $v['id'] ?>" <?= $v['id']==$purchase['vendor_id']?'selected':'' ?>>
          <?= esc($v['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="purchase_date" class="form-control"
           value="<?= $purchase['purchase_date'] ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Nama Pembeli</label>
    <input type="text" name="buyer_name" class="form-control"
           value="<?= esc($purchase['buyer_name']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control"><?= esc($purchase['notes']) ?></textarea>
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
      <?php $rowIndex=0; foreach ($items as $it): ?>
      <tr>
        <td>
          <select name="items[<?= $rowIndex ?>][product_id]" class="form-select">
            <?php foreach ($products as $p): ?>
              <option value="<?= $p['id'] ?>" <?= $p['id']==$it['product_id']?'selected':'' ?>>
                <?= esc($p['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
        <td><input type="number" name="items[<?= $rowIndex ?>][quantity]"
                   class="form-control" value="<?= $it['quantity'] ?>" required></td>
        <td><input type="number" step="0.01" name="items[<?= $rowIndex ?>][unit_price]"
                   class="form-control" value="<?= $it['unit_price'] ?>"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
      </tr>
      <?php $rowIndex++; endforeach; ?>
    </tbody>
  </table>
  <button type="button" class="btn btn-secondary mb-3" id="addRow">+ Tambah Barang</button>

  <button type="submit" class="btn btn-primary">Update</button>
  <a href="<?= site_url('purchases/'.$purchase['id']) ?>" class="btn btn-secondary">Batal</a>
</form>

<script>
let rowIndex = <?= $rowIndex ?>;
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
