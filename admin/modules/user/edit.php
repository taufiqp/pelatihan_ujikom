<?php 
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 
if ($_SESSION['level'] != 'admin_super') { die("Akses Ditolak!"); }
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
?>
<h1 class="h2">Edit User</h1>
<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
        <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']); ?>" required></div>
        <div class="mb-3"><label class="form-label">Username</label><input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']); ?>" required></div>
        <div class="mb-3"><label class="form-label">Password</label><small class="form-text text-muted"> (Kosongkan jika tidak ingin mengubah password)</small><input type="password" class="form-control" name="password"></div>
        <div class="mb-3"><label class="form-label">Level</label>
            <select name="level" class="form-select" required>
                <option value="petugas" <?= $user['level'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                <option value="manager" <?= $user['level'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                <option value="admin_super" <?= $user['level'] == 'admin_super' ? 'selected' : '' ?>>Admin Super</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>