<?php
// Mulai session dan panggil koneksi database
session_start();
include '../../config/database.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

// Proses untuk TAMBAH data
if (isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $kode_item = $_POST['kode_item'];
    $nama_item = $_POST['nama_item'];
    $satuan = $_POST['satuan'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    try {
        $stmt = $pdo->prepare("INSERT INTO item (kode_item, nama_item, satuan, harga_jual, stok) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$kode_item, $nama_item, $satuan, $harga_jual, $stok]);
        header('Location: data.php?status=sukses_tambah');
        exit();
    } catch (PDOException $e) {
        die("Error saat menambah data: " . $e->getMessage());
    }
}

// Proses untuk EDIT data
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_item = $_POST['id_item'];
    $kode_item = $_POST['kode_item'];
    $nama_item = $_POST['nama_item'];
    $satuan = $_POST['satuan'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    try {
        $stmt = $pdo->prepare("UPDATE item SET kode_item = ?, nama_item = ?, satuan = ?, harga_jual = ?, stok = ? WHERE id_item = ?");
        $stmt->execute([$kode_item, $nama_item, $satuan, $harga_jual, $stok, $id_item]);
        header('Location: data.php?status=sukses_edit');
        exit();
    } catch (PDOException $e) {
        die("Error saat mengubah data: " . $e->getMessage());
    }
}

// Proses untuk HAPUS data
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_item = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM item WHERE id_item = ?");
        $stmt->execute([$id_item]);
        header('Location: data.php?status=sukses_hapus');
        exit();
    } catch (PDOException $e) {
        // Jika item tidak bisa dihapus karena terkait transaksi, berikan pesan error
        if ($e->getCode() == '23000') {
            die("Error: Item tidak dapat dihapus karena sudah digunakan dalam transaksi.");
        }
        die("Error saat menghapus data: " . $e->getMessage());
    }
}
?>