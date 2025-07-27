<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';

// Cek hak akses untuk semua role yang diizinkan
check_access(['petugas', 'manager', 'admin_super', 'sales']);

// --- LOGIKA PENGAMBILAN DATA ---

// 1. Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    set_flash_message('error', 'ID penjualan tidak valid.');
    header('Location: data.php');
    exit();
}
$id_sales = $_GET['id'];

// 2. Ambil data penjualan yang akan di-edit
$stmt = $pdo->prepare("SELECT * FROM sales WHERE id_sales = ?");
$stmt->execute([$id_sales]);
$sale = $stmt->fetch();

// Jika data tidak ditemukan, kembalikan ke halaman data
if (!$sale) {
    set_flash_message('error', 'Data penjualan tidak ditemukan.');
    header('Location: data.php');
    exit();
}

// 3. Ambil semua data customer untuk dropdown
$customers = $pdo->query("SELECT id_customer, nama_customer FROM customer ORDER BY nama_customer")->fetchAll();
?>

<h1 class="h2">Edit Catatan Penjualan</h1>
<p class="text-muted">Mengubah data untuk No. Faktur: <strong><?= htmlspecialchars($sale['no_faktur']) ?></strong></p>

<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id_sales" value="<?= $sale['id_sales'] ?>">
        
        <div class="mb-3">
            <label for="tgl_sales" class="form-label">Tanggal Penjualan</label>
            <input type="date" class="form-control" id="tgl_sales" name="tgl_sales" value="<?= htmlspecialchars($sale['tgl_sales']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="no_faktur" class="form-label">Nomor DO (Delivery Order) / Faktur</label>
            <input type="text" class="form-control" id="no_faktur" name="no_faktur" value="<?= htmlspecialchars($sale['no_faktur']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_customer" class="form-label">Customer</label>
            <select name="id_customer" id="id_customer" class="form-select" required>
                <option value="">-- Pilih Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['id_customer'] ?>" <?= ($customer['id_customer'] == $sale['id_customer']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($customer['nama_customer']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status Transaksi</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" <?= ($sale['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= ($sale['status'] == 'approved') ? 'selected' : '' ?>>Approved (Selesai)</option>
                <option value="rejected" <?= ($sale['status'] == 'rejected') ? 'selected' : '' ?>>Rejected (Ditolak)</option>
            </select>
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="data.php" class="btn btn-outline-secondary"><i class="fas fa-times-circle"></i> Batal</a>
        </div>
    </form>
</div>

<?php include '../../templates/footer.php'; ?>