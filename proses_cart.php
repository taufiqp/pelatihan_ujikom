<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id_item = $_POST['id_item'];

    switch ($action) {
        case 'add':
            $quantity = (int)$_POST['quantity'];
            if ($quantity > 0) {
                if (isset($_SESSION['cart'][$id_item])) {
                    $_SESSION['cart'][$id_item]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$id_item] = [
                        'nama_item' => $_POST['nama_item'],
                        'harga_jual' => $_POST['harga_jual'],
                        'quantity' => $quantity
                    ];
                }
            }
            break;

        case 'update':
            $quantity = (int)$_POST['quantity'];
            if ($quantity > 0) {
                $_SESSION['cart'][$id_item]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$id_item]);
            }
            break;

        case 'remove':
            unset($_SESSION['cart'][$id_item]);
            break;
    }
}
// Redirect kembali ke halaman keranjang
header('Location: cart.php');
exit();