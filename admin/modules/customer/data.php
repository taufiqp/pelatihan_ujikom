<?php 
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 

$stmt = $pdo->query("SELECT * FROM customer ORDER BY nama_customer ASC");
$customers = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Customer</h1>
</div>
<a href="tambah.php" class="btn btn-primary mb-3">Tambah Customer Baru</a>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead><tr><th>#</th><th>Nama Customer</th><th>Alamat</th><th>Telepon</th><th>Email</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php $no = 1; foreach ($customers as $customer): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($customer['nama_customer']); ?></td>
                <td><?= htmlspecialchars($customer['alamat']); ?></td>
                <td><?= htmlspecialchars($customer['telp']); ?></td>
                <td><?= htmlspecialchars($customer['email']); ?></td>
                <td>
                    <a href="edit.php?id=<?= $customer['id_customer']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="proses.php?action=hapus&id=<?= $customer['id_customer']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?');">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../../templates/footer.php'; ?>