<?php 
// Sertakan header dan sidebar
include '../../templates/header.php'; 
include '../../templates/sidebar.php'; 

// Ambil semua data item dari database
$stmt = $pdo->query("SELECT * FROM item ORDER BY nama_item ASC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Item</h1>
</div>

<a href="tambah.php" class="btn btn-primary mb-3">Tambah Item Baru</a>

<?php if(isset($_GET['status']) && $_GET['status'] == 'sukses_tambah'): ?>
    <div class="alert alert-success" role="alert">
        Item berhasil ditambahkan!
    </div>
<?php elseif(isset($_GET['status']) && $_GET['status'] == 'sukses_edit'): ?>
    <div class="alert alert-success" role="alert">
        Item berhasil diperbarui!
    </div>
<?php elseif(isset($_GET['status']) && $_GET['status'] == 'sukses_hapus'): ?>
     <div class="alert alert-success" role="alert">
        Item berhasil dihapus!
    </div>
<?php endif; ?>


<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Item</th>
                <th scope="col">Nama Item</th>
                <th scope="col">Satuan</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($items) > 0): ?>
                <?php $no = 1; foreach ($items as $item): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($item['kode_item']); ?></td>
                    <td><?= htmlspecialchars($item['nama_item']); ?></td>
                    <td><?= htmlspecialchars($item['satuan']); ?></td>
                    <td>Rp <?= number_format($item['harga_jual'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($item['stok']); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $item['id_item']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="proses.php?action=hapus&id=<?= $item['id_item']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Belum ada data item.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
// Sertakan footer
include '../../templates/footer.php'; 
?>