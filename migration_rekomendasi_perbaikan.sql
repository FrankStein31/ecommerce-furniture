-- ============================================
-- MIGRATION: Sistem Rekomendasi Perbaikan
-- Tanggal: 9 Januari 2026
-- Deskripsi: Tabel untuk Forward Chaining & Certainty Factor
-- ============================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- 1. TABEL: kategori_jenis_perbaikan
-- ============================================
DROP TABLE IF EXISTS `kategori_jenis_perbaikan`;
CREATE TABLE `kategori_jenis_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL COMMENT 'Nama kategori (Sofa, Kursi Kantor, dll)',
  `deskripsi` text NULL COMMENT 'Deskripsi kategori',
  `icon` varchar(255) NULL COMMENT 'Icon/gambar kategori',
  `urutan` int DEFAULT 0 COMMENT 'Urutan tampil',
  `status` enum('1','0') DEFAULT '1' COMMENT '1=Aktif, 0=Nonaktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Kategori utama jenis furniture';

-- ============================================
-- 2. TABEL: jenis_perbaikan
-- ============================================
DROP TABLE IF EXISTS `jenis_perbaikan`;
CREATE TABLE `jenis_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int NOT NULL COMMENT 'FK ke kategori_jenis_perbaikan',
  `nama_jenis_perbaikan` varchar(200) NOT NULL COMMENT 'Nama jenis furniture spesifik',
  `deskripsi` text NULL COMMENT 'Deskripsi detail',
  `gambar` varchar(255) NULL COMMENT 'Foto furniture',
  `urutan` int DEFAULT 0,
  `status` enum('1','0') DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_jenis_perbaikan_kategori` (`id_kategori`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE,
  CONSTRAINT `fk_jenis_perbaikan_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_jenis_perbaikan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jenis furniture yang bisa diperbaiki';

