<?php 
// Sertakan header dan sidebar
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 

// Periksa apakah ID ada di URL
if (!isset($_GET['id'])) {
    header('Location: data.php');
    exit();
}

$id = $_GET['id'];

// Ambil data item berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM item WHERE id_item = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika item tidak ditemukan
if (!$item) {
    header('Location: data.php');
    exit();
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Item</h1>
</div>

<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id_item" value="<?= $item['id_item']; ?>">
        
        <div class="mb-3">
            <label for="kode_item" class="form-label">Kode Item</label>
            <input type="text" class="form-control" id="kode_item" name="kode_item" required value="<?= htmlspecialchars($item['kode_item']); ?>">
        </div>
        
        <div class="mb-3">
            <label for="nama_item" class="form-label">Nama Item</label>
            <input type="text" class="form-control" id="nama_item" name="nama_item" required value="<?= htmlspecialchars($item['nama_item']); ?>">
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <input type="text" class="form-control" id="satuan" name="satuan" required value="<?= htmlspecialchars($item['satuan']); ?>">
        </div>
        
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" required value="<?= htmlspecialchars($item['harga_jual']); ?>">
        </div>
        
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required value="<?= htmlspecialchars($item['stok']); ?>">
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="data.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php 
include '../../templates/footer.php'; 
?>