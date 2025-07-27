<?php
// Memasukkan file header, yang sudah berisi session_start() dan koneksi DB
include '../../templates/header.php';

// Memasukkan fungsi-fungsi bantuan, termasuk check_access()
require_once '../../config/functions.php';

// Fungsi ini akan menghentikan eksekusi jika user bukan admin_super
check_access(['admin_super']);

// Memasukkan sidebar
include '../../templates/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrasi Pengguna Baru</h1>
</div>

<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="tambah">
        
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
        </div>
        
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <div class="mb-3">
            <label for="level" class="form-label">Level Akses</label>
            <select name="level" id="level" class="form-select" required>
                <option value="" disabled selected>-- Pilih Level Akses --</option>
                <option value="petugas">Petugas</option>
                <option value="manager">Manager</option>
                <option value="admin_super">Admin Super</option> </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Daftarkan Pengguna</button>
        <a href="data.php" class="btn btn-secondary">Kembali ke Daftar User</a>
    </form>
</div>

<?php 
// Memasukkan file footer
include '../../templates/footer.php'; 
?>