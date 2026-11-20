-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2026 pada 12.06
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siacad_smk_2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `jenis_kelamin`, `user_id`) VALUES
(2, '001', 'Vera S.Pd', 'P', 4),
(3, '002', 'Budi S.Pd', 'L', 6),
(4, '003', 'Siti S.Pd', 'P', 7),
(5, '004', 'Andi Pratama', 'L', 8),
(6, '005', 'Rina Marlina', 'P', 9),
(7, '006', 'Dedi Kurniawan', 'L', 10),
(8, '007', 'Fitri Handayani', 'P', 11),
(9, '008', 'Agus Setiawan', 'L', 12),
(10, '009', 'Nia Puspita', 'P', 13),
(11, '010', 'Rizky Maulana', 'L', 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `kode_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `guru_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id`, `kode_mapel`, `nama_mapel`, `guru_id`) VALUES
(1, 'ip01', 'IPA', 2),
(2, 'MTK01', 'Matematika', 3),
(3, 'BIN01', 'Bahasa Indonesia', 4),
(4, 'BIG01', 'Bahasa Inggris', 5),
(5, 'PKN01', 'Pendidikan Pancasila', 6),
(6, 'PJOK1', 'PJOK', 7),
(7, 'RPL01', 'Pemrograman Dasar', 8),
(8, 'BDG01', 'Basis Data', 9),
(9, 'WEB01', 'Pemrograman Web', 10),
(10, 'JAR01', 'Jaringan Komputer', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mengajar`
--

CREATE TABLE `mengajar` (
  `id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mengajar`
--

INSERT INTO `mengajar` (`id`, `mapel_id`, `siswa_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_rapor`
--

CREATE TABLE `nilai_rapor` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `nilai_kkm` int(11) NOT NULL,
  `nilai_pengetahuan` int(11) NOT NULL,
  `nilai_keterampilan` int(11) NOT NULL,
  `Keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nilai_rapor`
--

INSERT INTO `nilai_rapor` (`id`, `siswa_id`, `mapel_id`, `nilai_kkm`, `nilai_pengetahuan`, `nilai_keterampilan`, `Keterangan`) VALUES
(1, 1, 1, 75, 89, 86, 'baik'),
(2, 2, 2, 75, 82, 84, 'Tuntas'),
(3, 3, 3, 75, 88, 87, 'Tuntas'),
(4, 4, 4, 75, 79, 81, 'Tuntas'),
(5, 5, 5, 75, 91, 89, 'Tuntas'),
(6, 6, 6, 75, 85, 88, 'Tuntas'),
(7, 7, 7, 75, 90, 92, 'Tuntas'),
(8, 8, 8, 75, 77, 80, 'Tuntas'),
(9, 9, 9, 75, 86, 85, 'Tuntas'),
(10, 10, 10, 75, 93, 90, 'Tuntas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jenis_kelamin`, `user_id`) VALUES
(1, '01', 'Dini Khairani', 'XI RPL 1', 'P', 2),
(2, '02', 'Aulia Putri', 'XI RPL 1', 'P', 15),
(3, '03', 'Fajar Ramadhan', 'XI RPL 1', 'L', 16),
(4, '04', 'Nabila Sari', 'XI RPL 1', 'P', 17),
(5, '05', 'Dimas Saputra', 'XI RPL 1', 'L', 18),
(6, '06', 'Citra Lestari', 'XI RPL 1', 'P', 19),
(7, '07', 'Reza Firmansyah', 'XI RPL 1', 'L', 20),
(8, '08', 'Intan Permata', 'XI RPL 1', 'P', 21),
(9, '09', 'Bagas Prakoso', 'XI RPL 1', 'L', 22),
(10, '10', 'Putri Amelia', 'XI RPL 1', 'P', 23);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(2, 'dinii', '$2y$10$7gv2kbOM77T0RvkICkKuI.i8dNV5m6/Z4aHKKnBaazxn6.STPV0wi', 'siswa', '2026-09-30 07:14:43'),
(4, 'veraa', '$2y$10$VL.N60nLS8qKP50QPwDNI.AC1Ru8DtBLMFg2TXgYk3w6LARspJTKK', 'guru', '2026-09-30 07:15:42'),
(5, 'rasya', '$2y$10$XUljdSWcWlh.ggvp3Sj6MuLrrYzcM57NE8D6rTGNpeygEtdFLGb/q', 'admin', '2026-10-29 10:37:44'),
(6, 'budii', '$2y$10$uC8QEngcXXUGW6V3n5fgrugDG61MPzY1qQByk/FCVVWUSAZYFcIui', 'guru', '2026-10-29 12:08:32'),
(7, 'sitii', '$2y$10$HWjIGDt0iB./axYm/rSyVOM.B6RrupGZI5xQlQb6n5M66QAIeCgZO', 'guru', '2026-10-29 12:08:32'),
(8, 'andii', '$2y$12$xCCgFmxmkLk19AnY3SfXWOAjN/0qEm2kcyc2s9gLigZHxFj0PUq/q', 'guru', '2026-10-29 12:08:32'),
(9, 'rinaa', '$2y$12$xCCgFmxmkLk19AnY3SfXWOAjN/0qEm2kcyc2s9gLigZHxFj0PUq/q', 'guru', '2026-10-29 12:08:32'),
(10, 'dedii', '$2y$12$xCCgFmxmkLk19AnY3SfXWOAjN/0qEm2kcyc2s9gLigZHxFj0PUq/q', 'guru', '2026-10-29 12:08:32'),
(11, 'fitrii', '$2y$12$xCCgFmxmkLk19AnY3SfXWOAjN/0qEm2kcyc2s9gLigZHxFj0PUq/q', 'guru', '2026-10-29 12:08:32'),
(12, 'aguss', '$2y$12$xCCgFmxmkLk19AnY3SfXWOAjN/0qEm2kcyc2s9gLigZHxFj0PUq/q', 'guru', '2026-10-29 12:08:32'),
(13, 'niaa', '$2y$12$xCCgFmxmkLk19AnY3SfXWOAjN/0qEm2kcyc2s9gLigZHxFj0PUq/q', 'guru', '2026-10-29 12:08:32'),
(14, 'rizkyy', '$2y$12$xCCgFmxmkLk19AnY3SfXWOAjN/0qEm2kcyc2s9gLigZHxFj0PUq/q', 'guru', '2026-10-29 12:08:32'),
(15, 'auliaa', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(16, 'fajarr', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(17, 'nabilaa', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(18, 'dimass', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(19, 'citraa', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(20, 'rezaa', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(21, 'intann', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(22, 'bagass', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32'),
(23, 'putrii', '$2y$12$WgyT2Uwx1kwdFNHHoo03eevOBWodZ0gG1CFJxQIGRQXxGgxuJ.jqO', 'siswa', '2026-10-29 12:08:32');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_nip` (`nip`),
  ADD KEY `idx_guru_user` (`user_id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_kode_mapel` (`kode_mapel`),
  ADD KEY `idx_mapel_guru` (`guru_id`);

--
-- Indeks untuk tabel `mengajar`
--
ALTER TABLE `mengajar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mengajar_mapel` (`mapel_id`),
  ADD KEY `idx_mengajar_siswa` (`siswa_id`);

--
-- Indeks untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nilai_siswa` (`siswa_id`),
  ADD KEY `idx_nilai_mapel` (`mapel_id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_nis` (`nis`),
  ADD KEY `idx_siswa_user` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `mengajar`
--
ALTER TABLE `mengajar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `fk_guru_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `fk_mapel_guru` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mengajar`
--
ALTER TABLE `mengajar`
  ADD CONSTRAINT `fk_mengajar_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mengajar_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD CONSTRAINT `fk_nilai_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nilai_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
