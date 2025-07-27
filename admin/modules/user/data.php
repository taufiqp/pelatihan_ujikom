<?php 
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 
if ($_SESSION['level'] != 'admin_super') { die("Akses Ditolak!"); }

$stmt = $pdo->query("SELECT * FROM users ORDER BY nama_lengkap ASC");
$users = $stmt->fetchAll();
?>
<h1 class="h2">Manajemen User</h1>
<a href="tambah.php" class="btn btn-primary mb-3">Tambah User</a>
<div class="table-responsive">
    <table class="table table-striped">
        <thead><tr><th>#</th><th>Nama Lengkap</th><th>Username</th><th>Level</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php $no = 1; foreach ($users as $user): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($user['nama_lengkap']); ?></td>
                <td><?= htmlspecialchars($user['username']); ?></td>
                <td><?= htmlspecialchars(ucfirst($user['level'])); ?></td>
                <td>
                    <a href="edit.php?id=<?= $user['id_user']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php if ($user['id_user'] != $_SESSION['user_id']): // Admin tidak bisa hapus diri sendiri ?>
                    <a href="proses.php?action=hapus&id=<?= $user['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?');">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../../templates/footer.php'; ?>