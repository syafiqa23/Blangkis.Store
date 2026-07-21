-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: production database
-- Waktu pembuatan: 28 Jun 2025 pada 19.25
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
-- Database: `db_ci4`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(5) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(6, 'Blangkon Jawa Timur', 'Blangkon khas daerah Jawa Timur dengan corak budaya arek dan tapal kuda.', '2025-06-28 09:06:32', '2025-06-28 15:24:43'),
(7, 'Blangkon Jawa Tengah', 'Blangkon tradisional dari Jawa Tengah, mencerminkan budaya keraton Yogyakarta dan Solo.', '2025-06-28 09:06:32', '2025-06-28 09:06:32'),
(8, 'Blangkon Jawa Barat', 'Blangkon dari Jawa Barat dengan pengaruh budaya Sunda, khas dengan warna dan bentuknya.', '2025-06-28 09:06:32', '2025-06-28 09:06:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-05-07-150917', 'App\\Database\\Migrations\\User', 'default', 'App', 1747551640, 1),
(2, '2025-05-07-150951', 'App\\Database\\Migrations\\Product', 'default', 'App', 1747551640, 1),
(3, '2025-05-07-150951', 'App\\Database\\Migrations\\Transaction', 'default', 'App', 1747551640, 1),
(4, '2025-05-07-150951', 'App\\Database\\Migrations\\TransactionDetail', 'default', 'App', 1747551640, 1),
(5, '2025-06-27-150301', 'App\\Database\\Migrations\\CreateKategori', 'default', 'App', 1751036624, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` double NOT NULL,
  `modal` double DEFAULT NULL,
  `jumlah` int(5) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `kategori_id` int(5) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id`, `nama`, `deskripsi`, `harga`, `modal`, `jumlah`, `foto`, `kategori_id`, `created_at`, `updated_at`) VALUES
