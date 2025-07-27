<?php
include 'templates_customer/header.php';

$cart = $_SESSION['cart'] ?? [];
$total_belanja = 0;
?>

<h1><i class="fas fa-shopping-cart"></i> Keranjang Belanja Anda</h1>

<?php if (empty($cart)): ?>
    <div class="alert alert-info">Keranjang belanja Anda masih kosong. Yuk, mulai belanja!</div>
    <a href="index.php" class="btn btn-primary">Lihat Produk</a>
<?php else: ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th style="width: 15%;">Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $item): ?>
                    <?php 
                        $subtotal = $item['harga_jual'] * $item['quantity'];
                        $total_belanja += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_item']) ?></td>
                        <td><?= format_rupiah($item['harga_jual']) ?></td>
                        <td>
                            <form action="proses_cart.php" method="POST" class="d-flex">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id_item" value="<?= $id ?>">
                                <input type="number" name="quantity" class="form-control form-control-sm" value="<?= $item['quantity'] ?>" min="1">
                                <button type="submit" class="btn btn-sm btn-outline-secondary ms-1"><i class="fas fa-sync"></i></button>
                            </form>
                        </td>
                        <td><?= format_rupiah($subtotal) ?></td>
                        <td>
                             <form action="proses_cart.php" method="POST">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id_item" value="<?= $id ?>">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total Belanja</th>
                    <th colspan="2"><?= format_rupiah($total_belanja) ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        <a href="checkout.php" class="btn btn-success btn-lg">Lanjutkan ke Checkout <i class="fas fa-arrow-right"></i></a>
    </div>
<?php endif; ?>

<?php include 'templates_customer/footer.php'; ?>