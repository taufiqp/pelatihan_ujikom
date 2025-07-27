<?php
include '../../templates/header.php';
include '../../templates/sidebar.php';

if (!isset($_GET['id'])) {
    header('Location: data.php');
    exit();
}
$id_sales = $_GET['id'];

// Ambil data header sales
$stmt_header = $pdo->prepare(
    "SELECT s.*, c.nama_customer, c.alamat, c.telp, u.nama_lengkap as nama_petugas
     FROM sales s
     JOIN customer c ON s.id_customer = c.id_customer
     JOIN users u ON s.id_user = u.id_user
     WHERE s.id_sales = ?"
);
$stmt_header->execute([$id_sales]);
$sale = $stmt_header->fetch();

if (!$sale) {
    die("Transaksi tidak ditemukan.");
}

// Ambil data detail item
$stmt_detail = $pdo->prepare(
    "SELECT sd.*, i.nama_item, i.kode_item
     FROM sales_detail sd
     JOIN item i ON sd.id_item = i.id_item
     WHERE sd.id_sales = ?"
);
$stmt_detail->execute([$id_sales]);
$details = $stmt_detail->fetchAll();
?>

<h1 class="h2">Detail Transaksi</h1>

<div class="row">
    <div class="col-md-6">
        <strong>No Faktur:</strong> <?= htmlspecialchars($sale['no_faktur']) ?><br>
        <strong>Tanggal:</strong> <?= date('d F Y, H:i', strtotime($sale['tgl_sales'])) ?><br>
        <strong>Status:</strong> <span class="badge bg-success"><?= ucfirst($sale['status']) ?></span>
    </div>
    <div class="col-md-6">
        <strong>Customer:</strong> <?= htmlspecialchars($sale['nama_customer']) ?><br>
        <strong>Alamat:</strong> <?= htmlspecialchars($sale['alamat']) ?><br>
        <strong>Petugas:</strong> <?= htmlspecialchars($sale['nama_petugas']) ?>
    </div>
</div>

<hr>

<h3 class="mt-4">Rincian Item</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kode Item</th>
            <th>Nama Item</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $detail) : ?>
            <tr>
                <td><?= htmlspecialchars($detail['kode_item']) ?></td>
                <td><?= htmlspecialchars($detail['nama_item']) ?></td>
                <td>Rp <?= number_format($detail['harga_saat_transaksi'], 0, ',', '.') ?></td>
                <td><?= $detail['quantity'] ?></td>
                <td>Rp <?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" class="text-end">Total Bayar</th>
            <th>Rp <?= number_format($sale['total_bayar'], 0, ',', '.') ?></th>
        </tr>
    </tfoot>
</table>

<?php if (!empty($sale['keterangan'])) : ?>
    <div class="mt-3">
        <strong>Keterangan:</strong>
        <p><?= nl2br(htmlspecialchars($sale['keterangan'])) ?></p>
    </div>
<?php endif; ?>

<a href="data.php" class="btn btn-secondary mt-3">Kembali ke Daftar Transaksi</a>
<button onclick="window.print()" class="btn btn-info mt-3">Cetak Faktur</button>


<?php
include '../../templates/footer.php';
?>