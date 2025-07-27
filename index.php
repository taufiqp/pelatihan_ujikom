<?php
// Memasukkan header template customer
include 'templates_customer/header.php';

// --- Logika untuk mengambil data produk ---

// 1. Ambil 4 produk unggulan secara acak yang stoknya ada
$featured_items = $pdo->query("SELECT * FROM item WHERE stok > 0 ORDER BY RAND() LIMIT 4")->fetchAll();

// 2. Ambil semua produk yang stoknya ada
$all_items = $pdo->query("SELECT * FROM item WHERE stok > 0 ORDER BY nama_item ASC")->fetchAll();
?>

<style>
    /* Hero Section */
    .hero-section {
        background: url('https://images.unsplash.com/photo-1583258292688-d021e9505d12?q=80&w=1770&auto=format&fit=crop') no-repeat center center;
        background-size: cover;
        padding: 100px 0;
        color: white;
        text-align: center;
        position: relative;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); /* Overlay gelap */
    }
    .hero-content {
        position: relative; /* Agar konten berada di atas overlay */
    }

    /* Card Product Enhancement */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 0.5rem;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .section-title {
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 10px;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: #0d6efd; /* Warna primary Bootstrap */
    }
</style>

<header class="hero-section rounded mb-5">
    <div class="hero-content">
        <h1 class="display-4 fw-bold">Kebutuhan Lengkap, Hati Senang</h1>
        <p class="lead">Dapatkan semua kebutuhan rumah tangga Anda dengan kualitas terjamin dan harga yang bersahabat hanya di Koperasi Sejahtera.</p>
        <a href="#produk-unggulan" class="btn btn-primary btn-lg mt-3">Lihat Produk Unggulan</a>
    </div>
</header>

<section id="produk-unggulan" class="my-5">
    <div class="container text-center">
        <h2 class="section-title">Produk Unggulan Kami</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($featured_items as $item): ?>
            <div class="col">
                <div class="card h-100 product-card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($item['nama_item']) ?></h5>
                        <h6 class="card-subtitle my-2 text-danger fw-bold"><?= format_rupiah($item['harga_jual']) ?></h6>
                        <p class="card-text text-muted small">Stok tersedia: <?= $item['stok'] ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3">
                        <form action="proses_cart.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="id_item" value="<?= $item['id_item'] ?>">
                            <input type="hidden" name="harga_jual" value="<?= $item['harga_jual'] ?>">
                            <input type="hidden" name="nama_item" value="<?= htmlspecialchars($item['nama_item']) ?>">
                            <div class="input-group">
                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="<?= $item['stok'] ?>" aria-label="Jumlah">
                                <button type="submit" class="btn btn-primary" title="Tambah ke Keranjang"><i class="fas fa-cart-plus"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<hr class="my-5">

<section id="semua-produk" class="my-5">
    <div class="container text-center">
        <h2 class="section-title">Semua Produk</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($all_items as $item): ?>
            <div class="col">
                <div class="card h-100 product-card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($item['nama_item']) ?></h5>
                        <h6 class="card-subtitle my-2 text-danger fw-bold"><?= format_rupiah($item['harga_jual']) ?></h6>
                        <p class="card-text text-muted small">Stok tersedia: <?= $item['stok'] ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3">
                        <form action="proses_cart.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="id_item" value="<?= $item['id_item'] ?>">
                            <input type="hidden" name="harga_jual" value="<?= $item['harga_jual'] ?>">
                            <input type="hidden" name="nama_item" value="<?= htmlspecialchars($item['nama_item']) ?>">
                            <div class="input-group">
                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="<?= $item['stok'] ?>" aria-label="Jumlah">
                                <button type="submit" class="btn btn-outline-primary" title="Tambah ke Keranjang"><i class="fas fa-cart-plus"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
// Memasukkan footer template customer
include 'templates_customer/footer.php'; 
?>