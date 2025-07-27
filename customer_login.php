<?php
// Mulai session dan panggil file konfigurasi
session_start();
require 'admin/config/database.php';
require 'admin/config/functions.php';

// Jika customer sudah login, arahkan ke halaman utama
if (isset($_SESSION['customer_id'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit();
}

// Proses form jika ada data yang dikirim (method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cari customer berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM customer WHERE username = ?");
    $stmt->execute([$username]);
    $customer = $stmt->fetch();

    // Verifikasi password
    if ($customer && password_verify($password, $customer['password'])) {
        // Jika berhasil, buat session
        $_SESSION['customer_id'] = $customer['id_customer'];
        $_SESSION['customer_name'] = $customer['nama_customer'];
        $_SESSION['customer_username'] = $customer['username'];

        // Arahkan ke halaman utama setelah login sukses
        header('Location: ' . BASE_URL . '/index.php');
        exit();
    } else {
        // Jika gagal, set pesan error
        $error_message = "Username atau password salah!";
    }
}
?>
<?php include 'templates_customer/header_auth.php'; // Kita akan buat header khusus untuk auth ?>

<div class="card shadow-lg">
    <div class="card-body p-5">
        <h1 class="fs-4 card-title fw-bold mb-4">Customer Login</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['register']) && $_GET['register'] == 'success'): ?>
            <div class="alert alert-success">Registrasi berhasil! Silakan login.</div>
        <?php endif; ?>

        <form method="POST" action="customer_login.php">
            <div class="mb-3">
                <label class="mb-2 text-muted" for="username">Username</label>
                <input id="username" type="text" class="form-control" name="username" required autofocus>
            </div>
            <div class="mb-3">
                <div class="mb-2 w-100">
                    <label class="text-muted" for="password">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-primary ms-auto">
                    Login
                </button>
            </div>
        </form>
    </div>
    <div class="card-footer py-3 border-0">
        <div class="text-center">
            Belum punya akun? <a href="customer_register.php" class="text-dark">Buat Akun</a>
        </div>
    </div>
</div>

<?php include 'templates_customer/footer_auth.php'; ?>