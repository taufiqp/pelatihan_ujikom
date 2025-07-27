<?php
require 'admin/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi dasar
    if (empty($nama_lengkap) || empty($username) || empty($password)) {
        die("Semua field harus diisi.");
    }

    // Hash password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Tetapkan level terendah secara default untuk keamanan
    $level = 'petugas';

    try {
        // Cek apakah username sudah ada
        $stmt_check = $pdo->prepare("SELECT id_user FROM users WHERE username = ?");
        $stmt_check->execute([$username]);
        if ($stmt_check->fetch()) {
            die("Username sudah digunakan. Silakan pilih username lain. <a href='registrasi_publik.php'>Kembali</a>");
        }

        // Simpan ke database
        $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, username, password, level) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama_lengkap, $username, $hashed_password, $level]);

        // Redirect ke halaman login dengan pesan sukses
        header('Location: login.php?reg_success=1');
        exit();

    } catch (PDOException $e) {
        die("Registrasi gagal: " . $e->getMessage());
    }
}
?>