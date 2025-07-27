<?php 
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 
?>
<h1 class="h2">Tambah Customer Baru</h1>
<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="tambah">
        <div class="mb-3"><label class="form-label">Nama Customer</label><input type="text" class="form-control" name="nama_customer" required></div>
        <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" name="alamat" required></textarea></div>
        <div class="mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control" name="telp" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email"></div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>