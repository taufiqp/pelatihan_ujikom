<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Aplikasi Koperasi</title>
    <link href="admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .reg-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .reg-card { max-width: 450px; width: 100%; padding: 2rem; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff; }
    </style>
</head>
<body>
    <div class="reg-container">
        <div class="reg-card">
            <h3 class="text-center mb-4">Registrasi Akun Baru</h3>
            <p class="text-center text-muted small">Semua akun baru akan didaftarkan sebagai 'Petugas'.</p>
            <form action="proses_registrasi_publik.php" method="POST">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>
            <div class="text-center mt-3">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>