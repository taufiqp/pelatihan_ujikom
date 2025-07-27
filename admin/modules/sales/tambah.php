<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';

// Ambil data customer dan item untuk dropdown
$customers = $pdo->query("SELECT id_customer, nama_customer FROM customer ORDER BY nama_customer")->fetchAll();
$items = $pdo->query("SELECT id_item, nama_item, harga_jual, stok FROM item WHERE stok > 0 ORDER BY nama_item")->fetchAll();
?>

<h1 class="h2">Input Transaksi Baru</h1>

<form action="proses.php" method="POST" id="form-sales">
    <input type="hidden" name="action" value="tambah">

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="id_customer" class="form-label">Customer</label>
                <select name="id_customer" id="id_customer" class="form-select" required>
                    <option value="">-- Pilih Customer --</option>
                    <?php foreach ($customers as $customer) : ?>
                        <option value="<?= $customer['id_customer'] ?>"><?= htmlspecialchars($customer['nama_customer']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="no_faktur" class="form-label">Nomor Faktur</label>
                <input type="text" class="form-control" name="no_faktur" value="INV-<?= date('YmdHis') ?>" readonly>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Pilih Item
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <label for="item_select" class="form-label">Item</label>
                    <select id="item_select" class="form-select">
                        <option value="">-- Pilih Item --</option>
                        <?php foreach ($items as $item) : ?>
                            <option value="<?= $item['id_item'] ?>" data-harga="<?= $item['harga_jual'] ?>" data-stok="<?= $item['stok'] ?>">
                                <?= htmlspecialchars($item['nama_item']) ?> (Stok: <?= $item['stok'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="qty_input" class="form-label">Jumlah</label>
                    <input type="number" id="qty_input" class="form-control" min="1">
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="button" id="btn-tambah-item" class="btn btn-info">Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Keranjang Belanja</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Item</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="keranjang">
            </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th id="total-harga">Rp 0</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
    <a href="data.php" class="btn btn-secondary">Batal</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnTambah = document.getElementById('btn-tambah-item');
    const keranjang = document.getElementById('keranjang');
    const totalHargaEl = document.getElementById('total-harga');

    btnTambah.addEventListener('click', function() {
        const itemSelect = document.getElementById('item_select');
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const qtyInput = document.getElementById('qty_input');

        const itemId = selectedOption.value;
        const itemName = selectedOption.text.split(' (Stok:')[0];
        const itemHarga = parseFloat(selectedOption.getAttribute('data-harga'));
        const itemStok = parseInt(selectedOption.getAttribute('data-stok'));
        const qty = parseInt(qtyInput.value);

        if (!itemId || !qty || qty <= 0) {
            alert('Pilih item dan masukkan jumlah yang valid.');
            return;
        }

        if (qty > itemStok) {
            alert('Stok tidak mencukupi. Stok tersedia: ' + itemStok);
            return;
        }

        // Cek jika item sudah ada di keranjang
        const existingRow = document.querySelector(`#keranjang tr[data-id='${itemId}']`);
        if (existingRow) {
            alert('Item sudah ada di keranjang. Hapus dulu jika ingin mengubah jumlah.');
            return;
        }

        const subtotal = itemHarga * qty;

        const row = document.createElement('tr');
        row.setAttribute('data-id', itemId);
        row.innerHTML = `
            <td>
                ${itemName}
                <input type="hidden" name="items[${itemId}][id]" value="${itemId}">
                <input type="hidden" name="items[${itemId}][harga]" value="${itemHarga}">
            </td>
            <td>${formatRupiah(itemHarga)}</td>
            <td>
                <input type="hidden" name="items[${itemId}][qty]" value="${qty}">${qty}
            </td>
            <td class="subtotal">${formatRupiah(subtotal)}</td>
            <td><button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>
        `;
        keranjang.appendChild(row);

        updateTotal();
        itemSelect.value = '';
        qtyInput.value = '';
    });

    keranjang.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-hapus')) {
            e.target.closest('tr').remove();
            updateTotal();
        }
    });

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('#keranjang tr').forEach(function(row) {
            const harga = parseFloat(row.querySelector('input[name*="[harga]"]').value);
            const qty = parseInt(row.querySelector('input[name*="[qty]"]').value);
            total += harga * qty;
        });
        totalHargaEl.textContent = formatRupiah(total);
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }
});
</script>

<?php
include '../../templates/footer.php';
?>