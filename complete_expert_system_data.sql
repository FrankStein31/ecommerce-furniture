-- ============================================
-- COMPLETE EXPERT SYSTEM DATA
-- Sistem Pakar Rekomendasi Perbaikan Furniture
-- ============================================

-- 1. KATEGORI JENIS PERBAIKAN (Lengkap)
INSERT INTO `kategori_jenis_perbaikan` (`id`, `nama_kategori`, `deskripsi`, `icon`, `urutan`, `status`) VALUES
(1, 'Sofa & Kursi Tamu', 'Perbaikan untuk sofa, kursi tamu, dan furniture ruang tamu', 'fa-couch', 1, '1'),
(2, 'Kursi Kantor', 'Perbaikan kursi kantor, gaming, dan ergonomis', 'fa-chair', 2, '1'),
(3, 'Kasur & Spring Bed', 'Perbaikan kasur, spring bed, dan furniture kamar tidur', 'fa-bed', 3, '1'),
(4, 'Jok Mobil & Motor', 'Perbaikan jok kendaraan bermotor', 'fa-car', 4, '1'),
(5, 'Furniture Kayu', 'Perbaikan furniture berbahan kayu', 'fa-tree', 5, '1');

-- 2. JENIS PERBAIKAN (Per Kategori)
INSERT INTO `jenis_perbaikan` (`id`, `id_kategori`, `kode_jenis_perbaikan`, `nama_jenis_perbaikan`, `deskripsi`, `status`) VALUES
-- Sofa & Kursi Tamu
(1, 1, 'JP-001', 'Ganti Kulit/Kain Sofa', 'Penggantian pelapis sofa dengan bahan kulit atau kain baru', '1'),
(2, 1, 'JP-002', 'Perbaikan Busa Sofa', 'Penggantian atau perbaikan busa sofa yang kempes/rusak', '1'),
(3, 1, 'JP-003', 'Perbaikan Rangka Sofa', 'Perbaikan atau penguatan rangka kayu/besi sofa', '1'),
(4, 1, 'JP-004', 'Service Per Sofa', 'Perbaikan sistem per/pegas sofa yang kendor', '1'),

-- Kursi Kantor
(5, 2, 'JP-005', 'Ganti Jok Kursi Kantor', 'Penggantian jok/busa kursi kantor', '1'),
(6, 2, 'JP-006', 'Perbaikan Gas Lift', 'Perbaikan sistem hydraulic/gas lift kursi', '1'),
(7, 2, 'JP-007', 'Ganti Roda Kursi', 'Penggantian roda/caster kursi kantor', '1'),
(8, 2, 'JP-008', 'Perbaikan Sandaran', 'Perbaikan mekanisme sandaran dan tilt kursi', '1'),

-- Kasur & Spring Bed
(9, 3, 'JP-009', 'Ganti Per Spring Bed', 'Penggantian sistem per/spring kasur', '1'),
(10, 3, 'JP-010', 'Tambal Kasur Angin', 'Perbaikan kebocoran kasur angin/air bed', '1'),
(11, 3, 'JP-011', 'Ganti Busa Kasur', 'Penggantian busa kasur yang kempes', '1'),
(12, 3, 'JP-012', 'Perbaikan Rangka Kasur', 'Perbaikan rangka/divan spring bed', '1'),

-- Jok Mobil & Motor
(13, 4, 'JP-013', 'Ganti Kulit Jok Mobil', 'Penggantian pelapis jok mobil dengan kulit/MBTech', '1'),
(14, 4, 'JP-014', 'Perbaikan Busa Jok Motor', 'Penggantian busa jok motor yang kempes', '1'),
(15, 4, 'JP-015', 'Custom Jok Racing', 'Custom jok dengan model racing/sport', '1'),
(16, 4, 'JP-016', 'Repair Sobek Jok', 'Perbaikan robekan pada jok kendaraan', '1'),

-- Furniture Kayu
(17, 5, 'JP-017', 'Refinishing Kayu', 'Pengamplasan dan finishing ulang furniture kayu', '1'),
(18, 5, 'JP-018', 'Perbaikan Sambungan', 'Perbaikan sambungan/konstruksi furniture kayu', '1'),
(19, 5, 'JP-019', 'Anti Rayap Treatment', 'Treatment anti rayap dan penguat kayu', '1'),
(20, 5, 'JP-020', 'Cat Ulang Furniture', 'Pengecatan ulang furniture kayu', '1');

