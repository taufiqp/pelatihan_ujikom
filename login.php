<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Koperasi</title>
    <link href="admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { max-width: 400px; width: 100%; padding: 2rem; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h3 class="text-center mb-4">Aplikasi Koperasi</h3>
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">Username atau password salah!</div>
            <?php endif; ?>
             <?php if(isset($_GET['logout'])): ?>
                <div class="alert alert-success">Anda berhasil logout.</div>
            <?php endif; ?>
             <?php if(isset($_GET['reg_success'])): ?>
                <div class="alert alert-success">Registrasi berhasil! Silakan login.</div>
            <?php endif; ?>
            <form action="proses_login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            
            <div class="text-center mt-3">
                <p>Belum punya akun? <a href="registrasi_publik.php">Daftar di sini</a></p>
            </div>
            
        </div>
    </div>
    <script src="admin/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>