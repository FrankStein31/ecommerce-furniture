-- ============================================
-- RESET & INSERT COMPLETE EXPERT SYSTEM DATA
-- Sistem Pakar Rekomendasi Perbaikan Furniture
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;

-- Hapus data lama
TRUNCATE TABLE `relasi_rekomendasi_jenis_kerusakan`;
TRUNCATE TABLE `relasi_jenis_kerusakan_gejala`;
TRUNCATE TABLE `relasi_gejala_jenis_perbaikan`;
TRUNCATE TABLE `rekomendasi_perbaikan`;
TRUNCATE TABLE `jenis_kerusakan`;
TRUNCATE TABLE `gejala_kerusakan`;
TRUNCATE TABLE `jenis_perbaikan`;
TRUNCATE TABLE `kategori_jenis_perbaikan`;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. KATEGORI JENIS PERBAIKAN (Lengkap)
INSERT INTO `kategori_jenis_perbaikan` (`id`, `nama_kategori`, `deskripsi`, `icon`, `urutan`, `status`) VALUES
(1, 'Sofa & Kursi Tamu', 'Perbaikan untuk sofa, kursi tamu, dan furniture ruang tamu', 'fa-couch', 1, '1'),
(2, 'Kursi Kantor', 'Perbaikan kursi kantor, gaming, dan ergonomis', 'fa-chair', 2, '1'),
(3, 'Kasur & Spring Bed', 'Perbaikan kasur, spring bed, dan furniture kamar tidur', 'fa-bed', 3, '1'),
(4, 'Jok Mobil & Motor', 'Perbaikan jok kendaraan bermotor', 'fa-car', 4, '1'),
(5, 'Furniture Kayu', 'Perbaikan furniture berbahan kayu', 'fa-tree', 5, '1');

-- 2. JENIS PERBAIKAN (Per Kategori)
INSERT INTO `jenis_perbaikan` (`id`, `id_kategori`, `nama_jenis_perbaikan`, `deskripsi`, `urutan`, `status`) VALUES
-- Sofa & Kursi Tamu
(1, 1, 'Ganti Kulit/Kain Sofa', 'Penggantian pelapis sofa dengan bahan kulit atau kain baru. Cocok untuk sofa yang kulitnya sobek, aus, atau warna sudah pudar', 1, '1'),
(2, 1, 'Perbaikan Busa Sofa', 'Penggantian atau perbaikan busa sofa yang kempes/rusak. Mengembalikan kenyamanan duduk seperti baru', 2, '1'),
(3, 1, 'Perbaikan Rangka Sofa', 'Perbaikan atau penguatan rangka kayu/besi sofa yang goyang atau bunyi berderit', 3, '1'),
(4, 1, 'Service Per Sofa', 'Perbaikan sistem per/pegas sofa yang kendor atau bunyi. Membuat dudukan kembali empuk dan nyaman', 4, '1'),

-- Kursi Kantor
(5, 2, 'Ganti Jok Kursi Kantor', 'Penggantian jok/busa kursi kantor yang sudah kempes atau tidak nyaman. Tersedia pilihan busa berkualitas', 5, '1'),
(6, 2, 'Perbaikan Gas Lift', 'Perbaikan sistem hydraulic/gas lift kursi yang turun sendiri. Ganti dengan gas lift original', 6, '1'),
(7, 2, 'Ganti Roda Kursi', 'Penggantian roda/caster kursi kantor yang macet atau aus. Tersedia roda premium yang halus dan kuat', 7, '1'),
(8, 2, 'Perbaikan Sandaran', 'Perbaikan mekanisme sandaran dan tilt kursi yang lepas atau macet', 8, '1'),

-- Kasur & Spring Bed
(9, 3, 'Ganti Per Spring Bed', 'Penggantian sistem per/spring kasur yang melendut atau per menonjol. Kembalikan kualitas tidur Anda', 9, '1'),
(10, 3, 'Tambal Kasur Angin', 'Perbaikan kebocoran kasur angin/air bed dengan metode vulkanisir profesional', 10, '1'),
(11, 3, 'Ganti Busa Kasur', 'Penggantian busa kasur yang kempes dengan busa berkualitas tinggi. Tidur nyenyak kembali', 11, '1'),
(12, 3, 'Perbaikan Rangka Kasur', 'Perbaikan rangka/divan spring bed yang goyang atau bunyi. Penguatan struktur untuk keawetan', 12, '1'),

