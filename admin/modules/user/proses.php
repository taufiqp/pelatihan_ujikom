<?php
session_start();
include '../../config/database.php';
if ($_SESSION['level'] != 'admin_super') { die("Akses Ditolak!"); }

// Proses Tambah
if (isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, username, password, level) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['nama_lengkap'], $_POST['username'], $password, $_POST['level']]);
    header('Location: data.php?status=sukses_tambah');
}

// Proses Edit
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET nama_lengkap=?, username=?, password=?, level=? WHERE id_user=?");
        $stmt->execute([$_POST['nama_lengkap'], $_POST['username'], $password, $_POST['level'], $_POST['id_user']]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET nama_lengkap=?, username=?, level=? WHERE id_user=?");
        $stmt->execute([$_POST['nama_lengkap'], $_POST['username'], $_POST['level'], $_POST['id_user']]);
    }
    header('Location: data.php?status=sukses_edit');
}

// Proses Hapus
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_user = $_GET['id'];
    if ($id_user == $_SESSION['user_id']) { die("Tidak bisa menghapus diri sendiri."); }
    $stmt = $pdo->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->execute([$id_user]);
    header('Location: data.php?status=sukses_hapus');
}
?>