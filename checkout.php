<?php
include 'templates_customer/header.php';

// Wajibkan login untuk checkout
if (!isset($_SESSION['customer_id'])) {
    set_flash_message('error', 'Anda harus login terlebih dahulu untuk melanjutkan checkout.');
    header('Location: customer_login.php');
    exit();
}
// Pastikan keranjang tidak kosong
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];
$customer = $pdo->query("SELECT * FROM customer WHERE id_customer = $customer_id")->fetch();
$cart = $_SESSION['cart'] ?? [];
$total_belanja = 0;
?>

<h1>Checkout</h1>
<div class="row">
    <div class="col-md-6">
        <h4>Alamat Pengiriman</h4>
        <div class="card">
            <div class="card-body">
                <strong><?= htmlspecialchars($customer['nama_customer']) ?></strong><br>
                <?= htmlspecialchars($customer['alamat']) ?><br>
                <?= htmlspecialchars($customer['telp']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h4>Ringkasan Pesanan</h4>
        <ul class="list-group">
            <?php foreach($cart as $item): 
                $subtotal = $item['harga_jual'] * $item['quantity'];
                $total_belanja += $subtotal;
            ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span><?= htmlspecialchars($item['nama_item']) ?> (x<?= $item['quantity'] ?>)</span>
                    <span><?= format_rupiah($subtotal) ?></span>
                </li>
            <?php endforeach; ?>
            <li class="list-group-item d-flex justify-content-between active">
                <strong>Total</strong>
                <strong><?= format_rupiah($total_belanja) ?></strong>
            </li>
        </ul>
        <form action="proses_order.php" method="POST" class="mt-3">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('Konfirmasi pesanan Anda?')">Buat Pesanan</button>
            </div>
        </form>
    </div>
</div>

<?php include 'templates_customer/footer.php'; ?>