<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/functions.php';

check_access(['petugas', 'manager', 'admin_super', 'sales']);

// Proses Tambah
if (isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $stmt = $pdo->prepare(
        "INSERT INTO sales (tgl_sales, no_faktur, id_customer, status, id_user, total_bayar) 
         VALUES (?, ?, ?, ?, ?, 0)"
    );
    $stmt->execute([$_POST['tgl_sales'], $_POST['no_faktur'], $_POST['id_customer'], $_POST['status'], $_SESSION['user_id']]);
    set_flash_message('success', 'Data penjualan berhasil dicatat.');
    header('Location: data.php');
}

// Proses Edit (hanya contoh, bisa dikembangkan)
// ...
?>