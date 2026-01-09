-- ALTER TABLE untuk menambahkan kolom baru di rekomendasi_perbaikan
-- Menambahkan kolom yang dibutuhkan oleh controller

USE `ecommerce-furniture`;

-- Tambah kolom deskripsi_rekomendasi (rename dari detail_perbaikan)
ALTER TABLE `rekomendasi_perbaikan` 
  CHANGE COLUMN `detail_perbaikan` `deskripsi_rekomendasi` TEXT NULL COMMENT 'Deskripsi singkat rekomendasi';

-- Tambah kolom cf_value (Certainty Factor = MB - MD)
ALTER TABLE `rekomendasi_perbaikan` 
  ADD COLUMN `cf_value` DECIMAL(3,2) DEFAULT 0.00 COMMENT 'Certainty Factor (MB - MD)' AFTER `md_value`;

-- Tambah kolom solusi_perbaikan
ALTER TABLE `rekomendasi_perbaikan` 
  ADD COLUMN `solusi_perbaikan` TEXT NULL COMMENT 'Langkah-langkah detail perbaikan' AFTER `cf_value`;

-- Tambah kolom biaya_estimasi (menggabungkan min/max menjadi satu)
ALTER TABLE `rekomendasi_perbaikan` 
  ADD COLUMN `biaya_estimasi` DECIMAL(12,2) DEFAULT 0 COMMENT 'Estimasi biaya perbaikan' AFTER `solusi_perbaikan`;

-- Tambah kolom durasi_perbaikan (dalam hari)
ALTER TABLE `rekomendasi_perbaikan` 
  ADD COLUMN `durasi_perbaikan` INT DEFAULT 0 COMMENT 'Durasi perbaikan dalam hari' AFTER `biaya_estimasi`;

-- Tambah kolom tingkat_prioritas
ALTER TABLE `rekomendasi_perbaikan` 
  ADD COLUMN `tingkat_prioritas` ENUM('rendah','sedang','tinggi') DEFAULT 'sedang' COMMENT 'Tingkat prioritas rekomendasi' AFTER `durasi_perbaikan`;

-- Update kolom estimasi_waktu jadi nullable
ALTER TABLE `rekomendasi_perbaikan` 
  MODIFY COLUMN `estimasi_waktu` VARCHAR(100) NULL COMMENT 'Estimasi waktu (opsional, untuk referensi)';

-- Hapus kolom yang tidak digunakan (opsional, bisa dikomentari jika ingin keep)
-- ALTER TABLE `rekomendasi_perbaikan` DROP COLUMN `estimasi_harga_min`;
-- ALTER TABLE `rekomendasi_perbaikan` DROP COLUMN `estimasi_harga_max`;
-- ALTER TABLE `rekomendasi_perbaikan` DROP COLUMN `urutan`;

SELECT 'ALTER TABLE rekomendasi_perbaikan berhasil!' as status;