-- Jok Mobil & Motor
(13, 4, 'Ganti Kulit Jok Mobil', 'Penggantian pelapis jok mobil dengan kulit/MBTech berkualitas. Tersedia banyak pilihan warna', 13, '1'),
(14, 4, 'Perbaikan Busa Jok Motor', 'Penggantian busa jok motor yang kempes. Bikin perjalanan jauh jadi nyaman lagi', 14, '1'),
(15, 4, 'Custom Jok Racing', 'Custom jok dengan model racing/sport untuk tampilan lebih sporty dan nyaman', 15, '1'),
(16, 4, 'Repair Sobek Jok', 'Perbaikan robekan pada jok kendaraan dengan jahitan rapi dan kuat', 16, '1'),

-- Furniture Kayu
(17, 5, 'Refinishing Kayu', 'Pengamplasan dan finishing ulang furniture kayu. Tampil seperti baru dengan finishing glossy/matte', 17, '1'),
(18, 5, 'Perbaikan Sambungan', 'Perbaikan sambungan/konstruksi furniture kayu yang goyang. Penguatan dengan teknik profesional', 18, '1'),
(19, 5, 'Anti Rayap Treatment', 'Treatment anti rayap dan penguat kayu untuk mencegah kerusakan lebih lanjut', 19, '1'),
(20, 5, 'Cat Ulang Furniture', 'Pengecatan ulang furniture kayu dengan cat berkualitas. Pilih warna sesuai selera Anda', 20, '1');

-- 3. GEJALA KERUSAKAN (Lengkap dengan Pertanyaan)
INSERT INTO `gejala_kerusakan` (`id`, `kode_gejala`, `nama_gejala`, `pertanyaan`, `deskripsi_gejala`, `urutan`, `status`) VALUES
-- Gejala Umum Pelapis
(1, 'G-001', 'Kain/Kulit Sobek', 'Apakah pelapis furniture Anda robek atau sobek?', 'Robekan pada kain, kulit, atau bahan pelapis', 1, '1'),
(2, 'G-002', 'Warna Pudar', 'Apakah warna pelapis sudah pudar atau kusam?', 'Perubahan warna akibat sinar UV atau usia', 2, '1'),
(3, 'G-003', 'Noda Membandel', 'Apakah ada noda yang sulit dibersihkan?', 'Noda permanen dari makanan, minuman, atau tinta', 3, '1'),
(4, 'G-004', 'Jahitan Lepas', 'Apakah ada jahitan yang terlepas atau longgar?', 'Benang jahitan putus atau kendor', 4, '1'),

-- Gejala Busa/Padding
(5, 'G-005', 'Busa Kempes', 'Apakah busa terasa kempes atau tidak empuk lagi?', 'Busa kehilangan elastisitas dan kenyamanan', 5, '1'),
(6, 'G-006', 'Dudukan Tidak Rata', 'Apakah permukaan dudukan tidak rata atau cekung?', 'Permukaan tidak seimbang saat diduduki', 6, '1'),
(7, 'G-007', 'Busa Keras', 'Apakah busa terasa keras atau kaku?', 'Busa mengeras karena usia atau kelembaban', 7, '1'),
(8, 'G-008', 'Bau Tidak Sedap', 'Apakah ada bau tidak sedap dari busa?', 'Bau apek atau jamur pada busa', 8, '1'),

-- Gejala Rangka & Struktur
(9, 'G-009', 'Bunyi Berderit', 'Apakah furniture mengeluarkan bunyi berderit saat digunakan?', 'Suara derit dari sambungan atau rangka', 9, '1'),
(10, 'G-010', 'Goyang/Tidak Stabil', 'Apakah furniture goyang atau tidak stabil?', 'Struktur tidak kokoh saat digunakan', 10, '1'),
(11, 'G-011', 'Kayu Retak', 'Apakah ada bagian kayu yang retak atau patah?', 'Keretakan pada rangka kayu', 11, '1'),
(12, 'G-012', 'Baut Kendor', 'Apakah ada baut atau sekrup yang kendor?', 'Pengencang tidak kencang', 12, '1'),

