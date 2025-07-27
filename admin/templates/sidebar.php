<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar" style="width: 280px;">
    <a href="<?= BASE_URL ?>/admin/dashboard.php" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <span class="fs-4">Koperasi App</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        
        <li><a href="<?= BASE_URL ?>/admin/dashboard.php" class="nav-link text-white"><i class="fas fa-home me-2"></i>Dashboard</a></li>
        
        <?php if ($_SESSION['level'] == 'sales'): ?>
            <li><a href="<?= BASE_URL ?>/admin/modules/catat_penjualan/data.php" class="nav-link text-white"><i class="fas fa-clipboard-list me-2"></i>Pencatatan Penjualan</a></li>
        <?php endif; ?>

        <?php if (in_array($_SESSION['level'], ['petugas', 'manager', 'admin_super'])): ?>
            <li><a href="<?= BASE_URL ?>/admin/modules/catat_penjualan/data.php" class="nav-link text-white"><i class="fas fa-clipboard-list me-2"></i>Pencatatan Penjualan</a></li>
            <li><a href="<?= BASE_URL ?>/admin/modules/sales/data.php" class="nav-link text-white"><i class="fas fa-cash-register me-2"></i>Transaksi Detail</a></li>
            <li><a href="<?= BASE_URL ?>/admin/modules/customer/data.php" class="nav-link text-white"><i class="fas fa-users me-2"></i>Data Customer</a></li>
            <li><a href="<?= BASE_URL ?>/admin/modules/item/data.php" class="nav-link text-white"><i class="fas fa-box me-2"></i>Data Item</a></li>
        <?php endif; ?>
        
        <?php if (in_array($_SESSION['level'], ['manager', 'admin_super'])): ?>
            <li><a href="<?= BASE_URL ?>/admin/modules/approval/data.php" class="nav-link text-white"><i class="fas fa-check-circle me-2"></i>Approval Transaksi</a></li>
            <li><a href="<?= BASE_URL ?>/admin/modules/laporan/penjualan.php" class="nav-link text-white"><i class="fas fa-file-alt me-2"></i>Laporan</a></li>
        <?php endif; ?>
        
        <?php if ($_SESSION['level'] == 'admin_super'): ?>
            <hr>
            <li><a href="<?= BASE_URL ?>/admin/modules/user/data.php" class="nav-link text-white"><i class="fas fa-user-cog me-2"></i>Manajemen User</a></li>
        <?php endif; ?>
    </ul>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle me-2"></i><strong><?= htmlspecialchars($_SESSION['nama_lengkap']); ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="<?= BASE_URL ?>/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Sign out</a></li>
        </ul>
    </div>
    <hr>
    
</div>
<main class="container-fluid p-4">