-- ============================================
-- 3. TABEL: gejala_kerusakan
-- ============================================
DROP TABLE IF EXISTS `gejala_kerusakan`;
CREATE TABLE `gejala_kerusakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_gejala` varchar(20) NOT NULL COMMENT 'Kode unik gejala (G001, G002, ...)',
  `nama_gejala` varchar(255) NOT NULL COMMENT 'Nama gejala singkat',
  `deskripsi_gejala` text NULL COMMENT 'Penjelasan detail gejala',
  `pertanyaan` text NOT NULL COMMENT 'Pertanyaan untuk pelanggan',
  `urutan` int DEFAULT 0,
  `status` enum('1','0') DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_kode_gejala` (`kode_gejala`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master data gejala kerusakan';

-- ============================================
-- 4. TABEL: jenis_kerusakan
-- ============================================
DROP TABLE IF EXISTS `jenis_kerusakan`;
CREATE TABLE `jenis_kerusakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_kerusakan` varchar(20) NOT NULL COMMENT 'Kode unik (JK001, JK002, ...)',
  `nama_jenis_kerusakan` varchar(255) NOT NULL COMMENT 'Nama kerusakan singkat',
  `detail_kerusakan` text NULL COMMENT 'Penjelasan detail',
  `pertanyaan` text NOT NULL COMMENT 'Pertanyaan untuk pelanggan',
  `ilustrasi_gambar` varchar(255) NULL COMMENT 'Path gambar ilustrasi',
  `tingkat_kerusakan` enum('ringan','sedang','berat') DEFAULT 'sedang' COMMENT 'Tingkat kerusakan',
  `urutan` int DEFAULT 0,
  `status` enum('1','0') DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_kode_kerusakan` (`kode_kerusakan`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE,
  KEY `idx_tingkat` (`tingkat_kerusakan`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master data jenis kerusakan';

-- ============================================
-- 5. TABEL: rekomendasi_perbaikan
-- ============================================
DROP TABLE IF EXISTS `rekomendasi_perbaikan`;
CREATE TABLE `rekomendasi_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_rekomendasi` varchar(20) NOT NULL COMMENT 'Kode unik (R001, R002, ...)',
  `nama_rekomendasi` varchar(255) NOT NULL COMMENT 'Nama rekomendasi singkat',
  `detail_perbaikan` text NULL COMMENT 'Detail langkah perbaikan',
  `estimasi_harga_min` decimal(12,2) NULL COMMENT 'Harga minimum',
  `estimasi_harga_max` decimal(12,2) NULL COMMENT 'Harga maksimum',
  `estimasi_waktu` varchar(100) NULL COMMENT 'Estimasi waktu (2-3 hari, 1 minggu, dll)',
  `mb_value` decimal(3,2) DEFAULT 0.00 COMMENT 'Measure of Belief (0.00 - 1.00)',
  `md_value` decimal(3,2) DEFAULT 0.00 COMMENT 'Measure of Disbelief (0.00 - 1.00)',
  `urutan` int DEFAULT 0,
  `status` enum('1','0') DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_kode_rekomendasi` (`kode_rekomendasi`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master data rekomendasi perbaikan dengan MB & MD';

-- ============================================
-- 6. TABEL: relasi_gejala_jenis_perbaikan
-- Relasi many-to-many: gejala <-> jenis perbaikan
-- ============================================
DROP TABLE IF EXISTS `relasi_gejala_jenis_perbaikan`;
CREATE TABLE `relasi_gejala_jenis_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jenis_perbaikan` int NOT NULL,
  `id_gejala_kerusakan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_relasi_gejala_jp` (`id_jenis_perbaikan`, `id_gejala_kerusakan`) USING BTREE,
  KEY `fk_relasi_gejala_jp` (`id_jenis_perbaikan`) USING BTREE,
  KEY `fk_relasi_gejala_gk` (`id_gejala_kerusakan`) USING BTREE,
  CONSTRAINT `fk_relasi_gejala_jp` FOREIGN KEY (`id_jenis_perbaikan`) REFERENCES `jenis_perbaikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_relasi_gejala_gk` FOREIGN KEY (`id_gejala_kerusakan`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi gejala dengan jenis perbaikan';

-- ============================================
-- 7. TABEL: relasi_jenis_kerusakan_gejala
-- Relasi many-to-many: jenis kerusakan <-> gejala
-- ============================================
DROP TABLE IF EXISTS `relasi_jenis_kerusakan_gejala`;
CREATE TABLE `relasi_jenis_kerusakan_gejala` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jenis_kerusakan` int NOT NULL,
  `id_gejala_kerusakan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_relasi_jk_gejala` (`id_jenis_kerusakan`, `id_gejala_kerusakan`) USING BTREE,
  KEY `fk_relasi_jk_jk` (`id_jenis_kerusakan`) USING BTREE,
  KEY `fk_relasi_jk_gejala` (`id_gejala_kerusakan`) USING BTREE,
  CONSTRAINT `fk_relasi_jk_jk` FOREIGN KEY (`id_jenis_kerusakan`) REFERENCES `jenis_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_relasi_jk_gejala` FOREIGN KEY (`id_gejala_kerusakan`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi jenis kerusakan dengan gejala';

-- ============================================
-- 8. TABEL: relasi_rekomendasi_jenis_kerusakan
-- Relasi many-to-many: rekomendasi <-> jenis kerusakan
-- ============================================
DROP TABLE IF EXISTS `relasi_rekomendasi_jenis_kerusakan`;
CREATE TABLE `relasi_rekomendasi_jenis_kerusakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_rekomendasi_perbaikan` int NOT NULL,
  `id_jenis_kerusakan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_relasi_rek_jk` (`id_rekomendasi_perbaikan`, `id_jenis_kerusakan`) USING BTREE,
  KEY `fk_relasi_rek_rek` (`id_rekomendasi_perbaikan`) USING BTREE,
  KEY `fk_relasi_rek_jk` (`id_jenis_kerusakan`) USING BTREE,
  CONSTRAINT `fk_relasi_rek_rek` FOREIGN KEY (`id_rekomendasi_perbaikan`) REFERENCES `rekomendasi_perbaikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_relasi_rek_jk` FOREIGN KEY (`id_jenis_kerusakan`) REFERENCES `jenis_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi rekomendasi dengan jenis kerusakan';

-- ============================================
-- 9. TABEL: diagnosis_session
-- Menyimpan sesi diagnosis pelanggan
-- ============================================
DROP TABLE IF EXISTS `diagnosis_session`;
CREATE TABLE `diagnosis_session` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'UUID session',
  `id_user` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'FK ke users (jika login), NULL jika guest',
  `id_kategori` int NOT NULL COMMENT 'FK ke kategori_jenis_perbaikan',
  `id_jenis_perbaikan` int NOT NULL COMMENT 'FK ke jenis_perbaikan',
  `nama_pelanggan` varchar(100) NULL COMMENT 'Nama (untuk guest)',
  `email_pelanggan` varchar(100) NULL COMMENT 'Email (untuk guest)',
  `no_telp_pelanggan` varchar(20) NULL COMMENT 'No Telp (untuk guest)',
  `status_diagnosis` enum('in_progress','completed','cancelled') DEFAULT 'in_progress',
  `hasil_rekomendasi_id` int NULL COMMENT 'FK ke rekomendasi_perbaikan (hasil akhir)',
  `cf_total` decimal(5,4) NULL COMMENT 'Total CF dari perhitungan',
  `metode_terpilih` enum('forward_chaining','certainty_factor','decision_tree') NULL COMMENT 'Metode yang digunakan',
  `detail_perhitungan` text NULL COMMENT 'JSON detail perhitungan FC & CF',
  `ip_address` varchar(50) NULL,
  `user_agent` text NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_diagnosis_user` (`id_user`) USING BTREE,
  KEY `fk_diagnosis_kategori` (`id_kategori`) USING BTREE,
  KEY `fk_diagnosis_jenis_perbaikan` (`id_jenis_perbaikan`) USING BTREE,
  KEY `fk_diagnosis_rekomendasi` (`hasil_rekomendasi_id`) USING BTREE,
  KEY `idx_status` (`status_diagnosis`) USING BTREE,
  KEY `idx_created` (`created_at`) USING BTREE,
  CONSTRAINT `fk_diagnosis_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_diagnosis_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_jenis_perbaikan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_diagnosis_jenis_perbaikan` FOREIGN KEY (`id_jenis_perbaikan`) REFERENCES `jenis_perbaikan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_diagnosis_rekomendasi` FOREIGN KEY (`hasil_rekomendasi_id`) REFERENCES `rekomendasi_perbaikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sesi diagnosis pelanggan';

-- ============================================
-- 10. TABEL: diagnosis_jawaban
-- Menyimpan jawaban pelanggan untuk setiap gejala/kerusakan
-- ============================================
DROP TABLE IF EXISTS `diagnosis_jawaban`;
CREATE TABLE `diagnosis_jawaban` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_diagnosis_session` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'FK ke diagnosis_session',
  `tipe_pertanyaan` enum('gejala','kerusakan') NOT NULL COMMENT 'Tipe pertanyaan',
  `id_gejala_kerusakan` int NULL COMMENT 'FK ke gejala_kerusakan (jika tipe=gejala)',
  `id_jenis_kerusakan` int NULL COMMENT 'FK ke jenis_kerusakan (jika tipe=kerusakan)',
  `jawaban` enum('ya','tidak') NOT NULL COMMENT 'Jawaban pelanggan',
  `cf_user` decimal(3,2) NULL COMMENT 'Certainty Factor dari user (0.00 - 1.00)',
  `cf_user_text` varchar(50) NULL COMMENT 'Text pilihan CF (Sangat Yakin, Yakin, dll)',
  `urutan_jawab` int DEFAULT 0 COMMENT 'Urutan jawaban',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_jawaban_session` (`id_diagnosis_session`) USING BTREE,
  KEY `fk_jawaban_gejala` (`id_gejala_kerusakan`) USING BTREE,
  KEY `fk_jawaban_kerusakan` (`id_jenis_kerusakan`) USING BTREE,
  KEY `idx_tipe` (`tipe_pertanyaan`) USING BTREE,
  KEY `idx_jawaban` (`jawaban`) USING BTREE,
  CONSTRAINT `fk_jawaban_session` FOREIGN KEY (`id_diagnosis_session`) REFERENCES `diagnosis_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_jawaban_gejala` FOREIGN KEY (`id_gejala_kerusakan`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_jawaban_kerusakan` FOREIGN KEY (`id_jenis_kerusakan`) REFERENCES `jenis_kerusakan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jawaban diagnosis pelanggan';

-- ============================================
-- SAMPLE DATA: kategori_jenis_perbaikan
-- Data dari Excel sheet "Kategori mebel" row 1 kolom B-G
-- ============================================
INSERT INTO `kategori_jenis_perbaikan` (`nama_kategori`, `deskripsi`, `urutan`, `status`) VALUES
('Sofa', 'Perbaikan dan servis sofa berbagai ukuran dan model', 1, '1'),
('Kursi Kantor', 'Perbaikan kursi kantor, gaming, dan kerja', 2, '1'),
('Kursi Tamu', 'Perbaikan kursi tamu dan ruang tamu', 3, '1'),
('Jok Kendaraan', 'Perbaikan jok mobil, motor, dan kendaraan lainnya', 4, '1'),
('Springbed & Kasur', 'Perbaikan springbed, kasur, dan tempat tidur', 5, '1'),
('Lain-lain', 'Furniture dan mebel lainnya', 6, '1');

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- SELESAI MIGRATION
-- ============================================
