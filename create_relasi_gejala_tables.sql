-- Tabel relasi many-to-many antara gejala_kerusakan dan jenis_perbaikan
-- Satu gejala bisa dialami oleh banyak jenis furniture
-- Satu jenis furniture bisa memiliki banyak gejala

CREATE TABLE IF NOT EXISTS `gejala_jenis_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_gejala` int NOT NULL COMMENT 'FK ke gejala_kerusakan',
  `id_jenis_perbaikan` int NOT NULL COMMENT 'FK ke jenis_perbaikan',
  `keterangan` text COLLATE utf8mb4_unicode_ci COMMENT 'Keterangan tambahan relasi',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_gejala` (`id_gejala`),
  KEY `idx_jenis` (`id_jenis_perbaikan`),
  UNIQUE KEY `unique_gejala_jenis` (`id_gejala`, `id_jenis_perbaikan`),
  CONSTRAINT `fk_gjp_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gjp_jenis` FOREIGN KEY (`id_jenis_perbaikan`) REFERENCES `jenis_perbaikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi many-to-many gejala dan jenis perbaikan';

-- Tabel relasi many-to-many antara jenis_kerusakan dan gejala_kerusakan
-- Satu jenis kerusakan bisa memiliki banyak gejala
-- Satu gejala bisa menjadi indikasi dari banyak jenis kerusakan

CREATE TABLE IF NOT EXISTS `jenis_kerusakan_gejala` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jenis_kerusakan` int NOT NULL COMMENT 'FK ke jenis_kerusakan',
  `id_gejala` int NOT NULL COMMENT 'FK ke gejala_kerusakan',
  `bobot` decimal(3,2) DEFAULT NULL COMMENT 'Bobot gejala untuk kerusakan ini (0.00-1.00)',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_jenis_kerusakan` (`id_jenis_kerusakan`),
  KEY `idx_gejala` (`id_gejala`),
  UNIQUE KEY `unique_kerusakan_gejala` (`id_jenis_kerusakan`, `id_gejala`),
  CONSTRAINT `fk_jkg_jenis_kerusakan` FOREIGN KEY (`id_jenis_kerusakan`) REFERENCES `jenis_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_jkg_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi many-to-many jenis kerusakan dan gejala';

-- Insert data relasi gejala dengan jenis perbaikan (contoh)
-- Sesuaikan dengan kebutuhan bisnis Anda

-- Gejala G01 (Rembes) bisa dialami oleh sofa, kursi tamu, dll
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
-- Kategori Sofa (id_kategori = 1)
(1, 1, 'Kursi sofa 321 kipas sering mengalami rembes'),
(1, 2, 'Kursi 321 jaguar rentan rembes'),
(1, 3, 'Kursi sofa valenci dapat mengalami rembes'),
(1, 4, 'Kursi sofa tunggu bisa rembes'),
(1, 5, 'Kursi sofa lesehan sering rembes'),
(1, 6, 'Kursi sofa (L) sudut dapat rembes'),
(1, 7, 'Kursi sofa (L) minimalis bisa rembes');

-- Gejala G02 (Kurang nyaman diduduki) untuk berbagai kursi
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
(2, 1, 'Kenyamanan berkurang seiring waktu'),
(2, 2, 'Dudukan menjadi tidak nyaman'),
(2, 3, NULL),
(2, 4, NULL),
(2, 19, 'Kursi kantor putar sering tidak nyaman'),
(2, 60, 'Kasur springbed bisa tidak nyaman'),
(2, 61, NULL),
(2, 62, NULL);

-- Gejala G03 (Amblas ketika diduduki)
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
(3, 1, 'Dudukan amblas karena busa kempes'),
(3, 2, NULL),
(3, 3, NULL),
(3, 5, NULL),
(3, 6, NULL),
(3, 19, 'Kursi kantor bisa amblas'),
(3, 60, 'Springbed amblas'),
(3, 61, NULL);

-- Gejala G04 (Warna kain memudar, aus)
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
(4, 1, 'Warna kain pudar karena sinar matahari'),
(4, 2, NULL),
(4, 3, NULL),
(4, 4, NULL),
(4, 8, 'Kursi tamu ligna'),
(4, 9, 'Kursi tamu Jengki'),
(4, 19, 'Kursi kantor'),
(4, 60, 'Kasur springbed'),
(4, 63, 'Kasur busa');

-- Gejala G05 (Kerusakan ringan)
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
(5, 1, NULL),
(5, 2, NULL),
(5, 8, NULL),
(5, 10, 'Kursi kayu gajagan'),
(5, 11, 'Kursi kayu tigeran'),
(5, 19, NULL),
(5, 22, 'Kursi rias');

-- Gejala G06 (Kain kursi memar atau pipih)
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
(6, 1, 'Kain sofa memar'),
(6, 2, NULL),
(6, 3, NULL),
(6, 19, 'Kursi kantor memar'),
(6, 60, 'Springbed pipih'),
(6, 61, NULL),
(6, 62, NULL),
(6, 63, 'Kasur busa pipih');

-- Gejala G07 (Kain retak dan pecah-pecah)
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
(7, 1, 'Kain sofa retak karena usia'),
(7, 2, NULL),
(7, 3, NULL),
(7, 25, 'Jok motor retak'),
(7, 26, NULL),
(7, 50, 'Jok mobil retak'),
(7, 51, NULL),
(7, 60, 'Cover springbed retak');

-- Gejala G08 (Kerangka reyot)
INSERT INTO `gejala_jenis_perbaikan` (`id_gejala`, `id_jenis_perbaikan`, `keterangan`) VALUES
(8, 1, 'Kerangka sofa reyot'),
(8, 2, NULL),
(8, 6, NULL),
(8, 8, 'Kursi tamu ligna kerangka reyot'),
(8, 10, 'Kursi kayu gajagan'),
(8, 11, 'Kursi kayu tigeran'),
(8, 19, 'Kursi kantor reyot');

-- Catatan: Data di atas adalah contoh. 
-- Silakan sesuaikan dengan data real dari Excel atau kebutuhan bisnis Anda.
-- Total ada 68 jenis perbaikan dan 8 gejala, jadi bisa dibuat lebih banyak relasi.
