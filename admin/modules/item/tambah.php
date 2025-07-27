<?php 
// Sertakan header dan sidebar
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Item Baru</h1>
</div>

<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="tambah">
        
        <div class="mb-3">
            <label for="kode_item" class="form-label">Kode Item</label>
            <input type="text" class="form-control" id="kode_item" name="kode_item" required>
        </div>
        
        <div class="mb-3">
            <label for="nama_item" class="form-label">Nama Item</label>
            <input type="text" class="form-control" id="nama_item" name="nama_item" required>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan (Contoh: Pcs, Kg, Box)</label>
            <input type="text" class="form-control" id="satuan" name="satuan" required>
        </div>
        
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
        </div>
        
        <div class="mb-3">
            <label for="stok" class="form-label">Stok Awal</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php 
include '../../templates/footer.php'; 
?>