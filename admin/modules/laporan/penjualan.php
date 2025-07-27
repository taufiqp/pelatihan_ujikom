<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';

// Tetapkan tanggal default (bulan ini)
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-t');

// Ambil data laporan berdasarkan rentang tanggal
$query_sales = "SELECT s.no_faktur, s.tgl_sales, s.total_bayar, c.nama_customer, u.nama_lengkap AS nama_petugas
                FROM sales s
                JOIN customer c ON s.id_customer = c.id_customer
                JOIN users u ON s.id_user = u.id_user
                WHERE s.status = 'approved' AND DATE(s.tgl_sales) BETWEEN ? AND ?
                ORDER BY s.tgl_sales ASC";
$stmt_sales = $pdo->prepare($query_sales);
$stmt_sales->execute([$start_date, $end_date]);
$sales_report = $stmt_sales->fetchAll();

// Ambil data summary
$query_summary = "SELECT COUNT(id_sales) as total_transaksi, SUM(total_bayar) as total_omset
                  FROM sales
                  WHERE status = 'approved' AND DATE(tgl_sales) BETWEEN ? AND ?";
$stmt_summary = $pdo->prepare($query_summary);
$stmt_summary->execute([$start_date, $end_date]);
$summary = $stmt_summary->fetch();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-file-alt"></i> Laporan Penjualan</h1>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="" class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="start_date" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date ?>">
            </div>
            <div class="col-auto">
                <label for="end_date" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?>">
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Omset</h5>
                <p class="card-text fs-4"><?= format_rupiah($summary['total_omset'] ?? 0) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <p class="card-text fs-4"><?= $summary['total_transaksi'] ?? 0 ?></p>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Petugas</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($sales_report)): ?>
                <tr><td colspan="6" class="text-center">Tidak ada data untuk periode ini.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach($sales_report as $report): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($report['no_faktur']) ?></td>
                    <td><?= date('d M Y, H:i', strtotime($report['tgl_sales'])) ?></td>
                    <td><?= htmlspecialchars($report['nama_customer']) ?></td>
                    <td><?= htmlspecialchars($report['nama_petugas']) ?></td>
                    <td><?= format_rupiah($report['total_bayar']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include '../../templates/footer.php';
?>