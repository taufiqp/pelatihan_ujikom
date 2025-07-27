<?php
// Pastikan session sudah dimulai di file utama (seperti header.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Mengubah angka menjadi format mata uang Rupiah.
 * Contoh: 15000 menjadi "Rp 15.000"
 *
 * @param int|float $number Angka yang akan diformat.
 * @return string Angka dalam format Rupiah.
 */
function format_rupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

/**
 * Membersihkan input dari pengguna untuk mencegah XSS.
 *
 * @param string $data Input dari pengguna.
 * @return string Data yang sudah dibersihkan.
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Memeriksa hak akses pengguna.
 * Jika tidak sesuai, hentikan eksekusi skrip dan tampilkan pesan.
 *
 * @param array $allowed_levels Array berisi level yang diizinkan (e.g., ['admin_super', 'manager']).
 */
function check_access($allowed_levels) {
    if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], $allowed_levels)) {
        http_response_code(403); // Set response code ke 403 Forbidden
        die("<h2>Akses Ditolak!</h2><p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>");
    }
}


/**
 * Mengatur flash message (pesan sekali tampil).
 *
 * @param string $type Tipe pesan (e.g., 'success', 'error', 'info').
 * @param string $message Isi pesan.
 */
function set_flash_message($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Menampilkan flash message jika ada, lalu menghapusnya.
 */
function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        $alert_class = '';
        switch ($flash['type']) {
            case 'success':
                $alert_class = 'alert-success';
                break;
            case 'error':
                $alert_class = 'alert-danger';
                break;
            case 'info':
                $alert_class = 'alert-info';
                break;
            default:
                $alert_class = 'alert-secondary';
                break;
        }
        
        echo "<div class='alert {$alert_class} alert-dismissible fade show' role='alert'>";
        echo $flash['message'];
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        echo "</div>";

        // Hapus flash message setelah ditampilkan
        unset($_SESSION['flash_message']);
    }
}

?>