-- Gejala Mekanisme
(13, 'G-013', 'Per/Spring Bunyi', 'Apakah per atau spring mengeluarkan bunyi?', 'Bunyi cuit-cuit dari sistem per', 13, '1'),
(14, 'G-014', 'Gas Lift Turun', 'Apakah kursi turun sendiri saat diduduki?', 'Sistem hydraulic tidak berfungsi', 14, '1'),
(15, 'G-015', 'Roda Macet', 'Apakah roda kursi macet atau tidak lancar?', 'Roda tidak berputar dengan baik', 15, '1'),
(16, 'G-016', 'Sandaran Lepas', 'Apakah sandaran lepas atau tidak terkunci?', 'Mekanisme penguncian rusak', 16, '1'),

-- Gejala Kasur
(17, 'G-017', 'Kasur Melendut', 'Apakah kasur melendut di tengah?', 'Permukaan kasur tidak rata, cekung di tengah', 17, '1'),
(18, 'G-018', 'Per Menonjol', 'Apakah ada per yang menonjol keluar?', 'Per spring bed keluar dari lapisan', 18, '1'),
(19, 'G-019', 'Kasur Bocor', 'Apakah kasur angin/air bocor?', 'Kebocoran pada kasur pneumatik', 19, '1'),

-- Gejala Kayu
(20, 'G-020', 'Cat Mengelupas', 'Apakah cat furniture mengelupas?', 'Lapisan cat terkelupas atau retak', 20, '1'),
(21, 'G-021', 'Ada Rayap', 'Apakah ada tanda-tanda rayap?', 'Lubang kecil atau serbuk kayu di sekitar furniture', 21, '1'),
(22, 'G-022', 'Kayu Lapuk', 'Apakah kayu terlihat lapuk atau keropos?', 'Kayu membusuk karena kelembaban', 22, '1');

-- 4. JENIS KERUSAKAN (Detail dengan Pertanyaan)
INSERT INTO `jenis_kerusakan` (`id`, `kode_kerusakan`, `nama_jenis_kerusakan`, `pertanyaan`, `detail_kerusakan`, `tingkat_kerusakan`, `urutan`, `status`) VALUES
-- Kerusakan Pelapis
(1, 'K-001', 'Sobek Besar', 'Apakah robekan berukuran lebih dari 10cm?', 'Robekan besar pada pelapis yang memerlukan penggantian', 'berat', 1, '1'),
(2, 'K-002', 'Sobek Kecil', 'Apakah robekan berukuran kurang dari 10cm?', 'Robekan kecil yang bisa dijahit/ditambal', 'ringan', 2, '1'),
(3, 'K-003', 'Aus Parah', 'Apakah pelapis aus hingga menipis?', 'Pelapis menipis dan tidak nyaman', 'sedang', 3, '1'),
(4, 'K-004', 'Jahitan Rusak', 'Apakah banyak jahitan yang lepas?', 'Jahitan putus di beberapa tempat', 'sedang', 4, '1'),

-- Kerusakan Busa
(5, 'K-005', 'Busa Kempes Total', 'Apakah busa sudah tidak empuk sama sekali?', 'Busa kehilangan >70% elastisitas', 'berat', 5, '1'),
(6, 'K-006', 'Busa Tidak Rata', 'Apakah permukaan busa tidak merata?', 'Busa mencekung di beberapa bagian', 'sedang', 6, '1'),
(7, 'K-007', 'Busa Berjamur', 'Apakah busa berbau dan berjamur?', 'Kontaminasi jamur pada busa', 'berat', 7, '1'),

-- Kerusakan Rangka
(8, 'K-008', 'Rangka Patah', 'Apakah rangka kayu/besi patah?', 'Kerusakan struktural yang serius', 'berat', 8, '1'),
(9, 'K-009', 'Sambungan Lepas', 'Apakah sambungan furniture lepas?', 'Konstruksi tidak terhubung dengan baik', 'sedang', 9, '1'),
(10, 'K-010', 'Kayu Keropos', 'Apakah kayu keropos atau rapuh?', 'Kayu rusak karena rayap/kelembaban', 'berat', 10, '1'),

