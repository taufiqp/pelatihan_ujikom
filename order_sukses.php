<?php
// Memasukkan header template customer
include 'templates_customer/header.php';

// Ambil nomor faktur dari URL untuk ditampilkan
$no_faktur = isset($_GET['faktur']) ? htmlspecialchars($_GET['faktur']) : 'Tidak Ditemukan';
?>

<div class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    <h1 class="display-5 mt-3">Terima Kasih!</h1>
                    <p class="lead">Pesanan Anda telah berhasil kami terima.</p>
                    <hr>
                    <p>Pesanan Anda akan segera kami proses dan akan muncul di menu Approval Admin. Mohon tunggu konfirmasi selanjutnya.</p>
                    <p>Nomor Faktur Anda:</p>
                    <h4 class="bg-light p-3 rounded"><strong><?= $no_faktur ?></strong></h4>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                        <a href="<?= BASE_URL ?>/index.php" class="btn btn-primary btn-lg px-4 gap-3">
                            <i class="fas fa-shopping-bag"></i> Lanjut Belanja
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fas fa-history"></i> Riwayat Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Memasukkan footer template customer
include 'templates_customer/footer.php'; 
?>