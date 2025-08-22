<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<form action="<?= site_url('incoming') ?>" method="post">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Pilih Pembelian</label>
    <select name="purchase_id" id="purchaseSelect" class="form-select" required>
      <option value="">-- pilih pembelian --</option>
      <?php foreach ($purchases as $p): ?>
        <option value="<?= $p['id'] ?>">ID #<?= $p['id'] ?> - <?= $p['purchase_date'] ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Pilih Item</label>
    <select name="purchase_item_id" id="itemSelect" class="form-select" required>
      <option value="">-- pilih item --</option>
    </select>
  </div>

  <button type="submit" class="btn btn-success">Simpan</button>
  <a href="<?= site_url('incoming') ?>" class="btn btn-secondary">Batal</a>
</form>

<script>
// ketika pilih purchase → fetch item
document.getElementById('purchaseSelect').addEventListener('change', async function() {
    const purchaseId = this.value;
    const itemSelect = document.getElementById('itemSelect');
    itemSelect.innerHTML = '<option>Loading...</option>';

    if (purchaseId) {
        const res = await fetch('/api/purchase-items/' + purchaseId);
        const items = await res.json();
        let html = '<option value="">-- pilih item --</option>';
        items.forEach(i => {
            html += `<option value="${i.id}">${i.product_name} - Qty: ${i.quantity}</option>`;
        });
        itemSelect.innerHTML = html;
    } else {
        itemSelect.innerHTML = '<option value="">-- pilih item --</option>';
    }
});
</script>

<?= $this->endSection() ?>