-- 3. GEJALA KERUSAKAN (Lengkap dengan Pertanyaan)
INSERT INTO `gejala_kerusakan` (`id`, `kode_gejala`, `nama_gejala`, `pertanyaan`, `deskripsi_gejala`, `status`) VALUES
-- Gejala Umum Pelapis
(1, 'G-001', 'Kain/Kulit Sobek', 'Apakah pelapis furniture Anda robek atau sobek?', 'Robekan pada kain, kulit, atau bahan pelapis', '1'),
(2, 'G-002', 'Warna Pudar', 'Apakah warna pelapis sudah pudar atau kusam?', 'Perubahan warna akibat sinar UV atau usia', '1'),
(3, 'G-003', 'Noda Membandel', 'Apakah ada noda yang sulit dibersihkan?', 'Noda permanen dari makanan, minuman, atau tinta', '1'),
(4, 'G-004', 'Jahitan Lepas', 'Apakah ada jahitan yang terlepas atau longgar?', 'Benang jahitan putus atau kendor', '1'),

-- Gejala Busa/Padding
(5, 'G-005', 'Busa Kempes', 'Apakah busa terasa kempes atau tidak empuk lagi?', 'Busa kehilangan elastisitas dan kenyamanan', '1'),
(6, 'G-006', 'Dudukan Tidak Rata', 'Apakah permukaan dudukan tidak rata atau cekung?', 'Permukaan tidak seimbang saat diduduki', '1'),
(7, 'G-007', 'Busa Keras', 'Apakah busa terasa keras atau kaku?', 'Busa mengeras karena usia atau kelembaban', '1'),
(8, 'G-008', 'Bau Tidak Sedap', 'Apakah ada bau tidak sedap dari busa?', 'Bau apek atau jamur pada busa', '1'),

-- Gejala Rangka & Struktur
(9, 'G-009', 'Bunyi Berderit', 'Apakah furniture mengeluarkan bunyi berderit saat digunakan?', 'Suara derit dari sambungan atau rangka', '1'),
(10, 'G-010', 'Goyang/Tidak Stabil', 'Apakah furniture goyang atau tidak stabil?', 'Struktur tidak kokoh saat digunakan', '1'),
(11, 'G-011', 'Kayu Retak', 'Apakah ada bagian kayu yang retak atau patah?', 'Keretakan pada rangka kayu', '1'),
(12, 'G-012', 'Baut Kendor', 'Apakah ada baut atau sekrup yang kendor?', 'Pengencang tidak kencang', '1'),

-- Gejala Mekanisme
(13, 'G-013', 'Per/Spring Bunyi', 'Apakah per atau spring mengeluarkan bunyi?', 'Bunyi cuit-cuit dari sistem per', '1'),
(14, 'G-014', 'Gas Lift Turun', 'Apakah kursi turun sendiri saat diduduki?', 'Sistem hydraulic tidak berfungsi', '1'),
(15, 'G-015', 'Roda Macet', 'Apakah roda kursi macet atau tidak lancar?', 'Roda tidak berputar dengan baik', '1'),
(16, 'G-016', 'Sandaran Lepas', 'Apakah sandaran lepas atau tidak terkunci?', 'Mekanisme penguncian rusak', '1'),

-- Gejala Kasur
(17, 'G-017', 'Kasur Melendut', 'Apakah kasur melendut di tengah?', 'Permukaan kasur tidak rata, cekung di tengah', '1'),
(18, 'G-018', 'Per Menonjol', 'Apakah ada per yang menonjol keluar?', 'Per spring bed keluar dari lapisan', '1'),
(19, 'G-019', 'Kasur Bocor', 'Apakah kasur angin/air bocor?', 'Kebocoran pada kasur pneumatik', '1'),

-- Gejala Kayu
(20, 'G-020', 'Cat Mengelupas', 'Apakah cat furniture mengelupas?', 'Lapisan cat terkelupas atau retak', '1'),
(21, 'G-021', 'Ada Rayap', 'Apakah ada tanda-tanda rayap?', 'Lubang kecil atau serbuk kayu di sekitar furniture', '1'),
(22, 'G-022', 'Kayu Lapuk', 'Apakah kayu terlihat lapuk atau keropos?', 'Kayu membusuk karena kelembaban', '1');

