-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_sijababeka
CREATE DATABASE IF NOT EXISTS `db_sijababeka` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_sijababeka`;

-- Dumping structure for table db_sijababeka.hcc
CREATE TABLE IF NOT EXISTS `hcc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fpk_selection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_candidates` varchar(255) NOT NULL,
  `nama_kandidat` varchar(255) NOT NULL,
  `golongan` varchar(255) NOT NULL,
  `form_tanggal_lengkap` date NOT NULL,
  `branch` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `organisasi` varchar(255) NOT NULL,
  `alasan_penerimaan` text NOT NULL,
  `gaji_pokok` varchar(50) NOT NULL DEFAULT '',
  `tunjangan_makan` varchar(50) NOT NULL DEFAULT '',
  `tunjangan_transport` varchar(50) NOT NULL DEFAULT '',
  `tunjangan_kendaraan` varchar(50) NOT NULL DEFAULT '',
  `bpjs_jht` varchar(50) NOT NULL DEFAULT '',
  `bpjs_jp` varchar(50) NOT NULL DEFAULT '',
  `bpjs_kesehatan` varchar(50) NOT NULL DEFAULT '',
  `koperasi_karyawan` varchar(50) NOT NULL DEFAULT '',
  `form_aplikasi` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `pas_foto` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `form_interview_user` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `foto_ktp` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `form_interview_hr` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `foto_ijazah` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `form_hasil_psikotest` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `foto_transkip_nilai` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `form_confirmation_letter` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `foto_buku_tabungan` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `form_hasil_tes_kesehatan` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `foto_npwp` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `referensi_kerja` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `foto_kk` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `foto_sertifikat` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `bpjs_ketenagakerjaan` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `bpjs_jaminan_pensiun` enum('Lengkap','Tidak Lengkap') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_sijababeka.hcc: ~3 rows (approximately)
INSERT INTO `hcc` (`id`, `fpk_selection`, `id_candidates`, `nama_kandidat`, `golongan`, `form_tanggal_lengkap`, `branch`, `no_ktp`, `jabatan`, `pendidikan`, `organisasi`, `alasan_penerimaan`, `gaji_pokok`, `tunjangan_makan`, `tunjangan_transport`, `tunjangan_kendaraan`, `bpjs_jht`, `bpjs_jp`, `bpjs_kesehatan`, `koperasi_karyawan`, `form_aplikasi`, `pas_foto`, `form_interview_user`, `foto_ktp`, `form_interview_hr`, `foto_ijazah`, `form_hasil_psikotest`, `foto_transkip_nilai`, `form_confirmation_letter`, `foto_buku_tabungan`, `form_hasil_tes_kesehatan`, `foto_npwp`, `referensi_kerja`, `foto_kk`, `foto_sertifikat`, `bpjs_ketenagakerjaan`, `bpjs_jaminan_pensiun`, `created_at`, `updated_at`) VALUES
	(1, 'G6O4CAFM', 'ID-yjby4tk5y', 'Alwan Prasetya', '24', '2002-03-31', 'KAWASAN INDUSTRI JABABEKA (KIJA)-Cikarang', '3574013103020001', '010909 - Staff Khusus KIJ', 'Strata 1 / Diploma 4', 'Divisi Corporate Secretary KIJ', 'PHK', 'Rp 12.345.678', 'Rp 1.234.567', 'Rp 1.234.563', 'Rp 23.456.754', 'Rp 1.000.000', 'Rp 2.000.000', 'Lengkap', 'Rp 3.000.000', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', '2024-07-02 05:18:16', '2024-07-02 05:39:49'),
	(2, 'G6O4CAFM', 'ID-1gjvv2t5j', 'Mantes Simanjuntak', '24', '1993-10-25', 'KAWASAN INDUSTRI JABABEKA (KIJA)-Cikarang', '3574013103020001', '010909 - Staff Khusus KIJ', 'Strata 1 / Diploma 4', 'Divisi Corporate Secretary KIJ', 'PHK', 'Rp 12.345.678', 'Rp 1.234.567', 'Rp 1.234.563', 'Rp 23.456.754', 'Rp 1.000.000', 'Rp 2.000.000', 'Tidak Lengkap', 'Rp 3.000.000', 'Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', 'Tidak Lengkap', '2024-07-02 05:23:26', '2024-07-02 05:39:56'),
	(3, 'G6O4CAFM', 'ID-yjby4tk5y', 'Alwan Prasetya', '24', '2002-03-31', 'KAWASAN INDUSTRI JABABEKA (KIJA)-Cikarang', '3574013103020001', '010909 - Staff Khusus KIJ', 'Strata 1 / Diploma 4', 'Divisi Corporate Secretary KIJ', 'PHK', 'Rp 12.345.678', 'Rp 1.234.567', 'Rp 1.234.563', 'Rp 23.456.754', 'Rp 1.000.000', 'Rp 2.000.000', 'Lengkap', 'Rp 3.000.000', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', 'Lengkap', '2024-07-02 05:37:57', '2024-07-02 05:37:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
