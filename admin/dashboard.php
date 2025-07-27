<?php 
include 'templates/header.php'; 
include 'templates/sidebar.php'; 

// Contoh query untuk mengambil data summary
$total_customer = $pdo->query("SELECT count(*) FROM customer")->fetchColumn();
$total_item = $pdo->query("SELECT count(*) FROM item")->fetchColumn();
$total_penjualan = $pdo->query("SELECT count(*) FROM sales WHERE status = 'approved'")->fetchColumn();
?>

<h1 class="h2">Dashboard</h1>
<p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['nama_lengkap']); ?></strong>! Anda login sebagai <strong><?= htmlspecialchars($_SESSION['level']); ?></strong>.</p>

<div class="row mt-4">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Customer</h5>
                <p class="card-text fs-4"><?= $total_customer; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Jenis Item</h5>
                <p class="card-text fs-4"><?= $total_item; ?></p>
            </div>
        </div>
    </div>
     <div class="col-md-4 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Penjualan Sukses</h5>
                <p class="card-text fs-4"><?= $total_penjualan; ?></p>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>