-- 4. JENIS KERUSAKAN (Detail dengan Pertanyaan)
INSERT INTO `jenis_kerusakan` (`id`, `kode_kerusakan`, `nama_jenis_kerusakan`, `pertanyaan`, `detail_kerusakan`, `tingkat_kerusakan`, `status`) VALUES
-- Kerusakan Pelapis
(1, 'K-001', 'Sobek Besar', 'Apakah robekan berukuran lebih dari 10cm?', 'Robekan besar pada pelapis yang memerlukan penggantian', 'Berat', '1'),
(2, 'K-002', 'Sobek Kecil', 'Apakah robekan berukuran kurang dari 10cm?', 'Robekan kecil yang bisa dijahit/ditambal', 'Ringan', '1'),
(3, 'K-003', 'Aus Parah', 'Apakah pelapis aus hingga menipis?', 'Pelapis menipis dan tidak nyaman', 'Sedang', '1'),
(4, 'K-004', 'Jahitan Rusak', 'Apakah banyak jahitan yang lepas?', 'Jahitan putus di beberapa tempat', 'Sedang', '1'),

-- Kerusakan Busa
(5, 'K-005', 'Busa Kempes Total', 'Apakah busa sudah tidak empuk sama sekali?', 'Busa kehilangan >70% elastisitas', 'Berat', '1'),
(6, 'K-006', 'Busa Tidak Rata', 'Apakah permukaan busa tidak merata?', 'Busa mencekung di beberapa bagian', 'Sedang', '1'),
(7, 'K-007', 'Busa Berjamur', 'Apakah busa berbau dan berjamur?', 'Kontaminasi jamur pada busa', 'Berat', '1'),

-- Kerusakan Rangka
(8, 'K-008', 'Rangka Patah', 'Apakah rangka kayu/besi patah?', 'Kerusakan struktural yang serius', 'Berat', '1'),
(9, 'K-009', 'Sambungan Lepas', 'Apakah sambungan furniture lepas?', 'Konstruksi tidak terhubung dengan baik', 'Sedang', '1'),
(10, 'K-010', 'Kayu Keropos', 'Apakah kayu keropos atau rapuh?', 'Kayu rusak karena rayap/kelembaban', 'Berat', '1'),

-- Kerusakan Mekanisme
(11, 'K-011', 'Per Rusak', 'Apakah per/spring patah atau kendor?', 'Sistem per tidak berfungsi optimal', 'Sedang', '1'),
(12, 'K-012', 'Gas Lift Mati', 'Apakah gas lift tidak berfungsi sama sekali?', 'Sistem pneumatik rusak total', 'Berat', '1'),
(13, 'K-013', 'Roda Rusak', 'Apakah roda patah atau aus?', 'Roda tidak bisa berputar', 'Ringan', '1'),
(14, 'K-014', 'Tilt Macet', 'Apakah mekanisme sandaran macet?', 'Sistem tilt tidak berfungsi', 'Sedang', '1'),

-- Kerusakan Finishing
(15, 'K-015', 'Cat Rusak Total', 'Apakah cat sudah rusak di seluruh permukaan?', 'Finishing cat harus diganti total', 'Sedang', '1'),
(16, 'K-016', 'Gores Dalam', 'Apakah ada goresan dalam hingga kayu?', 'Goresan menembus lapisan finishing', 'Ringan', '1');

-- 5. RELASI GEJALA - JENIS PERBAIKAN
INSERT INTO `relasi_gejala_jenis_perbaikan` (`id_jenis_perbaikan`, `id_gejala_kerusakan`, `bobot_kepentingan`) VALUES
-- Ganti Kulit/Kain Sofa
(1, 1, 0.9), (1, 2, 0.8), (1, 3, 0.7), (1, 4, 0.6),
-- Perbaikan Busa Sofa
(2, 5, 0.9), (2, 6, 0.8), (2, 7, 0.7), (2, 8, 0.6),
-- Perbaikan Rangka Sofa
(3, 9, 0.9), (3, 10, 0.9), (3, 11, 0.8), (3, 12, 0.7),
-- Service Per Sofa
(4, 13, 0.9), (4, 6, 0.7),
-- Ganti Jok Kursi Kantor
(5, 1, 0.9), (5, 5, 0.8), (5, 3, 0.6),
-- Perbaikan Gas Lift
(6, 14, 0.9),
-- Ganti Roda Kursi
(7, 15, 0.9),
-- Perbaikan Sandaran
(8, 16, 0.9), (8, 9, 0.6),
-- Ganti Per Spring Bed
(9, 17, 0.9), (9, 18, 0.9), (9, 13, 0.8),
-- Tambal Kasur Angin
(10, 19, 0.9),
-- Ganti Busa Kasur
(11, 5, 0.9), (11, 6, 0.8), (11, 17, 0.7),
-- Perbaikan Rangka Kasur
(12, 10, 0.9), (12, 9, 0.8),
-- Ganti Kulit Jok Mobil
(13, 1, 0.9), (13, 2, 0.8), (13, 3, 0.7),
-- Perbaikan Busa Jok Motor
(14, 5, 0.9), (14, 6, 0.8),
-- Custom Jok Racing
(15, 5, 0.6), (15, 1, 0.5),
-- Repair Sobek Jok
(16, 1, 0.9), (16, 4, 0.7),
-- Refinishing Kayu
(17, 20, 0.9), (17, 2, 0.7),
-- Perbaikan Sambungan
(18, 10, 0.9), (18, 9, 0.8), (18, 12, 0.7),
-- Anti Rayap Treatment
(19, 21, 0.9), (19, 22, 0.8),
-- Cat Ulang Furniture
(20, 20, 0.9), (20, 2, 0.6);

