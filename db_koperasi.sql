-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jul 2025 pada 12.02
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_koperasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `alamat`, `telp`, `email`, `username`, `password`) VALUES
(1, 'Taufiq qurr', 'jl.kayu bado', '0822', 'taufiq@gmail.com', 'fito', '$2y$10$FZm.bnuOs4bkLPlh3gaZD.mfV0rNgpkInI6s2kjciXx.DWvhy52zC'),
(2, 'taufiq', 'l. mawar', '0822', 'taufiqqq@gmail.com', 'taufiq', '$2y$10$KR33JHsU4Qs82U1nYmBttee.q4oXN68n.vOdhe3CEceYhcb2vyNeq');

-- --------------------------------------------------------

--
-- Struktur dari tabel `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `kode_item` varchar(50) NOT NULL,
  `nama_item` varchar(255) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `item`
--

INSERT INTO `item` (`id_item`, `kode_item`, `nama_item`, `satuan`, `harga_jual`, `stok`) VALUES
(1, '01', 'Tepung Terigu', '1 kg', 15000.00, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales`
--

CREATE TABLE `sales` (
  `id_sales` int(11) NOT NULL,
  `no_faktur` varchar(50) NOT NULL,
  `tgl_sales` datetime NOT NULL DEFAULT current_timestamp(),
  `id_customer` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sales`
--

INSERT INTO `sales` (`id_sales`, `no_faktur`, `tgl_sales`, `id_customer`, `id_user`, `total_bayar`, `status`, `keterangan`) VALUES
(1, 'INV/CUST/20250727094518', '2025-07-27 14:45:18', 1, 1, 15000.00, 'approved', NULL),
(2, 'INV/CUST/20250727094834', '2025-07-27 14:48:34', 1, 1, 60000.00, 'approved', NULL),
(3, 'INV/CUST/20250727101425', '2025-07-27 15:14:25', 2, 1, 15000.00, 'pending', NULL),
(4, 'INV/CUST/20250727103925', '2025-07-27 15:39:25', 1, 1, 15000.00, 'pending', NULL),
(5, 'INV/CUST/20250727105504', '2025-07-27 15:55:04', 1, 1, 30000.00, 'pending', NULL),
(6, 'INV/CUST/20250727110215', '2025-07-27 16:02:15', 1, 1, 15000.00, 'pending', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_detail`
--

CREATE TABLE `sales_detail` (
  `id_sales_detail` int(11) NOT NULL,
  `id_sales` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga_saat_transaksi` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sales_detail`
--

INSERT INTO `sales_detail` (`id_sales_detail`, `id_sales`, `id_item`, `quantity`, `harga_saat_transaksi`, `subtotal`) VALUES
(1, 1, 1, 1, 15000.00, 15000.00),
(2, 2, 1, 4, 15000.00, 60000.00),
(3, 3, 1, 1, 15000.00, 15000.00),
(4, 4, 1, 1, 15000.00, 15000.00),
(5, 5, 1, 2, 15000.00, 30000.00),
(6, 6, 1, 1, 15000.00, 15000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('petugas','manager','admin_super','sales') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `username`, `password`, `level`) VALUES
(1, 'Admin Super', 'admin', '$2y$10$0uoVYIPK2YoZZW9TxgrKCuTl9/JAEhozUIUcxYrjHH5lTaUH7C.Ze', 'admin_super'),
(2, 'Manager Koperasi', 'manager', '$2y$10$bYYjoesLdzc8f4OfFIz9rOpmx/4EA4.VTa9s1I2AK538FlyMGjPYO', 'manager'),
(3, 'Petugas Staf', 'petugas', '$2y$10$wHoVyWT6DfWwlTeEVXFQeeooNmZRCLfv3Vo8LsVb2Nl5ymwIc46yq', 'petugas'),
(4, 'Admin Sales', 'sales', '$2y$10$H2mMu83Gi7Y5HuF3IxOxqeBVoJw6xcvj6HKI98u1uX8BkIvV4ztfe', 'petugas'),
(6, 'Taufiq', 'adminfito', '$2y$10$sQM2FKr/PBmVB3Iv7hWuUOQnfRWgz.EHcrNSSvd/XFOG2OiKf76iO', 'admin_super');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`),
  ADD UNIQUE KEY `kode_item` (`kode_item`);

--
-- Indeks untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id_sales`),
  ADD UNIQUE KEY `no_faktur` (`no_faktur`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `sales_detail`
--
ALTER TABLE `sales_detail`
  ADD PRIMARY KEY (`id_sales_detail`),
  ADD KEY `id_sales` (`id_sales`),
  ADD KEY `id_item` (`id_item`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sales`
--
ALTER TABLE `sales`
  MODIFY `id_sales` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `sales_detail`
--
ALTER TABLE `sales_detail`
  MODIFY `id_sales_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `sales_detail`
--
ALTER TABLE `sales_detail`
  ADD CONSTRAINT `sales_detail_ibfk_1` FOREIGN KEY (`id_sales`) REFERENCES `sales` (`id_sales`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_detail_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
