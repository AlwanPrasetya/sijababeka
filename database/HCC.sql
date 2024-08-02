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


-- Dumping database structure for settings
CREATE DATABASE IF NOT EXISTS `settings` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `settings`;

-- Dumping structure for table settings.persetujuan
CREATE TABLE IF NOT EXISTS `persetujuan` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `kodeFPK` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `PersetujuanUser` varchar(50) NOT NULL DEFAULT '0',
  `PersetujuanAtasan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `PersetujuanDireksi2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `PersetujuanDireksi3` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `PersetujuanPresdir` varchar(50) NOT NULL,
  `PersetujuanAdmin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `PersetujuanCorpHr` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `PersetujuanSuperadmin` varchar(50) NOT NULL,
  `Status_Penyetujuan` enum('Pending','Approved') DEFAULT 'Pending',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table settings.persetujuan: ~3 rows (approximately)
INSERT INTO `persetujuan` (`ID`, `kodeFPK`, `PersetujuanUser`, `PersetujuanAtasan`, `PersetujuanDireksi2`, `PersetujuanDireksi3`, `PersetujuanPresdir`, `PersetujuanAdmin`, `PersetujuanCorpHr`, `PersetujuanSuperadmin`, `Status_Penyetujuan`) VALUES
	(92, 'ZDY0O6PI', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Pending'),
	(93, 'RCKVA2F3', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Approved'),
	(94, 'Q69SFHZV', 'Disetujui', '', '', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Disetujui', 'Approved');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