-- Kerusakan Mekanisme
(11, 'K-011', 'Per Rusak', 'Apakah per/spring patah atau kendor?', 'Sistem per tidak berfungsi optimal', 'sedang', 11, '1'),
(12, 'K-012', 'Gas Lift Mati', 'Apakah gas lift tidak berfungsi sama sekali?', 'Sistem pneumatik rusak total', 'berat', 12, '1'),
(13, 'K-013', 'Roda Rusak', 'Apakah roda patah atau aus?', 'Roda tidak bisa berputar', 'ringan', 13, '1'),
(14, 'K-014', 'Tilt Macet', 'Apakah mekanisme sandaran macet?', 'Sistem tilt tidak berfungsi', 'sedang', 14, '1'),

-- Kerusakan Finishing
(15, 'K-015', 'Cat Rusak Total', 'Apakah cat sudah rusak di seluruh permukaan?', 'Finishing cat harus diganti total', 'sedang', 15, '1'),
(16, 'K-016', 'Gores Dalam', 'Apakah ada goresan dalam hingga kayu?', 'Goresan menembus lapisan finishing', 'ringan', 16, '1');

-- 5. RELASI GEJALA - JENIS PERBAIKAN
INSERT INTO `relasi_gejala_jenis_perbaikan` (`id_jenis_perbaikan`, `id_gejala_kerusakan`) VALUES
-- Ganti Kulit/Kain Sofa (JP-1)
(1, 1), (1, 2), (1, 3), (1, 4),
-- Perbaikan Busa Sofa (JP-2)
(2, 5), (2, 6), (2, 7), (2, 8),
-- Perbaikan Rangka Sofa (JP-3)
(3, 9), (3, 10), (3, 11), (3, 12),
-- Service Per Sofa (JP-4)
(4, 13), (4, 6),
-- Ganti Jok Kursi Kantor (JP-5)
(5, 1), (5, 5), (5, 3),
-- Perbaikan Gas Lift (JP-6)
(6, 14),
-- Ganti Roda Kursi (JP-7)
(7, 15),
-- Perbaikan Sandaran (JP-8)
(8, 16), (8, 9),
-- Ganti Per Spring Bed (JP-9)
(9, 17), (9, 18), (9, 13),
-- Tambal Kasur Angin (JP-10)
(10, 19),
-- Ganti Busa Kasur (JP-11)
(11, 5), (11, 6), (11, 17),
-- Perbaikan Rangka Kasur (JP-12)
(12, 10), (12, 9),
-- Ganti Kulit Jok Mobil (JP-13)
(13, 1), (13, 2), (13, 3),
-- Perbaikan Busa Jok Motor (JP-14)
(14, 5), (14, 6),
-- Custom Jok Racing (JP-15)
(15, 5), (15, 1),
-- Repair Sobek Jok (JP-16)
(16, 1), (16, 4),
-- Refinishing Kayu (JP-17)
(17, 20), (17, 2),
-- Perbaikan Sambungan (JP-18)
(18, 10), (18, 9), (18, 12),
-- Anti Rayap Treatment (JP-19)
(19, 21), (19, 22),
-- Cat Ulang Furniture (JP-20)
(20, 20), (20, 2);

