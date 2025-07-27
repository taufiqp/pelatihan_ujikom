<?php
// === KONFIGURASI WAJIB ===
// Sesuaikan BASE_URL dengan alamat server Anda.
// Jika pakai XAMPP: define('BASE_URL', 'http://localhost/koperasi_app');
// Jika pakai php -S localhost:3000 : define('BASE_URL', 'http://localhost:3000');
define('BASE_URL', 'http://localhost:3000'); 

// Konfigurasi Database
$host = 'localhost';
$dbname = 'db_koperasi';
$user = 'root';
$pass = ''; // Kosongkan jika tidak ada password

// === KONEKSI DATABASE ===
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>