<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login.");
}

if (isset($_POST['action']) && $_POST['action'] == 'tambah') {
    // Ambil data dari form
    $id_customer = $_POST['id_customer'];
    $no_faktur = $_POST['no_faktur'];
    $keterangan = $_POST['keterangan'];
    $items = $_POST['items'];
    $id_user = $_SESSION['user_id'];
    $total_bayar = 0;

    // Validasi dasar
    if (empty($id_customer) || empty($items)) {
        die("Data tidak lengkap. Customer dan minimal 1 item harus dipilih.");
    }

    // Hitung total bayar
    foreach ($items as $item) {
        $total_bayar += $item['harga'] * $item['qty'];
    }

    // Mulai Database Transaction
    $pdo->beginTransaction();

    try {
        // 1. Simpan ke tabel `sales` (header)
        $stmt_sales = $pdo->prepare(
            "INSERT INTO sales (no_faktur, tgl_sales, id_customer, id_user, total_bayar, status, keterangan) 
             VALUES (?, NOW(), ?, ?, ?, 'approved', ?)"
        );
        $stmt_sales->execute([$no_faktur, $id_customer, $id_user, $total_bayar, $keterangan]);

        // Ambil ID dari sales yang baru saja disimpan
        $id_sales = $pdo->lastInsertId();

        // 2. Looping untuk simpan ke `sales_detail` dan update stok
        $stmt_detail = $pdo->prepare(
            "INSERT INTO sales_detail (id_sales, id_item, quantity, harga_saat_transaksi, subtotal) 
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt_update_stok = $pdo->prepare(
            "UPDATE item SET stok = stok - ? WHERE id_item = ?"
        );

        foreach ($items as $item) {
            $id_item = $item['id'];
            $qty = $item['qty'];
            $harga = $item['harga'];
            $subtotal = $qty * $harga;

            // Simpan ke detail
            $stmt_detail->execute([$id_sales, $id_item, $qty, $harga, $subtotal]);

            // Update stok
            $stmt_update_stok->execute([$qty, $id_item]);
        }

        // Jika semua berhasil, commit transaksi
        $pdo->commit();

        header('Location: data.php?status=sukses');
        exit();

    } catch (Exception $e) {
        // Jika ada satu saja error, batalkan semua (rollback)
        $pdo->rollBack();
        die("Transaksi gagal: " . $e->getMessage());
    }
}
?>