-- 6. RELASI JENIS KERUSAKAN - GEJALA
INSERT INTO `relasi_jenis_kerusakan_gejala` (`id_jenis_kerusakan`, `id_gejala_kerusakan`) VALUES
-- Sobek Besar (K-001)
(1, 1), (1, 4),
-- Sobek Kecil (K-002)
(2, 1),
-- Aus Parah (K-003)
(3, 2), (3, 3),
-- Jahitan Rusak (K-004)
(4, 4), (4, 1),
-- Busa Kempes Total (K-005)
(5, 5), (5, 6), (5, 7),
-- Busa Tidak Rata (K-006)
(6, 6), (6, 5),
-- Busa Berjamur (K-007)
(7, 8), (7, 5),
-- Rangka Patah (K-008)
(8, 10), (8, 11), (8, 9),
-- Sambungan Lepas (K-009)
(9, 10), (9, 9), (9, 12),
-- Kayu Keropos (K-010)
(10, 21), (10, 22), (10, 10),
-- Per Rusak (K-011)
(11, 13), (11, 6), (11, 17),
-- Gas Lift Mati (K-012)
(12, 14),
-- Roda Rusak (K-013)
(13, 15),
-- Tilt Macet (K-014)
(14, 16), (14, 9),
-- Cat Rusak Total (K-015)
(15, 20), (15, 2),
-- Gores Dalam (K-016)
(16, 20);

-- 7. REKOMENDASI PERBAIKAN (Lengkap dengan CF Expert)
INSERT INTO `rekomendasi_perbaikan` (`id`, `kode_rekomendasi`, `nama_rekomendasi`, `deskripsi_rekomendasi`, `solusi_perbaikan`, `estimasi_harga_min`, `estimasi_harga_max`, `estimasi_waktu`, `biaya_estimasi`, `durasi_perbaikan`, `tingkat_prioritas`, `mb_value`, `md_value`, `cf_value`, `urutan`, `status`) VALUES
-- Perbaikan Pelapis
(1, 'R-001', 'Ganti Pelapis Total', 'Penggantian seluruh pelapis dengan material baru berkualitas', 'Lepas pelapis lama, ganti busa jika perlu, pasang pelapis baru dengan jahitan rapi', 1200000, 2000000, '2-4 hari', 1500000, 3, 'tinggi', 0.85, 0.10, 0.75, 1, '1'),
(2, 'R-002', 'Tambal/Jahit Pelapis', 'Perbaikan robekan kecil dengan jahitan profesional', 'Jahit robekan dengan benang kuat, tambahkan patch jika perlu', 200000, 350000, '1-2 hari', 250000, 1, 'sedang', 0.70, 0.15, 0.55, 2, '1'),
(3, 'R-003', 'Ganti Pelapis Parsial', 'Penggantian pelapis pada bagian tertentu yang rusak', 'Ganti pelapis pada bagian dudukan atau sandaran saja', 600000, 1000000, '2-3 hari', 800000, 2, 'sedang', 0.75, 0.12, 0.63, 3, '1'),

-- Perbaikan Busa
(4, 'R-004', 'Ganti Busa Berkualitas', 'Penggantian busa dengan density tinggi untuk kenyamanan maksimal', 'Lepas pelapis, ganti busa dengan ukuran dan kepadatan sesuai, pasang kembali pelapis', 700000, 1200000, '2-3 hari', 900000, 2, 'tinggi', 0.80, 0.10, 0.70, 4, '1'),
(5, 'R-005', 'Tambah Padding Ekstra', 'Penambahan lapisan busa untuk kenyamanan lebih', 'Tambahkan layer busa tipis di atas busa lama', 300000, 500000, '1-2 hari', 400000, 1, 'sedang', 0.65, 0.20, 0.45, 5, '1'),
(6, 'R-006', 'Ganti Busa Ekonomis', 'Penggantian busa dengan material standar', 'Ganti busa dengan kualitas standar terjangkau', 400000, 700000, '1-3 hari', 500000, 2, 'sedang', 0.70, 0.15, 0.55, 6, '1'),

-- Perbaikan Rangka
(7, 'R-007', 'Perbaikan Rangka Profesional', 'Penguatan dan perbaikan rangka dengan teknik professional', 'Perkuat sambungan, tambah bracket, lem kayu khusus, finishing ulang', 900000, 1500000, '3-5 hari', 1200000, 4, 'tinggi', 0.85, 0.08, 0.77, 7, '1'),
(8, 'R-008', 'Penguatan Sambungan', 'Penguatan titik sambungan yang lemah', 'Kencangkan baut, tambah penguat L-bracket, lem konstruksi', 450000, 750000, '2-3 hari', 600000, 2, 'sedang', 0.75, 0.12, 0.63, 8, '1'),

