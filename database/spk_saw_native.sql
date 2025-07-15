-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jul 2025 pada 06.42
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_saw_native`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `alternatif` varchar(100) NOT NULL,
  `dapil` varchar(100) DEFAULT NULL,
  `kta` varchar(50) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `alternatif`, `dapil`, `kta`, `alamat`) VALUES
(31, 'Kawah Alfa Tarna, S.H.', 'Sukmajaya', '32761010060107190001', 'Perum Pesona Laguna Blok F2/30 Rt. 006 Rw. 020 Kel. Cilangkap Kec. Tapos'),
(32, 'Achmad Nisran Siregar, S.E.', 'Sukmajaya', '32760510030607820001', 'Link. Cipayung Jl. Mandai IV No. 73 Rt. 007 Rw. 002 Kel. Abadi Jaya Kec. Sukmajaya'),
(33, 'Fransiscus Samosir', 'Sukmajaya', '3276051004140580001', 'Perum Pesona Khayangan Blok DP/10 Kel. Mekarjaya Kec. Sukmajaya'),
(34, 'Rahma Nur Agnitya Charliyan, Drg', 'Sukmajaya', '32732010042005860001', 'Jl. Antapani Lama No. 12 Rt. 003 Rw. 009 Kel. Antapani Tengah Kec. Antapani, Bandung'),
(35, 'Natalia Sibarani, A.Md.Keb.', 'Sukmajaya', '32.76.05.005.241271.2916', 'Jl. Jasawarga No. 103 Kp. Sugutamu Kel. Baktijaya Kec. Sukmajaya'),
(36, 'Ageng Sedayu, S.T., M.M.', 'Sukmajaya', '32760510012301790001', 'Gema Pesona Estate Blok Z/4 Kel. Sukmajaya Kec. Sukmajaya'),
(37, 'Dewi Ratna, A.P', 'Sukmajaya', '32760510052509770001', 'Jl. Mahakam Raya No. 36 Rt. 002 Rw. 012 Kel. Baktijaya Kec. Sukmajaya'),
(38, 'Drs. H. TUTUN SUFIYAN SULAEMAN', 'Sukmajaya', '32760510010603610001', 'GEMA PESONA BLOK R NO. 1 RT. 006 RW. 011 Kel. Sukmajaya Kec. Sukmajaya'),
(39, 'Indah Widiastuti, S.E., M.M', 'Sukmajaya', '31740110051801880001', 'JL. KP MELAYU KECIL I, GG MASJID AL-IKHSAN NO. 2 Kel. Bukit Duri Kec. Tebet');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `kode_hasil` varchar(255) DEFAULT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `kode_hasil`, `id_alternatif`, `nilai`) VALUES
(1, NULL, 31, 0.685),
(2, NULL, 32, 0.595),
(3, NULL, 33, 0.858333),
(4, NULL, 34, 0.616667),
(5, NULL, 35, 0.776667),
(6, NULL, 36, 0.508333),
(7, NULL, 37, 0.633333),
(8, NULL, 38, 0.671667),
(9, NULL, 39, 0.466667);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(255) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `type` enum('Benefit','Cost') NOT NULL,
  `bobot` float NOT NULL,
  `ada_pilihan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `kriteria`, `type`, `bobot`, `ada_pilihan`) VALUES