-- 6. RELASI JENIS KERUSAKAN - GEJALA
INSERT INTO `relasi_jenis_kerusakan_gejala` (`id_jenis_kerusakan`, `id_gejala_kerusakan`, `bobot_hubungan`) VALUES
-- Sobek Besar
(1, 1, 0.9), (1, 4, 0.7),
-- Sobek Kecil
(2, 1, 0.8),
-- Aus Parah
(3, 2, 0.9), (3, 3, 0.6),
-- Jahitan Rusak
(4, 4, 0.9), (4, 1, 0.5),
-- Busa Kempes Total
(5, 5, 0.9), (5, 6, 0.8), (5, 7, 0.6),
-- Busa Tidak Rata
(6, 6, 0.9), (6, 5, 0.7),
-- Busa Berjamur
(7, 8, 0.9), (7, 5, 0.7),
-- Rangka Patah
(8, 10, 0.9), (8, 11, 0.8), (8, 9, 0.7),
-- Sambungan Lepas
(9, 10, 0.8), (9, 9, 0.9), (9, 12, 0.7),
-- Kayu Keropos
(10, 21, 0.9), (10, 22, 0.8), (10, 10, 0.7),
-- Per Rusak
(11, 13, 0.9), (11, 6, 0.7), (11, 17, 0.6),
-- Gas Lift Mati
(12, 14, 0.9),
-- Roda Rusak
(13, 15, 0.9),
-- Tilt Macet
(14, 16, 0.9), (14, 9, 0.6),
-- Cat Rusak Total
(15, 20, 0.9), (15, 2, 0.7),
-- Gores Dalam
(16, 20, 0.7);

-- 7. REKOMENDASI PERBAIKAN (Lengkap dengan CF Expert)
INSERT INTO `rekomendasi_perbaikan` (`id`, `kode_rekomendasi`, `nama_rekomendasi`, `deskripsi_rekomendasi`, `solusi_perbaikan`, `biaya_estimasi`, `durasi_perbaikan`, `tingkat_kesulitan`, `mb_value`, `md_value`, `cf_value`, `prioritas`, `status`) VALUES
-- Perbaikan Pelapis
(1, 'R-001', 'Ganti Pelapis Total', 'Penggantian seluruh pelapis dengan material baru berkualitas', 'Lepas pelapis lama, ganti busa jika perlu, pasang pelapis baru dengan jahitan rapi', 1500000, 3, 'Sedang', 0.85, 0.10, 0.75, 1, '1'),
(2, 'R-002', 'Tambal/Jahit Pelapis', 'Perbaikan robekan kecil dengan jahitan profesional', 'Jahit robekan dengan benang kuat, tambahkan patch jika perlu', 250000, 1, 'Mudah', 0.70, 0.15, 0.55, 2, '1'),
(3, 'R-003', 'Ganti Pelapis Parsial', 'Penggantian pelapis pada bagian tertentu yang rusak', 'Ganti pelapis pada bagian dudukan atau sandaran saja', 800000, 2, 'Sedang', 0.75, 0.12, 0.63, 2, '1'),

-- Perbaikan Busa
(4, 'R-004', 'Ganti Busa Berkualitas', 'Penggantian busa dengan density tinggi untuk kenyamanan maksimal', 'Lepas pelapis, ganti busa dengan ukuran dan kepadatan sesuai, pasang kembali pelapis', 900000, 2, 'Sedang', 0.80, 0.10, 0.70, 1, '1'),
(5, 'R-005', 'Tambah Padding Ekstra', 'Penambahan lapisan busa untuk kenyamanan lebih', 'Tambahkan layer busa tipis di atas busa lama', 400000, 1, 'Mudah', 0.65, 0.20, 0.45, 3, '1'),
(6, 'R-006', 'Ganti Busa Ekonomis', 'Penggantian busa dengan material standar', 'Ganti busa dengan kualitas standar terjangkau', 500000, 2, 'Sedang', 0.70, 0.15, 0.55, 2, '1'),

