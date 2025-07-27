<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';

// Join tabel sales dengan customer dan users untuk mendapatkan nama
$query = "SELECT s.id_sales, s.no_faktur, s.tgl_sales, s.total_bayar, s.status, c.nama_customer, u.nama_lengkap AS nama_petugas
          FROM sales s
          JOIN customer c ON s.id_customer = c.id_customer
          JOIN users u ON s.id_user = u.id_user
          ORDER BY s.tgl_sales DESC";
$stmt = $pdo->query($query);
$sales = $stmt->fetchAll();
?>
<h1 class="h2">Data Transaksi Penjualan</h1>
<a href="tambah.php" class="btn btn-primary mb-3">Input Transaksi Baru</a>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Petugas</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $sale) : ?>
                <tr>
                    <td><?= htmlspecialchars($sale['no_faktur']); ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($sale['tgl_sales'])); ?></td>
                    <td><?= htmlspecialchars($sale['nama_customer']); ?></td>
                    <td><?= htmlspecialchars($sale['nama_petugas']); ?></td>
                    <td>Rp <?= number_format($sale['total_bayar'], 0, ',', '.'); ?></td>
                    <td>
                        <span class="badge 
                            <?php 
                                if($sale['status'] == 'approved') echo 'bg-success';
                                elseif($sale['status'] == 'pending') echo 'bg-warning';
                                else echo 'bg-danger'; 
                            ?>">
                            <?= ucfirst($sale['status']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="detail.php?id=<?= $sale['id_sales']; ?>" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
include '../../templates/footer.php';
?>