-- Perbaikan Mekanisme
(9, 'R-009', 'Ganti Gas Lift Ori', 'Penggantian gas lift dengan part original', 'Lepas gas lift lama, pasang unit baru dengan spesifikasi sama', 250000, 450000, '1 hari', 350000, 1, 'tinggi', 0.90, 0.05, 0.85, 9, '1'),
(10, 'R-010', 'Service Per/Spring', 'Perbaikan sistem per yang bunyi atau kendor', 'Ganti per rusak, pelumasan, penguatan sistem per', 550000, 900000, '2-4 hari', 700000, 3, 'tinggi', 0.80, 0.10, 0.70, 10, '1'),
(11, 'R-011', 'Ganti Roda Premium', 'Penggantian roda dengan kualitas premium', 'Ganti semua roda dengan castor berkualitas tinggi', 150000, 300000, '1 hari', 200000, 1, 'sedang', 0.85, 0.10, 0.75, 11, '1'),

-- Perbaikan Finishing
(12, 'R-012', 'Refinishing Total', 'Pengamplasan dan finishing ulang keseluruhan', 'Amplas, wood filler untuk goresan, stain, top coat sealer', 800000, 1400000, '4-6 hari', 1000000, 5, 'tinggi', 0.80, 0.12, 0.68, 12, '1'),
(13, 'R-013', 'Touch Up Cat', 'Perbaikan cat pada area tertentu', 'Cat ulang bagian rusak saja dengan matching color', 200000, 400000, '1-2 hari', 300000, 1, 'rendah', 0.60, 0.20, 0.40, 13, '1'),
(14, 'R-014', 'Treatment Anti Rayap', 'Aplikasi anti rayap dan pengawet kayu', 'Injeksi anti rayap, coating pengawet, fumigasi jika perlu', 600000, 1000000, '2-3 hari', 800000, 2, 'tinggi', 0.85, 0.08, 0.77, 14, '1'),

-- Perbaikan Custom
(15, 'R-015', 'Custom Design Ulang', 'Modifikasi design furniture sesuai keinginan', 'Konsultasi design, modifikasi bentuk, ganti material premium', 2000000, 3500000, '5-10 hari', 2500000, 7, 'sedang', 0.75, 0.15, 0.60, 15, '1'),
(16, 'R-016', 'Konversi Elektrik', 'Tambahkan fitur elektrik (recliner, massage, USB)', 'Instalasi motor elektrik, remote control, wiring', 2500000, 4000000, '4-7 hari', 3000000, 5, 'rendah', 0.70, 0.18, 0.52, 16, '1');

-- 8. RELASI REKOMENDASI - JENIS KERUSAKAN
INSERT INTO `relasi_rekomendasi_jenis_kerusakan` (`id_rekomendasi_perbaikan`, `id_jenis_kerusakan`) VALUES
-- Ganti Pelapis Total (R-001)
(1, 1), (1, 3), (1, 4),
-- Tambal/Jahit Pelapis (R-002)
(2, 2), (2, 4),
-- Ganti Pelapis Parsial (R-003)
(3, 1), (3, 3),
-- Ganti Busa Berkualitas (R-004)
(4, 5), (4, 6), (4, 7),
-- Tambah Padding Ekstra (R-005)
(5, 6), (5, 5),
-- Ganti Busa Ekonomis (R-006)
(6, 5), (6, 6),
-- Perbaikan Rangka Profesional (R-007)
(7, 8), (7, 9), (7, 10),
-- Penguatan Sambungan (R-008)
(8, 9), (8, 8),
-- Ganti Gas Lift Ori (R-009)
(9, 12),
-- Service Per/Spring (R-010)
(10, 11),
-- Ganti Roda Premium (R-011)
(11, 13),
-- Refinishing Total (R-012)
(12, 15), (12, 16),
-- Touch Up Cat (R-013)
(13, 16), (13, 15),
-- Treatment Anti Rayap (R-014)
(14, 10),
-- Custom Design Ulang (R-015)
(15, 1), (15, 5), (15, 8),
-- Konversi Elektrik (R-016)
(16, 5), (16, 11);

COMMIT;