-- Perbaikan Rangka
(7, 'R-007', 'Perbaikan Rangka Profesional', 'Penguatan dan perbaikan rangka dengan teknik professional', 'Perkuat sambungan, tambah bracket, lem kayu khusus, finishing ulang', 1200000, 4, 'Sulit', 0.85, 0.08, 0.77, 1, '1'),
(8, 'R-008', 'Penguatan Sambungan', 'Penguatan titik sambungan yang lemah', 'Kencangkan baut, tambah penguat L-bracket, lem konstruksi', 600000, 2, 'Sedang', 0.75, 0.12, 0.63, 2, '1'),

-- Perbaikan Mekanisme
(9, 'R-009', 'Ganti Gas Lift Ori', 'Penggantian gas lift dengan part original', 'Lepas gas lift lama, pasang unit baru dengan spesifikasi sama', 350000, 1, 'Mudah', 0.90, 0.05, 0.85, 1, '1'),
(10, 'R-010', 'Service Per/Spring', 'Perbaikan sistem per yang bunyi atau kendor', 'Ganti per rusak, pelumasan, penguatan sistem per', 700000, 3, 'Sedang', 0.80, 0.10, 0.70, 1, '1'),
(11, 'R-011', 'Ganti Roda Premium', 'Penggantian roda dengan kualitas premium', 'Ganti semua roda dengan castor berkualitas tinggi', 200000, 1, 'Mudah', 0.85, 0.10, 0.75, 2, '1'),

-- Perbaikan Finishing
(12, 'R-012', 'Refinishing Total', 'Pengamplasan dan finishing ulang keseluruhan', 'Amplas, wood filler untuk goresan, stain, top coat sealer', 1000000, 5, 'Sedang', 0.80, 0.12, 0.68, 1, '1'),
(13, 'R-013', 'Touch Up Cat', 'Perbaikan cat pada area tertentu', 'Cat ulang bagian rusak saja dengan matching color', 300000, 1, 'Mudah', 0.60, 0.20, 0.40, 3, '1'),
(14, 'R-014', 'Treatment Anti Rayap', 'Aplikasi anti rayap dan pengawet kayu', 'Injeksi anti rayap, coating pengawet, fumigasi jika perlu', 800000, 2, 'Sedang', 0.85, 0.08, 0.77, 1, '1'),

-- Perbaikan Custom
(15, 'R-015', 'Custom Design Ulang', 'Modifikasi design furniture sesuai keinginan', 'Konsultasi design, modifikasi bentuk, ganti material premium', 2500000, 7, 'Sulit', 0.75, 0.15, 0.60, 2, '1'),
(16, 'R-016', 'Konversi Elektrik', 'Tambahkan fitur elektrik (recliner, massage, USB)', 'Instalasi motor elektrik, remote control, wiring', 3000000, 5, 'Sulit', 0.70, 0.18, 0.52, 3, '1');

-- 8. RELASI REKOMENDASI - JENIS KERUSAKAN
INSERT INTO `relasi_rekomendasi_jenis_kerusakan` (`id_rekomendasi_perbaikan`, `id_jenis_kerusakan`, `tingkat_kesesuaian`) VALUES
-- Ganti Pelapis Total
(1, 1, 0.95), (1, 3, 0.90), (1, 4, 0.85),
-- Tambal/Jahit Pelapis
(2, 2, 0.90), (2, 4, 0.80),
-- Ganti Pelapis Parsial
(3, 1, 0.80), (3, 3, 0.75),
-- Ganti Busa Berkualitas
(4, 5, 0.95), (4, 6, 0.90), (4, 7, 0.85),
-- Tambah Padding Ekstra
(5, 6, 0.80), (5, 5, 0.70),
-- Ganti Busa Ekonomis
(6, 5, 0.85), (6, 6, 0.80),
-- Perbaikan Rangka Profesional
(7, 8, 0.95), (7, 9, 0.90), (7, 10, 0.85),
-- Penguatan Sambungan
(8, 9, 0.90), (8, 8, 0.75),
-- Ganti Gas Lift Ori
(9, 12, 0.95),
-- Service Per/Spring
(10, 11, 0.95),
-- Ganti Roda Premium
(11, 13, 0.95),
-- Refinishing Total
(12, 15, 0.95), (12, 16, 0.85),
-- Touch Up Cat
(13, 16, 0.85), (13, 15, 0.70),
-- Treatment Anti Rayap
(14, 10, 0.95),
-- Custom Design Ulang
(15, 1, 0.70), (15, 5, 0.70), (15, 8, 0.75),
-- Konversi Elektrik
(16, 5, 0.60), (16, 11, 0.60);

COMMIT;
