<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';
check_access(['petugas', 'manager', 'admin_super', 'sales']);

// Ambil data customer untuk dropdown
$customers = $pdo->query("SELECT id_customer, nama_customer FROM customer ORDER BY nama_customer")->fetchAll();
?>

<h1 class="h2">Catat Penjualan Baru</h1>
<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="tambah">
        
        <div class="mb-3">
            <label for="tgl_sales" class="form-label">Tanggal Penjualan</label>
            <input type="date" class="form-control" id="tgl_sales" name="tgl_sales" value="<?= date('Y-m-d') ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="no_faktur" class="form-label">Nomor DO (Delivery Order) / Faktur</label>
            <input type="text" class="form-control" id="no_faktur" name="no_faktur" required>
        </div>

        <div class="mb-3">
            <label for="id_customer" class="form-label">Customer</label>
            <select name="id_customer" id="id_customer" class="form-select" required>
                <option value="">-- Pilih Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['id_customer'] ?>"><?= htmlspecialchars($customer['nama_customer']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status Transaksi</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="data.php" class="btn btn-outline-secondary"><i class="fas fa-times-circle"></i> Batal</a>
        </div>
    </form>
</div>

<?php include '../../templates/footer.php'; ?>