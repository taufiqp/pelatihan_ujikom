<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';

// Fitur ini hanya untuk manager dan admin_super
check_access(['manager', 'admin_super']);

// Ambil data transaksi yang masih pending
$query = "SELECT s.id_sales, s.no_faktur, s.tgl_sales, s.total_bayar, c.nama_customer, u.nama_lengkap AS nama_petugas
          FROM sales s
          JOIN customer c ON s.id_customer = c.id_customer
          JOIN users u ON s.id_user = u.id_user
          WHERE s.status = 'pending'
          ORDER BY s.tgl_sales ASC";
$stmt = $pdo->query($query);
$pending_sales = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-check-circle"></i> Approval Transaksi</h1>
</div>

<?php display_flash_message(); ?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Petugas</th>
                <th>Total</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pending_sales)): ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi yang menunggu approval.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($pending_sales as $sale) : ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['no_faktur']); ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($sale['tgl_sales'])); ?></td>
                        <td><?= htmlspecialchars($sale['nama_customer']); ?></td>
                        <td><?= htmlspecialchars($sale['nama_petugas']); ?></td>
                        <td><?= format_rupiah($sale['total_bayar']); ?></td>
                       <td class="text-center">
    <div class="btn-group" role="group" aria-label="Aksi Transaksi">
        <a href="<?= BASE_URL ?>/admin/modules/sales/detail.php?id=<?= $sale['id_sales']; ?>" class="btn btn-outline-info btn-sm" title="Lihat Detail">
            <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
        </a>
        <a href="proses.php?action=approve&id=<?= $sale['id_sales']; ?>" class="btn btn-outline-success btn-sm" title="Approve" onclick="return confirm('Anda yakin ingin menyetujui transaksi ini?');">
            <i class="fas fa-check"></i> <span class="d-none d-md-inline">Approve</span>
        </a>
        <a href="proses.php?action=reject&id=<?= $sale['id_sales']; ?>" class="btn btn-outline-danger btn-sm" title="Reject" onclick="return confirm('PERHATIAN: Menolak transaksi akan mengembalikan stok. Lanjutkan?');">
            <i class="fas fa-times"></i> <span class="d-none d-md-inline">Reject</span>
        </a>
    </div>
</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include '../../templates/footer.php';
?>