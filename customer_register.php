<?php
session_start();
require 'admin/config/database.php';
require 'admin/config/functions.php';

if (isset($_SESSION['customer_id'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit();
}

// Proses form jika ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil semua data dari form
    $nama_customer = $_POST['nama_customer'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi dasar
    if (empty($nama_customer) || empty($alamat) || empty($telp) || empty($username) || empty($password)) {
        $error_message = "Semua field wajib diisi!";
    } else {
        // Cek apakah username atau email sudah ada
        $stmt_check = $pdo->prepare("SELECT id_customer FROM customer WHERE username = ? OR email = ?");
        $stmt_check->execute([$username, $email]);
        if ($stmt_check->fetch()) {
            $error_message = "Username atau Email sudah terdaftar!";
        } else {
            // Jika aman, hash password dan simpan data
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt_insert = $pdo->prepare(
                "INSERT INTO customer (nama_customer, alamat, telp, email, username, password) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt_insert->execute([$nama_customer, $alamat, $telp, $email, $username, $hashed_password]);

            // Redirect ke halaman login dengan pesan sukses
            header('Location: ' . BASE_URL . '/customer_login.php?register=success');
            exit();
        }
    }
}
?>
<?php include 'templates_customer/header_auth.php'; ?>

<div class="card shadow-lg">
    <div class="card-body p-5">
        <h1 class="fs-4 card-title fw-bold mb-4">Registrasi Customer</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <form method="POST" action="customer_register.php">
            <div class="mb-3">
                <label class="mb-2 text-muted" for="nama_customer">Nama Lengkap</label>
                <input id="nama_customer" type="text" class="form-control" name="nama_customer" required autofocus>
            </div>
            <div class="mb-3">
                <label class="mb-2 text-muted" for="alamat">Alamat Lengkap</label>
                <textarea id="alamat" class="form-control" name="alamat" required></textarea>
            </div>
            <div class="mb-3">
                <label class="mb-2 text-muted" for="telp">No. Telepon</label>
                <input id="telp" type="text" class="form-control" name="telp" required>
            </div>
            <div class="mb-3">
                <label class="mb-2 text-muted" for="email">Alamat Email</label>
                <input id="email" type="email" class="form-control" name="email">
            </div>
            <hr>
            <div class="mb-3">
                <label class="mb-2 text-muted" for="username">Username</label>
                <input id="username" type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="mb-2 text-muted" for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <p class="form-text text-muted mb-3">
                Dengan mendaftar, Anda menyetujui Syarat dan Ketentuan kami.
            </p>
            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-primary ms-auto">
                    Register
                </button>
            </div>
        </form>
    </div>
    <div class="card-footer py-3 border-0">
        <div class="text-center">
            Sudah punya akun? <a href="customer_login.php" class="text-dark">Login</a>
        </div>
    </div>
</div>

<?php include 'templates_customer/footer_auth.php'; ?>