(1, 'C1', 'Lama Keanggotaan', 'Benefit', 0.1, 1),
(2, 'C2', 'Daerah Pencalonan', 'Benefit', 0.1, 1),
(3, 'C3', 'Jenis Kelamin', 'Benefit', 0.05, 1),
(4, 'C4', 'Jabatan (Struktural)', 'Benefit', 0.15, 1),
(5, 'C5', 'Jabatan (Legislatif)', 'Benefit', 0.1, 1),
(6, 'C6', 'Riwayat Organisasi PDI-P', 'Benefit', 0.1, 1),
(7, 'C7', 'Riwayat Organisasi di Partai Lain', 'Benefit', 0.1, 1),
(8, 'C8', 'Aktivitas Organisasi di Luar Partai', 'Benefit', 0.1, 1),
(9, 'C9', 'Pendidikan Terakhir', 'Benefit', 0.1, 1),
(10, 'C_10', 'Pendidikan/Pelatihan Partai', 'Benefit', 0.1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `id_sub_kriteria` int(11) DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `id_sub_kriteria`, `nilai`) VALUES
(164, 32, 1, 61, NULL),
(165, 32, 2, 63, NULL),
(166, 32, 3, 66, NULL),
(167, 32, 4, 69, NULL),
(168, 32, 5, 75, NULL),
(169, 32, 6, 80, NULL),
(170, 32, 7, 82, NULL),
(171, 32, 8, 87, NULL),
(172, 32, 9, 88, NULL),
(173, 32, 10, 95, NULL),
(174, 33, 1, 57, NULL),
(175, 33, 2, 62, NULL),
(176, 33, 3, 66, NULL),
(177, 33, 4, 69, NULL),
(178, 33, 5, 74, NULL),
(179, 33, 6, 78, NULL),
(180, 33, 7, 82, NULL),
(181, 33, 8, 86, NULL),
(182, 33, 9, 90, NULL),
(183, 33, 10, 94, NULL),
(184, 34, 1, 61, NULL),
(185, 34, 2, 64, NULL),
(186, 34, 3, 65, NULL),
(187, 34, 4, 73, NULL),
(188, 34, 5, 75, NULL),
(189, 34, 6, 80, NULL),
(190, 34, 7, 81, NULL),
(191, 34, 8, 86, NULL),
(192, 34, 9, 88, NULL),
(193, 34, 10, 94, NULL),
(194, 35, 1, 57, NULL),
(195, 35, 2, 62, NULL),
(196, 35, 3, 65, NULL),
(197, 35, 4, 72, NULL),
(198, 35, 5, 74, NULL),
(199, 35, 6, 78, NULL),
(200, 35, 7, 82, NULL),
(201, 35, 8, 86, NULL),
(202, 35, 9, 89, NULL),
(203, 35, 10, 95, NULL),
(204, 36, 1, 61, NULL),
(205, 36, 2, 62, NULL),
(206, 36, 3, 66, NULL),
(207, 36, 4, 73, NULL),
(208, 36, 5, 75, NULL),
(209, 36, 6, 80, NULL),
(210, 36, 7, 82, NULL),
(211, 36, 8, 87, NULL),
(212, 36, 9, 88, NULL),
(213, 36, 10, 95, NULL),
(214, 37, 1, 60, NULL),
(215, 37, 2, 62, NULL),
(216, 37, 3, 65, NULL),
(217, 37, 4, 72, NULL),
(218, 37, 5, 75, NULL),
(219, 37, 6, 79, NULL),
(220, 37, 7, 82, NULL),
(221, 37, 8, 87, NULL),
(222, 37, 9, 89, NULL),
(223, 37, 10, 94, NULL),
(224, 38, 1, 57, NULL),
(225, 38, 2, 62, NULL),
(226, 38, 3, 66, NULL),
(227, 38, 4, 73, NULL),
(228, 38, 5, 75, NULL),
(229, 38, 6, 79, NULL),
(230, 38, 7, 82, NULL),
(231, 38, 8, 86, NULL),
(232, 38, 9, 88, NULL),
(233, 38, 10, 95, NULL),
(234, 39, 1, 61, NULL),
(235, 39, 2, 64, NULL),
(236, 39, 3, 65, NULL),
(237, 39, 4, 73, NULL),
(238, 39, 5, 75, NULL),
(239, 39, 6, 80, NULL),
(240, 39, 7, 82, NULL),
(241, 39, 8, 87, NULL),
(242, 39, 9, 88, NULL),
(243, 39, 10, 95, NULL),
(244, 31, 1, 60, NULL),
(245, 31, 2, 63, NULL),
(246, 31, 3, 66, NULL),
(247, 31, 4, 70, NULL),
(248, 31, 5, 75, NULL),
(249, 31, 6, 80, NULL),
(250, 31, 7, 81, NULL),
(251, 31, 8, 87, NULL),
(252, 31, 9, 88, NULL),
(253, 31, 10, 94, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `sub_kriteria` varchar(50) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `sub_kriteria`, `nilai`) VALUES
(57, 1, 'X > 10 Tahun', 5),
(58, 1, '7,5 < x < 10 Tahun', 4),
(59, 1, '5 < x ? 7,5 Tahun', 3),
(60, 1, '2 < x < 5 Tahun', 2),
(61, 1, '0 < x ? < 2 Tahun', 1),
(62, 2, 'Domisili sesuai dengan dapil pencalonan', 3),
(63, 2, 'Domisili masih dalam Kab/Kota yang sama', 2),
(64, 2, 'Domisili berbeda dengan Kab/Kota', 1),
(65, 3, 'Perempuan', 2),
(66, 3, 'Laki-Laki', 1),
(67, 4, 'DPP Partai', 7),
(68, 4, 'DPD Partai', 6),
(69, 4, 'DPC Partai', 5),
(70, 4, 'PAC Partai', 4),
(71, 4, 'Sekretariat/Badan/Sayap Partai', 3),
(72, 4, 'Ranting Partai/Anak Ranting Partai', 2),
(73, 4, 'Kader/Simpatisan', 1),
(74, 5, 'Pernah menjabat/sedang menjabat', 2),
(75, 5, 'Tidak Pernah Menjabat', 1),
(76, 6, '>10 Kegiatan', 5),
(77, 6, '6 - 9 Kegiatan', 4),
(78, 6, '3- 5 Kegiatan', 3),
(79, 6, '1 - 2 Kegiatan', 2),
(80, 6, 'Tidak pernah mengikuti kegiatan', 1),
(81, 7, 'Kader/Struktur Partai', 2),
(82, 7, 'Tidak Terdaftar di Partai Lain', 1),
(83, 8, '> 10 Kegiatan', 5),
(84, 8, '6 - 9 Kegiatan', 4),
(85, 8, '3 - 5 Kegiatan', 3),
(86, 8, '1 - 2 Kegiatan', 2),
(87, 8, 'Tidak pernah mengikuti kegiatan', 1),
(88, 9, 'Lulusan S1/S2/S3', 3),
(89, 9, 'Lulusan Akademi/Diploma', 2),
(90, 9, 'Lulusan SLTA', 1),
(91, 10, ' > 10 Pendidikan/Pelatihan', 5),
(92, 10, '6 - 9 Pendidikan/Pelatihan', 4),
(93, 10, '3 - 5 Pendidikan/Pelatihan', 3),
(94, 10, '1 - 2 Pendidikan/Pelatihan', 2),
(95, 10, 'Tidak pernah mengikuti pelatihan/pendidikan', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `role`) VALUES
(15, 'andinoya', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Andi Santoso', 'asdas@asd', '1'),
(16, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'admin@gmail.com', '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `fk_hasil` (`id_alternatif`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_penilaian_alternatif` (`id_alternatif`),
  ADD KEY `fk_penilaian_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `fk_sub_kriteria_id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `fk_hasil` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_penilaian_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`),
  ADD CONSTRAINT `fk_penilaian_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `fk_sub_kriteria_id_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
