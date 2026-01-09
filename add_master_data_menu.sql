-- SQL untuk menambahkan menu Master Data Sistem Rekomendasi
-- Jalankan SQL ini di database Anda

-- Insert menu items ke tabel menu
INSERT INTO `menu` (`id`, `nama`, `link`, `class_icon`, `is_parent`, `id_parent`, `keterangan`) VALUES
(12, 'Sistem Rekomendasi', '#', 'fa fa-cogs', '1', NULL, 'Menu Sistem Rekomendasi'),
(13, 'Jenis Perbaikan', 'Master_data/jenis_perbaikan', NULL, '2', '12', 'Data Master Jenis Perbaikan'),
(14, 'Gejala Kerusakan', 'Master_data/gejala_kerusakan', NULL, '2', '12', 'Data Master Gejala Kerusakan'),
(15, 'Jenis Kerusakan', 'Master_data/jenis_kerusakan', NULL, '2', '12', 'Data Master Jenis Kerusakan'),
(16, 'Rekomendasi Perbaikan', 'Master_data/rekomendasi_perbaikan', NULL, '2', '12', 'Data Master Rekomendasi Perbaikan');

-- Insert menu_user untuk role SUPERADMIN
-- Menu utama: Sistem Rekomendasi (Level 1)
INSERT INTO `menu_user` (`id_menu`, `id_role`, `posisi`, `urutan`, `level`, `id_parent`) VALUES
(12, 'SUPERADMIN', '1', 4, 1, NULL);

-- Sub menu: Jenis Perbaikan (Level 2)
INSERT INTO `menu_user` (`id_menu`, `id_role`, `posisi`, `urutan`, `level`, `id_parent`) VALUES
(13, 'SUPERADMIN', '1', 1, 2, 12);

-- Sub menu: Gejala Kerusakan (Level 2)
INSERT INTO `menu_user` (`id_menu`, `id_role`, `posisi`, `urutan`, `level`, `id_parent`) VALUES
(14, 'SUPERADMIN', '1', 2, 2, 12);

-- Sub menu: Jenis Kerusakan (Level 2)
INSERT INTO `menu_user` (`id_menu`, `id_role`, `posisi`, `urutan`, `level`, `id_parent`) VALUES
(15, 'SUPERADMIN', '1', 3, 2, 12);

-- Sub menu: Rekomendasi Perbaikan (Level 2)
INSERT INTO `menu_user` (`id_menu`, `id_role`, `posisi`, `urutan`, `level`, `id_parent`) VALUES
(16, 'SUPERADMIN', '1', 4, 2, 12);

-- CATATAN:
-- Jika Anda memiliki role lain selain SUPERADMIN, tambahkan juga untuk role tersebut
-- Contoh untuk role 'ADMIN':
-- INSERT INTO `menu_user` (`id_menu`, `id_role`, `posisi`, `urutan`, `level`, `id_parent`) VALUES
-- (12, 'ADMIN', '1', 4, 1, NULL),
-- (13, 'ADMIN', '1', 1, 2, 12),
-- (14, 'ADMIN', '1', 2, 2, 12),
-- (15, 'ADMIN', '1', 3, 2, 12),
-- (16, 'ADMIN', '1', 4, 2, 12);
