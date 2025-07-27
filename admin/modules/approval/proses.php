<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/functions.php';

// Hanya manager dan admin super yang bisa mengakses file proses ini
check_access(['manager', 'admin_super']);

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    header('Location: data.php');
    exit();
}

$id_sales = $_GET['id'];
$action = $_GET['action'];

// Mulai Database Transaction untuk menjaga integritas data
$pdo->beginTransaction();

try {
    if ($action == 'approve') {
        $stmt = $pdo->prepare("UPDATE sales SET status = 'approved' WHERE id_sales = ?");
        $stmt->execute([$id_sales]);
        set_flash_message('success', 'Transaksi berhasil disetujui.');

    } elseif ($action == 'reject') {
        // 1. Ubah status transaksi menjadi 'rejected'
        $stmt_reject = $pdo->prepare("UPDATE sales SET status = 'rejected' WHERE id_sales = ?");
        $stmt_reject->execute([$id_sales]);

        // 2. Ambil semua item dari transaksi yang ditolak
        $stmt_items = $pdo->prepare("SELECT id_item, quantity FROM sales_detail WHERE id_sales = ?");
        $stmt_items->execute([$id_sales]);
        $items_to_return = $stmt_items->fetchAll();

        // 3. Kembalikan stok untuk setiap item
        $stmt_update_stok = $pdo->prepare("UPDATE item SET stok = stok + ? WHERE id_item = ?");
        foreach ($items_to_return as $item) {
            $stmt_update_stok->execute([$item['quantity'], $item['id_item']]);
        }
        
        set_flash_message('info', 'Transaksi telah ditolak dan stok telah dikembalikan.');
    }
    
    // Jika semua proses berhasil, commit perubahan
    $pdo->commit();

} catch (Exception $e) {
    // Jika ada satu saja error, batalkan semua perubahan
    $pdo->rollBack();
    set_flash_message('error', 'Terjadi kesalahan: ' . $e->getMessage());
}

header('Location: data.php');
exit();
?>