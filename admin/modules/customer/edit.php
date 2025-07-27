<?php 
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM customer WHERE id_customer = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch();
?>
<h1 class="h2">Edit Customer</h1>
<div class="col-lg-8">
    <form action="proses.php" method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id_customer" value="<?= $customer['id_customer']; ?>">
        <div class="mb-3"><label class="form-label">Nama Customer</label><input type="text" class="form-control" name="nama_customer" value="<?= htmlspecialchars($customer['nama_customer']); ?>" required></div>
        <div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" name="alamat" required><?= htmlspecialchars($customer['alamat']); ?></textarea></div>
        <div class="mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control" name="telp" value="<?= htmlspecialchars($customer['telp']); ?>" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= htmlspecialchars($customer['email']); ?>"></div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="data.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php include '../../templates/footer.php'; ?>