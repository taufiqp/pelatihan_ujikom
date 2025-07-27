<?php
session_start();
require 'admin/config/database.php';

// Wajib login dan keranjang tidak boleh kosong
if (!isset($_SESSION['customer_id']) || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];
$cart = $_SESSION['cart'];
$no_faktur = "INV/CUST/" . date('YmdHis');
$total_bayar = 0;

foreach ($cart as $item) {
    $total_bayar += $item['harga_jual'] * $item['quantity'];
}

// Gunakan ID 1 (Admin Super) sebagai petugas default, atau sesuaikan
$id_user_petugas = 1; 

$pdo->beginTransaction();
try {
    // 1. Simpan ke tabel `sales`
    $stmt_sales = $pdo->prepare(
        "INSERT INTO sales (no_faktur, id_customer, id_user, total_bayar, status) 
         VALUES (?, ?, ?, ?, 'pending')"
    );
    $stmt_sales->execute([$no_faktur, $customer_id, $id_user_petugas, $total_bayar]);
    $id_sales = $pdo->lastInsertId();

    // 2. Simpan detail dan kurangi stok
    $stmt_detail = $pdo->prepare(
        "INSERT INTO sales_detail (id_sales, id_item, quantity, harga_saat_transaksi, subtotal) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt_update_stok = $pdo->prepare(
        "UPDATE item SET stok = stok - ? WHERE id_item = ?"
    );

    foreach ($cart as $id_item => $item) {
        $subtotal = $item['harga_jual'] * $item['quantity'];
        $stmt_detail->execute([$id_sales, $id_item, $item['quantity'], $item['harga_jual'], $subtotal]);
        $stmt_update_stok->execute([$item['quantity'], $id_item]);
    }

    $pdo->commit();
    unset($_SESSION['cart']); // Kosongkan keranjang setelah berhasil

    // === PERUBAHAN UTAMA DI SINI ===
    // Arahkan ke halaman sukses dengan membawa nomor faktur
    header('Location: ' . BASE_URL . '/order_sukses.php?faktur=' . urlencode($no_faktur));
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    die("Terjadi kesalahan saat memproses pesanan: " . $e->getMessage());
}
?>