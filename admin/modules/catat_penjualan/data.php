<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';

// Semua role (termasuk 'sales') bisa melihat data ini
check_access(['petugas', 'manager', 'admin_super', 'sales']);

// Ambil data penjualan (bukan detail item)
$query = "SELECT s.id_sales, s.no_faktur, s.tgl_sales, s.status, c.nama_customer
          FROM sales s
          JOIN customer c ON s.id_customer = c.id_customer
          ORDER BY s.tgl_sales DESC";
$stmt = $pdo->query($query);
$sales_records = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-clipboard-list"></i> Pencatatan Penjualan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="tambah.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Catat Penjualan Baru
        </a>
    </div>
</div>

<?php display_flash_message(); ?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. DO / Faktur</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales_records as $record): ?>
            <tr>
                <td><?= date('d M Y', strtotime($record['tgl_sales'])) ?></td>
                <td><?= htmlspecialchars($record['no_faktur']) ?></td>
                <td><?= htmlspecialchars($record['nama_customer']) ?></td>
                <td>
                    <span class="badge 
                        <?php 
                            if($record['status'] == 'approved') echo 'bg-success';
                            elseif($record['status'] == 'pending') echo 'bg-warning';
                            else echo 'bg-danger'; 
                        ?>">
                        <?= ucfirst($record['status']) ?>
                    </span>
                </td>
               <td class="text-center">
    <a href="edit.php?id=<?= $record['id_sales'] ?>" class="btn btn-warning btn-sm" title="Edit">
        <i class="fas fa-pencil-alt"></i> Edit
    </a>
</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../templates/footer.php'; ?>