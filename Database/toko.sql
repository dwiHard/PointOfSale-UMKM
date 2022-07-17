-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 11 Jul 2022 pada 17.28
-- Versi server: 10.8.3-MariaDB
-- Versi PHP: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `barang_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` smallint(5) UNSIGNED DEFAULT NULL,
  `lokasi_id` smallint(6) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama` varchar(128) NOT NULL,
  `stok` smallint(6) UNSIGNED NOT NULL,
  `terjual` smallint(6) UNSIGNED DEFAULT 0,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `ket` tinytext DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`barang_ID`, `user_ID`, `lokasi_id`, `kode_barang`, `nama`, `stok`, `terjual`, `harga_beli`, `harga_jual`, `ket`, `created_at`, `updated_at`) VALUES
(1, 994, 10, 'H2-412PA-KEV-', 'Gear Paket Supra X Aspira', 5, 0, 160000, 165000, '', '2022-07-11 14:09:01', '2022-07-11 14:32:46'),
(2, 994, 10, '4052899982529', 'Bolam depan 12V 32/32W', 20, 0, 15000, 17000, '', '2022-07-11 14:09:56', '2022-07-11 14:32:57'),
(3, 994, 1, '8990876511217', 'BL IRC 90/90.14', 5, 0, 180000, 190000, '', '2022-07-11 14:12:07', '2022-07-11 14:28:21'),
(4, 994, 1, '8990876577800', 'BL IRC 80/90.14', 10, 0, 150000, 160000, '', '2022-07-11 14:13:10', '2022-07-11 14:27:49'),
(5, 994, 2, '8997208770199', 'federal matic 0,8', 20, 0, 40000, 45000, '', '2022-07-11 14:14:12', '2022-07-11 14:32:37'),
(6, 994, 2, '5011987101135', 'shell advance ax7 0,8', 40, 0, 48000, 55000, '', '2022-07-11 14:15:27', '2022-07-11 14:32:27'),
(7, 994, 1, '8990876610095', 'ban dalam irc 250-275.17', 30, 0, 35000, 38000, '', '2022-07-11 14:17:28', '2022-07-11 14:22:02'),
(8, 994, 1, '8990876610101', 'ban dalam irc 225-250.17', 69, 0, 40000, 45000, '', '2022-07-11 14:18:18', '2022-07-11 14:21:23'),
(9, 994, 2, '8991011328097', 'mesran super sae 20w-50 0,8', 59, 0, 40000, 45000, '', '2022-07-11 14:19:40', '2022-07-11 14:32:17'),
(10, 994, 2, '8997208770106', 'federal ultratec 20w-50 1L', 12, 0, 50000, 55000, '', '2022-07-11 14:23:55', '2022-07-11 14:32:04'),
(11, 994, 2, '5011987241596', 'shell helic hx5 15w-40 1L', 12, 0, 70000, 75000, '', '2022-07-11 14:25:29', '2022-07-11 14:31:55'),
(12, 994, 10, '8997021265933', 'Roller Set Beat Carbu 9G', 5, 0, 35000, 40000, '', '2022-07-11 14:36:07', '2022-07-11 14:36:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `no_nota` varchar(20) NOT NULL,
  `user_ID` smallint(5) UNSIGNED NOT NULL,
  `supplier_ID` mediumint(8) UNSIGNED NOT NULL,
  `tgl_masuk` date NOT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `ket` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `barang_ID` int(10) UNSIGNED NOT NULL,
  `no_nota` varchar(20) NOT NULL,
  `harga_beli` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `harga_jual` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah` smallint(5) UNSIGNED NOT NULL,
  `sub_total` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `lokasi_id` smallint(5) UNSIGNED NOT NULL,
  `nama_lokasi` varchar(200) NOT NULL,
  `aktif` tinyint(4) DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`lokasi_id`, `nama_lokasi`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'rak ban', 1, '2022-03-12 01:23:54', '2022-07-11 07:31:00'),
(2, 'rak oli', 1, '2022-03-12 01:23:54', '2022-07-11 07:30:43'),
(10, 'rak kaca', 1, '2022-07-11 00:00:00', '2022-07-10 17:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota`
--

CREATE TABLE `nota` (
  `nota_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` smallint(5) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nota`
--

INSERT INTO `nota` (`nota_ID`, `user_ID`, `tanggal`, `jam`, `total`) VALUES
(65, 994, '2022-03-12', '21:06:53', 110000),
(66, 994, '2022-06-28', '20:03:01', 55000),
(67, 994, '2022-07-07', '18:58:40', 29423);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `supplier_ID` mediumint(8) UNSIGNED NOT NULL,
  `nama` varchar(225) NOT NULL,
  `alamat` varchar(225) DEFAULT NULL,
  `no_telpon` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`supplier_ID`, `nama`, `alamat`, `no_telpon`, `created_at`) VALUES
(7, 'Hitachi', 'jln kemayoran jakarta pusat', '08128018021', '2022-03-12 01:23:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_barang`
--

CREATE TABLE `transaksi_barang` (
  `nota_ID` int(10) UNSIGNED NOT NULL,
  `barang_ID` int(10) UNSIGNED NOT NULL,
  `qty` smallint(6) UNSIGNED NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `harga_beli` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_ID` smallint(5) UNSIGNED NOT NULL,
  `username` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `level` enum('admin','user') NOT NULL,
  `roles` varchar(65) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_ID`, `username`, `pass`, `nama`, `email`, `level`, `roles`, `created_at`, `updated_at`) VALUES
(998, 'kasir2', '267399ad6bcf0d1984135950751ee3df', 'kasir2', 'kasir2@gmail.com', 'user', '1,2', '2022-03-28', '2022-05-31'),
(994, 'admin', 'c561118c1420c3efc1488eb3069b9f4f', 'Admin', 'Admin@gmail.com', 'admin', '1,2', '2022-03-12', '2022-03-28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_ID`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`no_nota`);

--
-- Indeks untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`lokasi_id`);

--
-- Indeks untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`nota_ID`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_ID`);

--
-- Indeks untuk tabel `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD PRIMARY KEY (`nota_ID`,`barang_ID`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `lokasi_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `nota`
--
ALTER TABLE `nota`
  MODIFY `nota_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_ID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=999;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