(21, 'Blangkon Surakarta', 'Blangkon Surakarta Asli, simbol kehalusan budi dan kewibawaan khas Jawa. Dengan model trepes (datar) yang elegan dan motif batik klasik yang sarat makna, blangkon ini siap menyempurnakan penampilan Anda di setiap momen istimewa.', 120000, NULL, 15, '1751015021_2e5a6cd33659a4241ffd.jpg', 7, '2025-06-27 09:03:41', '2025-06-27 09:10:54'),
(22, 'Blangkon Yogyakarta', 'Blangkon Yogyakarta Asli, simbol kesederhanaan dan kepasrahan. Tersedia dengan berbagai motif batik klasik yang menawan.', 145000, NULL, 18, '1751016176_7ad59bfa55b7585dedfd.jpg', 7, '2025-06-27 09:22:56', NULL),
(23, 'Blangkon Warok Ponoragan', 'Blangkon Warok Ponoragan Asli, blangkon ini adalah simbol kekuatan, keberanian, dan identitas budaya dari kesenian Reog Ponorogo yang melegenda.', 160000, NULL, 20, '1751016505_6e0b1f28cc493150ff3a.jpg', 6, '2025-06-27 09:28:25', '2025-06-27 09:48:10'),
(24, 'Blangkon Kedu', 'Blangkon Kedu asli, handcrafted dengan cinta. Elegan, nyaman, dan penuh makna. Sempurna untuk setiap momen spesial Anda.', 135000, NULL, 14, '1751017598_f223c4c2eb7b01aa6a82.jpg', 7, '2025-06-27 09:46:38', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `total_harga` double NOT NULL,
  `alamat` text NOT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kelurahan_nama` varchar(255) DEFAULT NULL,
  `layanan` varchar(100) DEFAULT NULL,
  `ongkir` double DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_kirim` varchar(20) DEFAULT 'belum',
  `status_bayar` varchar(20) DEFAULT 'belum',
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaction`
--

INSERT INTO `transaction` (`id`, `username`, `total_harga`, `alamat`, `kelurahan`, `kelurahan_nama`, `ongkir`, `status`, `created_at`, `updated_at`, `status_kirim`, `status_bayar`, `bukti_pembayaran`) VALUES
(7, 'nabila.simanjuntak', 4265000, 'Jl. Kamboja 203', '52589', 'MENDAWAI, SUKAMARA, SUKAMARA, KALIMANTAN TENGAH, 74172', 4000000, 0, '2025-06-28 11:26:06', '2025-06-28 11:26:06', 'sampai', 'lunas', NULL),
(8, 'nabila.simanjuntak', 276000, 'Jl. Bulustalan 82A', '65042', 'PENDRIKAN KIDUL, SEMARANG TENGAH, SEMARANG, JAWA TENGAH, 50131', 11000, 0, '2025-06-28 11:34:58', '2025-06-28 11:34:58', 'sampai', 'lunas', NULL),
(9, 'nabila.simanjuntak', 295000, 'Jl. Mawar ', '51626', 'MENDAWAI, MENDAWAI, KATINGAN, KALIMANTAN TENGAH, 74463', 0, 0, '2025-06-28 13:37:58', '2025-06-28 13:37:58', 'belum', 'lunas', NULL),
(10, 'nabila.simanjuntak', 160000, 'Jl. Pudu ', '52589', 'MENDAWAI, SUKAMARA, SUKAMARA, KALIMANTAN TENGAH, 74172', 0, 0, '2025-06-28 14:33:13', '2025-06-28 14:33:13', 'belum', 'belum', NULL),
(11, 'safiqa.fiqa11@gmail.com', 341000, 'Jl. Kamboja 203', '52589', 'MENDAWAI, SUKAMARA, SUKAMARA, KALIMANTAN TENGAH, 74172', 76000, 0, '2025-06-28 17:15:14', '2025-06-28 17:15:14', 'belum', 'menunggu konfirmasi', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `jumlah` int(5) NOT NULL,
  `diskon` double DEFAULT NULL,
  `subtotal_harga` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaction_detail`
--

INSERT INTO `transaction_detail` (`id`, `transaction_id`, `product_id`, `jumlah`, `diskon`, `subtotal_harga`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 0, 13798000, '2025-06-18 13:28:57', '2025-06-18 13:28:57'),
(2, 1, 3, 1, 0, 6299000, '2025-06-18 13:28:57', '2025-06-18 13:28:57'),
(3, 2, 1, 1, 0, 10899000, '2025-06-18 14:39:21', '2025-06-18 14:39:21'),
(4, 2, 17, 1, 0, 35000000, '2025-06-18 14:39:21', '2025-06-18 14:39:21'),
(5, 3, 1, 1, 0, 10899000, '2025-06-26 16:11:53', '2025-06-26 16:11:53'),
(6, 3, 2, 1, 0, 6899000, '2025-06-26 16:11:53', '2025-06-26 16:11:53'),
(7, 4, 21, 1, 0, 120000, '2025-06-27 16:38:02', '2025-06-27 16:38:02'),
(8, 4, 22, 1, 0, 145000, '2025-06-27 16:38:02', '2025-06-27 16:38:02'),
(9, 5, 21, 1, 0, 120000, '2025-06-28 06:44:37', '2025-06-28 06:44:37'),
(10, 5, 22, 1, 0, 145000, '2025-06-28 06:44:37', '2025-06-28 06:44:37'),
(11, 6, 21, 1, 0, 120000, '2025-06-28 10:56:46', '2025-06-28 10:56:46'),
(12, 7, 22, 1, 0, 145000, '2025-06-28 11:26:06', '2025-06-28 11:26:06'),
(13, 7, 21, 1, 0, 120000, '2025-06-28 11:26:06', '2025-06-28 11:26:06'),
(14, 8, 21, 1, 0, 120000, '2025-06-28 11:34:58', '2025-06-28 11:34:58'),
(15, 8, 22, 1, 0, 145000, '2025-06-28 11:34:58', '2025-06-28 11:34:58'),
(16, 9, 23, 1, 0, 160000, '2025-06-28 13:37:58', '2025-06-28 13:37:58'),
(17, 9, 24, 1, 0, 135000, '2025-06-28 13:37:58', '2025-06-28 13:37:58'),
(18, 10, 23, 1, 0, 160000, '2025-06-28 14:33:13', '2025-06-28 14:33:13'),
(19, 11, 21, 1, 0, 120000, '2025-06-28 17:15:14', '2025-06-28 17:15:14'),
(20, 11, 22, 1, 0, 145000, '2025-06-28 17:15:14', '2025-06-28 17:15:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'sfarida', 'tyulianti@gmail.co.id', '$2y$10$akjnt22pc9yW0YD1IAv.UeMm/SOb3mOPwDslrIfi/4xGHYKISrFXO', 'guest', '2025-05-18 07:01:18', NULL),
(2, 'hgunarto', 'nnababan@maryati.go.id', '$2y$10$Ss6oDjKLLr56xRR/IE8wru7Eer36EHqMOhW77blOkNMuMjMYW8wZC', 'guest', '2025-05-18 07:01:18', NULL),
(3, 'nabila.simanjuntak', 'prabu.wijayanti@yahoo.com', '$2y$10$Awa6vDa3yr/d4202LvLYK.DuAsIudIL8fwCxWlpFFkGc//638FKgS', 'admin', '2025-05-18 07:01:18', NULL),
(4, 'kuyainah', 'nnasyiah@gmail.co.id', '$2y$10$sVKKcacxbPafH1B5Wuskc.LxSyfM9J/eeZ18f.g9v4lkui1H/CFUe', 'admin', '2025-05-18 07:01:18', NULL),
(5, 'qrahayu', 'manullang.paris@yahoo.co.id', '$2y$10$8DCON5hB2vQ6ArNO1V8NF.0lZytZhSdCwolihb1UZxdpIYDUN3xGu', 'admin', '2025-05-18 07:01:18', NULL),
(6, 'qirawan', 'fwidodo@gmail.com', '$2y$10$Ot5icSgqdx.yMKoQrjpCc.GegmvRcVi42.xNjrg0VcTCrtR.9e276', 'guest', '2025-05-18 07:01:18', NULL),
(7, 'lsitorus', 'oni.mangunsong@yahoo.co.id', '$2y$10$EWZMJBDXPAqeJsMz6szIz.HNNio/XvzLYYFS65bZ8oRf/prN5QNZq', 'guest', '2025-05-18 07:01:18', NULL),
(8, 'viktor.suryono', 'xyuliarti@yahoo.com', '$2y$10$kwDdrXyXt0PMWJg1FlulvOCSGmPGYqlVw6Fpj58diGsWm.5j12MIa', 'admin', '2025-05-18 07:01:18', NULL),
(9, 'ilsa.utama', 'lailasari.elma@budiman.co', '$2y$10$vZaLaOWIVlISmz5uKLMGPeIxA35pBPbcuAL5ApBYj9Mkl1fnSe3ba', 'guest', '2025-05-18 07:01:19', NULL),
(10, 'yuliarti.belinda', 'rika58@yulianti.desa.id', '$2y$10$C4hvoVlpdPWeRXTzxAbLW.ia.a1tfdMIS6JlIVooOoJeUCgaAHHm.', 'guest', '2025-05-18 07:01:19', NULL),
(11, 'pratiwi.lega', 'maryadi.agnes@gmail.com', '$2y$10$kyivBrv6WG49MRlqvmJeZOAQFV18TzdIOs8ozJma32a3HLUNPx/.q', 'admin', '2025-05-21 09:24:39', NULL),
(12, 'gunawan.ulva', 'maryati.vera@nurdiyanti.tv', '$2y$10$YNffqV03Zw5gtl5eyFW2j.70yJo1HIOWi6coM2rxlrDmphIDQwmTW', 'admin', '2025-05-21 09:24:39', NULL),
(13, 'jamal63', 'eli66@maheswara.biz', '$2y$10$Zq2yAhs7nEugPYvY3zj9u.SDAz983CBrGyehfC3PIlEgNiJPE.hLq', 'guest', '2025-05-21 09:24:39', NULL),
(14, 'usirait', 'latika68@gmail.com', '$2y$10$9J901VzTk5.CN5Gq5OdupeRVYHqdSHF26dzo5A7nJJoPslY4TwPYm', 'guest', '2025-05-21 09:24:39', NULL),
(15, 'elisa.handayani', 'vsiregar@hidayat.tv', '$2y$10$ySoPYaCL.BoOqeln7bK/justlMKWMRQ9xhC7uAwooJEaB7qgugmTq', 'admin', '2025-05-21 09:24:39', NULL),
(16, 'sari74', 'zrajata@hutasoit.or.id', '$2y$10$MPI/eMIa8FrLz1jB2CN4d.QaERarST40/GDH6Bq/1gAVY6iuTObFK', 'admin', '2025-05-21 09:24:39', NULL),
(17, 'yosef13', 'sitorus.gambira@yahoo.com', '$2y$10$tiQFwBE16OONwJ5GhiWlOuWNHyx3tNpuUajeLy//lMrDBZvwNbDUa', 'admin', '2025-05-21 09:24:39', NULL),
(18, 'hairyanto.hakim', 'boktaviani@riyanti.tv', '$2y$10$PesqsOg4JiMFQvsbMQrYOOsClc90i7Jr.45lPQ1KBKg5K80ffOqVa', 'guest', '2025-05-21 09:24:39', NULL),
(19, 'wsimbolon', 'plaksita@tarihoran.com', '$2y$10$nf/Za4YtzLuJksHekt8Z8.l.4M4NsBR7.rsoQijU5/OJlguMVSofC', 'admin', '2025-05-21 09:24:39', NULL),
(20, 'pradana.cinta', 'jzulaika@wasita.biz', '$2y$10$f3J2JUNMF88zZR7PA3Ey/eqbCb1z0gBhuVeE0wuBVb/p3oKVZ9kV.', 'guest', '2025-05-21 09:24:39', NULL),
(21, 'oanggriawan', 'tiara.usada@tampubolon.name', '$2y$10$5dO5mDg6ntwpRK8yoR/So.6y4cL.958hYsUA9AVttgYV.2D4e1Iou', 'admin', '2025-05-23 04:10:40', NULL),
(22, 'oliva.dabukke', 'vero34@uyainah.biz', '$2y$10$s6lWvue/DMzxermp61PX/OtADP1.0KrXSwv5TuKvkM9OsCdOE9SmS', 'guest', '2025-05-23 04:10:40', NULL),
(23, 'haryanto.lili', 'mila80@yahoo.co.id', '$2y$10$qVCZs6YHojK4EioDTzlRW.X7YODBRCmub9uhCnUbaZ/IXezFnVmA2', 'admin', '2025-05-23 04:10:40', NULL),
(24, 'hbudiyanto', 'hendri.firgantoro@yahoo.com', '$2y$10$RHzu0eQfXwvr9v1k9JHEPebk6HD/zLZOkqsb3I1r6nhweG/QJMitu', 'guest', '2025-05-23 04:10:40', NULL),
(25, 'uchita.suryatmi', 'lanjar81@kusumo.org', '$2y$10$hQxmPF1nnD9I5tqerHirU.OGhx4CiSRmnzCigjvdcIzngciw4jhky', 'guest', '2025-05-23 04:10:40', NULL),
(26, 'tami34', 'riyanti.fitria@gmail.com', '$2y$10$4hPDHU6gDkoUIpX602dNKezjL0uCmj/lX.9OiM8N/BnQdVPTUKZHG', 'admin', '2025-05-23 04:10:41', NULL),
(27, 'pranowo.najam', 'laksmiwati.ilyas@uyainah.net', '$2y$10$.b3TcXL1Z7t.Rn3tlHIkSu0fm29eE2oIZ5EtbvFU33kr81D1i2z8K', 'guest', '2025-05-23 04:10:41', NULL),
(28, 'laksita.kamaria', 'pdongoran@rahayu.id', '$2y$10$/hxTZ6Ws9QqftD/Q4M8UAeNUu2LOJaRMnx5zDmNUGgpZVcEdmJVnS', 'admin', '2025-05-23 04:10:41', NULL),
(29, 'winda14', 'ratih.budiyanto@mayasari.web.id', '$2y$10$/AGiJTIHO0BN7UOZQ6YXS.PLHq28FN5TzME9KXxpDH6TKkRDLZAsu', 'admin', '2025-05-23 04:10:41', NULL),
(30, 'darmanto75', 'wulandari.oni@gmail.com', '$2y$10$7QNSLIwOkzSxxwPJSR0I4uGN9faE4irZ4Lt5bnRNER2zfp.EdDiyO', 'guest', '2025-05-23 04:10:41', NULL),
(31, 'dasa.rajasa', 'maria.narpati@yahoo.com', '$2y$10$PVosreHwSza4YE.QDcPgT.j5YipIRVxKNFlIzK3p6/enTh1Q1zIvu', 'admin', '2025-05-31 13:21:25', NULL),
(32, 'adinata.samosir', 'amulyani@gmail.co.id', '$2y$10$321GRrtcMLC9.PNxZCFVzuhGBuAmSim6IUPMkQJb5dxcFCDgJJwfu', 'guest', '2025-05-31 13:21:25', NULL),
(33, 'mayasari.prabowo', 'nrima14@yahoo.co.id', '$2y$10$yA5NgWppfPQwmj06GishDebe49KLce144bIySMy8uoRP5zHmS7mYa', 'guest', '2025-05-31 13:21:25', NULL),
(34, 'galuh.palastri', 'harimurti.nurdiyanti@halimah.info', '$2y$10$Ia4WykFlCVqukg7uHaTB2eWOE44UdBeJ2Ji7hYyEkRB5w/xJcErmq', 'admin', '2025-05-31 13:21:25', NULL),
(35, 'gatot64', 'qsuartini@gmail.co.id', '$2y$10$Og6Yx94k60jg0NKmWqH06ev5YsSra4Q2rM3x0314Ed.7l2CT8ao8m', 'admin', '2025-05-31 13:21:25', NULL),
(36, 'novitasari.asirwanda', 'citra.zulkarnain@yahoo.com', '$2y$10$gXUteI/l2bfwJqThH5Qe/O0UmscEWJJMq3aINO2Z.INT6vjsdW3kC', 'guest', '2025-05-31 13:21:25', NULL),
(37, 'candrakanta70', 'onababan@firmansyah.com', '$2y$10$1o66HU.XGU77QE10xjMczeMvmENrBdU2RED4qRMH0mMBWoCo4G8Bu', 'guest', '2025-05-31 13:21:25', NULL),
(38, 'padma70', 'wijayanti.hairyanto@dabukke.mil.id', '$2y$10$lk1HVYyf/NNkMpY47UIj0.YvIiETVKHG5YvvrFcT.6wC8bHkw2D6S', 'admin', '2025-05-31 13:21:25', NULL),
(39, 'cpurwanti', 'isalahudin@gmail.co.id', '$2y$10$BNTsvTfsMoKqOEWJrAgFMeb7eBFKjz.NaN5Y/dbW5Ty/6yWlfSz2C', 'admin', '2025-05-31 13:21:26', NULL),
(40, 'wacana.wani', 'wage.agustina@kuswandari.co.id', '$2y$10$80s3zk9yxTkZOU2M7f01RuW3eRNiJ.Cx.gto0NazLwOxYHDMwCvfC', 'guest', '2025-05-31 13:21:26', NULL),
(41, 'prakasa.ulya', 'mayasari.eka@riyanti.co', '$2y$10$RBF8RDV6JoIYR2Uy3qQB3ugHN.RBi6lvdK4.VJ8Yzxn./Zswutgz.', 'admin', '2025-05-31 16:56:57', NULL),
(42, 'rwidiastuti', 'anggraini.ratih@mangunsong.my.id', '$2y$10$0QA6KV/dQB7CtjkJcuxe2.B5wpsIM4I6XWGiEXsnlVbPQgl4zh.uC', 'admin', '2025-05-31 16:56:57', NULL),
(43, 'safitri.farhunnisa', 'puspa.lailasari@gmail.co.id', '$2y$10$.bGfEshrvrGHVjmtxKY8Pe5EPRxtBBdZUF20WE1s0H7Kyh9BZjH0i', 'admin', '2025-05-31 16:56:57', NULL),
(44, 'yulianti.lukman', 'putra.irwan@yahoo.co.id', '$2y$10$sLp98nGQlVDDgCKGFM/fw.5W9KUoI1h2ZsRDfoB2Ms7nGzs467oJq', 'guest', '2025-05-31 16:56:57', NULL),
(45, 'opung93', 'ophelia.ramadan@gmail.co.id', '$2y$10$Nw/x8LhqZBMQwHjvs52w7.MVHRIQ/Px4st903C35oancRstRXc4ke', 'guest', '2025-05-31 16:56:57', NULL),
(46, 'bagas14', 'hastuti.siti@sihombing.ac.id', '$2y$10$/bLM3aPVJ8HmSwu.AjY3z.DsMU.Ulp/dL1CCFr0MB2O.L9wkHB0ZS', 'admin', '2025-05-31 16:56:57', NULL),
(47, 'jarwi04', 'smaulana@saptono.co', '$2y$10$ZE59h9C7eLu1c8vBZwqrPOo7qytsqq5PjJfTv.xdpyDYcgvFFxnNe', 'admin', '2025-05-31 16:56:57', NULL),
(48, 'bhariyah', 'thandayani@gmail.co.id', '$2y$10$kxPownYWc3qlIQznSGiNTenjUqH2dvMLeI157YJpJVKxAHmxtgq9S', 'admin', '2025-05-31 16:56:57', NULL),
(49, 'palastri.prabowo', 'hnurdiyanti@kusumo.mil.id', '$2y$10$SphI5kwKzApGsB7JJv.vDu8vqpH6.tUKdqwB1e13.iNP5PME2BjNC', 'admin', '2025-05-31 16:56:57', NULL),
(50, 'cornelia.puspasari', 'hamzah.hasanah@yuliarti.id', '$2y$10$Su5GFIUxfrKK6G7zHkq8gOYsxE.Rplk1tV8iuZL2xhoTdkAZodtZe', 'admin', '2025-05-31 16:56:57', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_kategori` (`kategori_id`);

--
-- Indeks untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
