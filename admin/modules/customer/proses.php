<?php
session_start();
include '../../config/database.php';
if (!isset($_SESSION['user_id'])) { die("Akses ditolak."); }

// Proses Tambah
if (isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $stmt = $pdo->prepare("INSERT INTO customer (nama_customer, alamat, telp, email) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['nama_customer'], $_POST['alamat'], $_POST['telp'], $_POST['email']]);
    header('Location: data.php?status=sukses_tambah');
}

// Proses Edit
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $stmt = $pdo->prepare("UPDATE customer SET nama_customer=?, alamat=?, telp=?, email=? WHERE id_customer=?");
    $stmt->execute([$_POST['nama_customer'], $_POST['alamat'], $_POST['telp'], $_POST['email'], $_POST['id_customer']]);
    header('Location: data.php?status=sukses_edit');
}

// Proses Hapus
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    try {
        $stmt = $pdo->prepare("DELETE FROM customer WHERE id_customer = ?");
        $stmt->execute([$_GET['id']]);
        header('Location: data.php?status=sukses_hapus');
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
             die("Error: Customer tidak dapat dihapus karena sudah terikat dengan data penjualan.");
        }
        die("Error: " . $e->getMessage());
    }
}
?>