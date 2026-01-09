/*
SQLyog Enterprise
MySQL - 8.0.30 : Database - ecommerce-furniture
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ecommerce-furniture` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `ecommerce-furniture`;

/*Table structure for table `app_config` */

CREATE TABLE `app_config` (
  `id` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_sistem` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tagline` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `instansi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `favicon` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `logo` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `child_logo` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email_instansi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pass_instansi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `url_root` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `jalan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kelurahan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kecamatan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kabupaten` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `provinsi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kode_pos` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `telp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `fax` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email_smtp` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password_email_smtp` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `app_config` */

insert  into `app_config`(`id`,`nama_sistem`,`tagline`,`instansi`,`status`,`favicon`,`logo`,`child_logo`,`email_instansi`,`pass_instansi`,`url_root`,`jalan`,`kelurahan`,`kecamatan`,`kabupaten`,`provinsi`,`kode_pos`,`telp`,`fax`,`email_smtp`,`password_email_smtp`) values 
('CONF1','Ecommerce Furniture','Mebel Anggita','PT. MEBEL ANGGITA JAYA','1','assets/images/logo--.png','assets/images/logo---.png','assets/images/logo--.png','priscadewi08@gmail.com','anggitajaya','https://www.anggitajaya.com','Jl. Niken Gandini No. 72','Singosaren','Jenangan','Ponorogo','Jawa Timur',' 63492','62 813 3426 4234',NULL,'e31190286@student.polije.ac.id','e31190286');

/*Table structure for table `cart` */

CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_produk` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `is_checkout` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_cart_m_produk` (`id_produk`) USING BTREE,
  KEY `FK_cart_users` (`id_user`) USING BTREE,
  CONSTRAINT `FK_cart_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `m_produk` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_cart_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `cart` */

insert  into `cart`(`id`,`id_user`,`id_produk`,`qty`,`is_checkout`,`created_at`,`updated_at`) values 
(18,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','5f43ed05-84d4-4758-afbc-2f11c466fb1c',1,1,'2022-05-30 08:52:24',NULL),
(19,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','98b0fc09-1913-433a-868b-37624e99cf24',1,1,'2022-05-30 08:52:33',NULL),
(20,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','5f43ed05-84d4-4758-afbc-2f11c466fb1c',2,1,'2022-05-30 13:29:59',NULL),
(21,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','98b0fc09-1913-433a-868b-37624e99cf24',1,1,'2022-05-30 13:30:20',NULL),
(22,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','5f43ed05-84d4-4758-afbc-2f11c466fb1c',2,1,'2022-05-30 13:46:03',NULL),
(23,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','98b0fc09-1913-433a-868b-37624e99cf24',1,1,'2022-05-30 13:46:13',NULL),
(24,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','5f43ed05-84d4-4758-afbc-2f11c466fb1c',2,1,'2022-05-30 13:59:35','2022-05-30 23:51:28'),
(25,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','8b1f200d-acf6-40a7-991b-cf3c9ae41e28',1,1,'2022-05-30 23:51:40',NULL),
(28,'da1b1f5f-2d3e-4bbb-9a3a-c4ae88809ac3','98b0fc09-1913-433a-868b-37624e99cf24',1,1,'2022-06-06 17:00:57',NULL),
(29,'958757ae-2bba-4216-bacc-3b5baf3ef85e','209bbac2-4def-43a7-a154-a36acdf7d977',1,1,'2022-06-08 13:22:25',NULL),
(30,'958757ae-2bba-4216-bacc-3b5baf3ef85e','98b0fc09-1913-433a-868b-37624e99cf24',1,1,'2022-06-08 13:22:43',NULL),
(31,'958757ae-2bba-4216-bacc-3b5baf3ef85e','76418ee8-c9ce-4ea2-ae6f-0cb65c837646',1,1,'2022-06-08 13:23:28',NULL),
(32,'5a99a97b-d44a-4c14-8cc9-c02c5fd18f38','76418ee8-c9ce-4ea2-ae6f-0cb65c837646',2,1,'2022-06-10 08:46:15',NULL),
(33,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','40d40c7a-1336-4967-80eb-0adbb21aa9b8',1,1,'2022-06-12 22:03:43',NULL),
(34,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','76b94c75-c434-4025-bdb2-144f19cd9548',1,1,'2022-06-13 21:12:44',NULL),
(35,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1,'2022-06-13 22:36:24',NULL),
(36,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1,'2022-06-14 04:48:32',NULL),
(37,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','fe2895f2-da0d-424d-821e-6e2e7cbd0631',2,1,'2022-06-14 09:18:48',NULL),
(38,'31d80e68-947e-4fa1-924f-150c73f086d1','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1,'2022-06-14 11:31:56',NULL),
(39,'31d80e68-947e-4fa1-924f-150c73f086d1','fe2895f2-da0d-424d-821e-6e2e7cbd0631',1,1,'2022-06-14 11:32:15',NULL),
(40,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','76b94c75-c434-4025-bdb2-144f19cd9548',1,1,'2022-06-18 12:40:30',NULL),
(41,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','76b94c75-c434-4025-bdb2-144f19cd9548',1,1,'2022-06-18 12:59:12',NULL),
(42,'a27a9d2a-3253-47f7-8622-c7d4a25a5684','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1,'2025-08-30 02:18:00',NULL);

/*Table structure for table `diagnosis_jawaban` */

CREATE TABLE `diagnosis_jawaban` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_diagnosis_session` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'FK ke diagnosis_session',
  `tipe_pertanyaan` enum('gejala','kerusakan') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipe pertanyaan',
  `id_gejala_kerusakan` int DEFAULT NULL COMMENT 'FK ke gejala_kerusakan (jika tipe=gejala)',
  `id_jenis_kerusakan` int DEFAULT NULL COMMENT 'FK ke jenis_kerusakan (jika tipe=kerusakan)',
  `jawaban` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jawaban pelanggan',
  `cf_user` decimal(3,2) DEFAULT NULL COMMENT 'Certainty Factor dari user (0.00 - 1.00)',
  `cf_user_text` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Text pilihan CF (Sangat Yakin, Yakin, dll)',
  `urutan_jawab` int DEFAULT '0' COMMENT 'Urutan jawaban',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_jawaban_session` (`id_diagnosis_session`) USING BTREE,
  KEY `fk_jawaban_gejala` (`id_gejala_kerusakan`) USING BTREE,
  KEY `fk_jawaban_kerusakan` (`id_jenis_kerusakan`) USING BTREE,
  KEY `idx_tipe` (`tipe_pertanyaan`) USING BTREE,
  KEY `idx_jawaban` (`jawaban`) USING BTREE,
  CONSTRAINT `fk_jawaban_gejala` FOREIGN KEY (`id_gejala_kerusakan`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_jawaban_kerusakan` FOREIGN KEY (`id_jenis_kerusakan`) REFERENCES `jenis_kerusakan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_jawaban_session` FOREIGN KEY (`id_diagnosis_session`) REFERENCES `diagnosis_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jawaban diagnosis pelanggan';

/*Data for the table `diagnosis_jawaban` */

/*Table structure for table `diagnosis_session` */

CREATE TABLE `diagnosis_session` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'UUID session',
  `id_user` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'FK ke users (jika login), NULL jika guest',
  `id_kategori` int NOT NULL COMMENT 'FK ke kategori_jenis_perbaikan',
  `id_jenis_perbaikan` int NOT NULL COMMENT 'FK ke jenis_perbaikan',
  `nama_pelanggan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nama (untuk guest)',
  `email_pelanggan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Email (untuk guest)',
  `no_telp_pelanggan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'No Telp (untuk guest)',
  `status_diagnosis` enum('in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'in_progress',
  `hasil_rekomendasi_id` int DEFAULT NULL COMMENT 'FK ke rekomendasi_perbaikan (hasil akhir)',
  `cf_total` decimal(5,4) DEFAULT NULL COMMENT 'Total CF dari perhitungan',
  `metode_terpilih` enum('forward_chaining','certainty_factor','decision_tree') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Metode yang digunakan',
  `detail_perhitungan` text COLLATE utf8mb4_unicode_ci COMMENT 'JSON detail perhitungan FC & CF',
  `ip_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
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
  CONSTRAINT `fk_diagnosis_jenis_perbaikan` FOREIGN KEY (`id_jenis_perbaikan`) REFERENCES `jenis_perbaikan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_diagnosis_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_jenis_perbaikan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_diagnosis_rekomendasi` FOREIGN KEY (`hasil_rekomendasi_id`) REFERENCES `rekomendasi_perbaikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_diagnosis_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sesi diagnosis pelanggan';

/*Data for the table `diagnosis_session` */

/*Table structure for table `gejala_kerusakan` */

CREATE TABLE `gejala_kerusakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_gejala` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kode unik gejala (G001, G002, ...)',
  `nama_gejala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama gejala singkat',
  `deskripsi_gejala` text COLLATE utf8mb4_unicode_ci COMMENT 'Penjelasan detail gejala',
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pertanyaan untuk pelanggan',
  `urutan` int DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_kode_gejala` (`kode_gejala`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master data gejala kerusakan';

/*Data for the table `gejala_kerusakan` */

insert  into `gejala_kerusakan`(`id`,`kode_gejala`,`nama_gejala`,`deskripsi_gejala`,`pertanyaan`,`urutan`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'G01','Rembes','Kerusakan pada permukaan jok tanpa mempengaruhi struktur','Apakah furniture Anda mengalami rembes?',1,'1','2026-01-09 20:45:22',NULL,NULL),
(2,'G02','Kurang nyaman diduduki','Dudukan terasa tidak empuk, miring, atau tidak stabil','Apakah furniture Anda mengalami kurang nyaman diduduki?',2,'1','2026-01-09 20:45:22',NULL,NULL),
(3,'G03','Amblas ketika diduduki','Dudukan turun drastis saat diduduki','Apakah furniture Anda mengalami amblas ketika diduduki?',3,'1','2026-01-09 20:45:22',NULL,NULL),
(4,'G04','Warna kain memudar, aus','Perubahan warna kain jok pudar tanpa mempengaruhi fungsi dudukan tapi mempengaruhi estetika','Apakah furniture Anda mengalami warna kain memudar, aus?',4,'1','2026-01-09 20:45:22',NULL,NULL),
(5,'G05','Kerusakan ringan','Kerusakan tampil luar, tidak mempengaruhi fungsi','Apakah furniture Anda mengalami kerusakan ringan?',5,'1','2026-01-09 20:45:22',NULL,NULL),
(6,'G06','Kain kursi, sofa, springbed, matras memar atau pipih','Kain sofa mengalami perubahan bentuk seperti memar atau pipih, serta terdapat robekan pada permukaan kain yang disebabkan oleh tekanan, gesekan, atau pemakaian dalam jangka waktu tertentu, sehingga mengurangi estetika dan kenyamanan penggunaan.','Apakah furniture Anda mengalami kain kursi, sofa, springbed, matras memar atau pipih?',6,'1','2026-01-09 20:45:22',NULL,NULL),
(7,'G07','Kain retak dan pecah-pecah','Kain retak dan pecah-pecah karena disebabkan pemakaian dalam jangka waktu lama, Beban berlebih, paparan sinar matahari, gesekan terus-menerus, kualitas bahan rendah','Apakah furniture Anda mengalami kain retak dan pecah-pecah?',7,'1','2026-01-09 20:45:22',NULL,NULL),
(8,'G08','Kerangka reyot','Kerangka sofa terasa tidak kokoh, bergoyang, atau berbunyi saat digunakan, yang menunjukkan adanya penurunan kekuatan struktur rangka dan berpotensi mengganggu kenyamanan serta keamanan penggunaan.','Apakah furniture Anda mengalami kerangka reyot?',8,'1','2026-01-09 20:45:22',NULL,NULL);

/*Table structure for table `jenis_kerusakan` */

CREATE TABLE `jenis_kerusakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_kerusakan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kode unik (JK001, JK002, ...)',
  `nama_jenis_kerusakan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama kerusakan singkat',
  `detail_kerusakan` text COLLATE utf8mb4_unicode_ci COMMENT 'Penjelasan detail',
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pertanyaan untuk pelanggan',
  `ilustrasi_gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path gambar ilustrasi',
  `tingkat_kerusakan` enum('ringan','sedang','berat') COLLATE utf8mb4_unicode_ci DEFAULT 'sedang' COMMENT 'Tingkat kerusakan',
  `urutan` int DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_kode_kerusakan` (`kode_kerusakan`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE,
  KEY `idx_tingkat` (`tingkat_kerusakan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master data jenis kerusakan';

/*Data for the table `jenis_kerusakan` */

insert  into `jenis_kerusakan`(`id`,`kode_kerusakan`,`nama_jenis_kerusakan`,`detail_kerusakan`,`pertanyaan`,`ilustrasi_gambar`,`tingkat_kerusakan`,`urutan`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'JK001','Sarung jok robek',NULL,'Apakah furniture Anda mengalami kerusakan: sarung jok robek?',NULL,'berat',1,'1','2026-01-09 20:40:57',NULL,NULL),
(2,'JK002','Kain kursi/ sofa / springbed / matras robek',NULL,'Apakah furniture Anda mengalami kerusakan: kain kursi/ sofa / springbed / matras robek?',NULL,'berat',2,'1','2026-01-09 20:40:57',NULL,NULL),
(3,'JK003','Spon berlubang',NULL,'Apakah furniture Anda mengalami kerusakan: spon berlubang?',NULL,'berat',3,'1','2026-01-09 20:40:57',NULL,NULL),
(4,'JK004','Busa Kempes',NULL,'Apakah furniture Anda mengalami kerusakan: busa kempes?',NULL,'berat',4,'1','2026-01-09 20:40:57',NULL,NULL),
(5,'JK005','Karet Kendor',NULL,'Apakah furniture Anda mengalami kerusakan: karet kendor?',NULL,'berat',5,'1','2026-01-09 20:40:57',NULL,NULL),
(6,'JK006','Karet / pir putus',NULL,'Apakah furniture Anda mengalami kerusakan: karet / pir putus?',NULL,'berat',6,'1','2026-01-09 20:40:57',NULL,NULL),
(7,'JK007','Kerangka kayu lapuk',NULL,'Apakah furniture Anda mengalami kerusakan: kerangka kayu lapuk?',NULL,'berat',7,'1','2026-01-09 20:40:57',NULL,NULL),
(8,'JK008','Kerangka kayu patah',NULL,'Apakah furniture Anda mengalami kerusakan: kerangka kayu patah?',NULL,'berat',8,'1','2026-01-09 20:40:57',NULL,NULL),
(9,'JK009','sarung jok kendor',NULL,'Apakah furniture Anda mengalami kerusakan: sarung jok kendor?',NULL,'ringan',9,'1','2026-01-09 20:40:57',NULL,NULL),
(10,'JK010','Jahitan lepas',NULL,'Apakah furniture Anda mengalami kerusakan: jahitan lepas?',NULL,'ringan',10,'1','2026-01-09 20:40:57',NULL,NULL),
(11,'JK011','Warna kain memudar',NULL,'Apakah furniture Anda mengalami kerusakan: warna kain memudar?',NULL,'berat',11,'1','2026-01-09 20:40:57',NULL,NULL),
(12,'JK012','Pasak kerangka menyusut / paku lepas',NULL,'Apakah furniture Anda mengalami kerusakan: pasak kerangka menyusut / paku lepas?',NULL,'sedang',12,'1','2026-01-09 20:40:57',NULL,NULL);

/*Table structure for table `jenis_perbaikan` */

CREATE TABLE `jenis_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int NOT NULL COMMENT 'FK ke kategori_jenis_perbaikan',
  `nama_jenis_perbaikan` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama jenis furniture spesifik',
  `deskripsi` text COLLATE utf8mb4_unicode_ci COMMENT 'Deskripsi detail',
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Foto furniture',
  `urutan` int DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_jenis_perbaikan_kategori` (`id_kategori`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE,
  CONSTRAINT `fk_jenis_perbaikan_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_jenis_perbaikan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jenis furniture yang bisa diperbaiki';

/*Data for the table `jenis_perbaikan` */

insert  into `jenis_perbaikan`(`id`,`id_kategori`,`nama_jenis_perbaikan`,`deskripsi`,`gambar`,`urutan`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,'Kursi sofa 321 kipas',NULL,NULL,1,'1','2026-01-09 20:41:35',NULL,NULL),
(2,1,'Kursi 321 jaguar',NULL,NULL,2,'1','2026-01-09 20:41:35',NULL,NULL),
(3,1,'Kursi sofa valenci',NULL,NULL,3,'1','2026-01-09 20:41:35',NULL,NULL),
(4,1,'Kursi sofa tunggu',NULL,NULL,4,'1','2026-01-09 20:41:35',NULL,NULL),
(5,1,'Kursi sofa lesehan',NULL,NULL,5,'1','2026-01-09 20:41:35',NULL,NULL),
(6,1,'Kursi sofa (L) sudut',NULL,NULL,6,'1','2026-01-09 20:41:35',NULL,NULL),
(7,1,'Kursi sofa (L) minimalis',NULL,NULL,7,'1','2026-01-09 20:41:35',NULL,NULL),
(8,1,'Kursi tamu ligna',NULL,NULL,8,'1','2026-01-09 20:41:35',NULL,NULL),
(9,1,'Kursi tamu Jengki',NULL,NULL,9,'1','2026-01-09 20:41:35',NULL,NULL),
(10,1,'Kursi kayu gajagan',NULL,NULL,10,'1','2026-01-09 20:41:35',NULL,NULL),
(11,1,'Kursi kayu tigeran',NULL,NULL,11,'1','2026-01-09 20:41:35',NULL,NULL),
(12,1,'Kursi tamu menthokan',NULL,NULL,12,'1','2026-01-09 20:41:35',NULL,NULL),
(13,1,'Kursi tamu panda',NULL,NULL,13,'1','2026-01-09 20:41:35',NULL,NULL),
(14,1,'Kursi tamu hongkongan',NULL,NULL,14,'1','2026-01-09 20:41:35',NULL,NULL),
(15,1,'Kursi kayu kasandra',NULL,NULL,15,'1','2026-01-09 20:41:35',NULL,NULL),
(16,1,'Kursi menjalin',NULL,NULL,16,'1','2026-01-09 20:41:35',NULL,NULL),
(17,1,'Kursi maribet',NULL,NULL,17,'1','2026-01-09 20:41:35',NULL,NULL),
(18,1,'Kursi',NULL,NULL,18,'1','2026-01-09 20:41:35',NULL,NULL),
(19,2,'Kursi kantor putar',NULL,NULL,1,'1','2026-01-09 20:41:35',NULL,NULL),
(20,2,'Kursi roda',NULL,NULL,2,'1','2026-01-09 20:41:35',NULL,NULL),
(21,2,'Kursi salon',NULL,NULL,3,'1','2026-01-09 20:41:35',NULL,NULL),
(22,2,'Kursi rias',NULL,NULL,4,'1','2026-01-09 20:41:35',NULL,NULL),
(23,2,'Kursi lipat kuliah',NULL,NULL,5,'1','2026-01-09 20:41:35',NULL,NULL),
(24,2,'Kursi Lipat elephant',NULL,NULL,6,'1','2026-01-09 20:41:35',NULL,NULL),
(25,3,'Jok sepeda motor Honda Beat New',NULL,NULL,1,'1','2026-01-09 20:41:35',NULL,NULL),
(26,3,'Jok sepeda Honda Scopy',NULL,NULL,2,'1','2026-01-09 20:41:35',NULL,NULL),
(27,3,'Jok sepeda motor Honda PCX',NULL,NULL,3,'1','2026-01-09 20:41:35',NULL,NULL),
(28,3,'Jok sepeda motor Honda Vario 110',NULL,NULL,4,'1','2026-01-09 20:41:35',NULL,NULL),
(29,3,'Jok sepeda motor Honda Vario 125',NULL,NULL,5,'1','2026-01-09 20:41:35',NULL,NULL),
(30,3,'Jok sepeda motor Honda Supra 125 / Supra X 125',NULL,NULL,6,'1','2026-01-09 20:41:35',NULL,NULL),
(31,3,'Jok sepeda motor Honda Sumpra Fit',NULL,NULL,7,'1','2026-01-09 20:41:35',NULL,NULL),
(32,3,'Jok sepeda motor Honda Grand',NULL,NULL,8,'1','2026-01-09 20:41:35',NULL,NULL),
(33,3,'Jok sepeda motor GL Pro',NULL,NULL,9,'1','2026-01-09 20:41:35',NULL,NULL),
(34,3,'Jok sepeda motor Honda Karisma',NULL,NULL,10,'1','2026-01-09 20:41:35',NULL,NULL),
(35,3,'Jok sepeda motor Honda CBR',NULL,NULL,11,'1','2026-01-09 20:41:35',NULL,NULL),
(36,3,'Jok sepeda motor Honda V70 (cekeh)',NULL,NULL,12,'1','2026-01-09 20:41:35',NULL,NULL),
(37,3,'Jok sepeda motor yamaha NMAX',NULL,NULL,13,'1','2026-01-09 20:41:35',NULL,NULL),
(38,3,'Jok sepeda motor yamaha Jupiter Z',NULL,NULL,14,'1','2026-01-09 20:41:35',NULL,NULL),
(39,3,'Jok sepeda motor yamaha Vega R',NULL,NULL,15,'1','2026-01-09 20:41:35',NULL,NULL),
(40,3,'Jok sepeda motor mio soul',NULL,NULL,16,'1','2026-01-09 20:41:35',NULL,NULL),
(41,3,'Jok sepeda motor Yamaha FIZ R',NULL,NULL,17,'1','2026-01-09 20:41:35',NULL,NULL),
(42,3,'Jok sepeda motor Yamaha King',NULL,NULL,18,'1','2026-01-09 20:41:35',NULL,NULL),
(43,3,'Jok sepeda motor suzuki Shogun 110',NULL,NULL,19,'1','2026-01-09 20:41:35',NULL,NULL),
(44,3,'Jok sepeda motor Suzuki Shogun 125',NULL,NULL,20,'1','2026-01-09 20:41:35',NULL,NULL),
(45,3,'Jok motor ninja',NULL,NULL,21,'1','2026-01-09 20:41:35',NULL,NULL),
(46,3,'Jok motor Aerox',NULL,NULL,22,'1','2026-01-09 20:41:35',NULL,NULL),
(47,3,'Jok motor Mega Pro',NULL,NULL,24,'1','2026-01-09 20:41:35',NULL,NULL),
(48,3,'Jok motor RC',NULL,NULL,25,'1','2026-01-09 20:41:35',NULL,NULL),
(49,3,'Jok motor Honda star',NULL,NULL,26,'1','2026-01-09 20:41:35',NULL,NULL),
(50,4,'jok mobil ayla',NULL,NULL,1,'1','2026-01-09 20:41:35',NULL,NULL),
(51,4,'Jok mobil Colt Pick Up',NULL,NULL,2,'1','2026-01-09 20:41:35',NULL,NULL),
(52,4,'Jok mobil L300 Pick Up',NULL,NULL,3,'1','2026-01-09 20:41:35',NULL,NULL),
(53,4,'Jok mobil Suzuki Carry',NULL,NULL,4,'1','2026-01-09 20:41:35',NULL,NULL),
(54,4,'Jok mobil Suzuki Katana',NULL,NULL,5,'1','2026-01-09 20:41:35',NULL,NULL),
(55,4,'Jok mobil Kijang Extra',NULL,NULL,6,'1','2026-01-09 20:41:35',NULL,NULL),
(56,4,'Jok mobil kijang GX',NULL,NULL,7,'1','2026-01-09 20:41:35',NULL,NULL),
(57,4,'Jok mobil Kijang Grand Royal',NULL,NULL,8,'1','2026-01-09 20:41:35',NULL,NULL),
(58,4,'Jok mobil sedan civic',NULL,NULL,9,'1','2026-01-09 20:41:35',NULL,NULL),
(59,4,'jok mobil Truk ragaza',NULL,NULL,10,'1','2026-01-09 20:41:35',NULL,NULL),
(60,5,'Kasur springbed ukuran 120x200x20',NULL,NULL,1,'1','2026-01-09 20:41:35',NULL,NULL),
(61,5,'Kasur springbed ukuran 160x200x20',NULL,NULL,2,'1','2026-01-09 20:41:35',NULL,NULL),
(62,5,'Kasur springbed ukuran 180x200x30',NULL,NULL,3,'1','2026-01-09 20:41:35',NULL,NULL),
(63,5,'Kasur busa 180x200x20',NULL,NULL,4,'1','2026-01-09 20:41:35',NULL,NULL),
(64,5,'Kasur busa 120x200x20',NULL,NULL,5,'1','2026-01-09 20:41:35',NULL,NULL),
(65,5,'Kasur busa 120x200x14',NULL,NULL,6,'1','2026-01-09 20:41:35',NULL,NULL),
(66,5,'Kasur bayi 50x90x5',NULL,NULL,7,'1','2026-01-09 20:41:35',NULL,NULL),
(67,5,'Matras olahraga 100x200x15',NULL,NULL,8,'1','2026-01-09 20:41:35',NULL,NULL),
(68,5,'Matras senam 50x150x5',NULL,NULL,9,'1','2026-01-09 20:41:35',NULL,NULL);

/*Table structure for table `kategori_jenis_perbaikan` */

CREATE TABLE `kategori_jenis_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama kategori (Sofa, Kursi Kantor, dll)',
  `deskripsi` text COLLATE utf8mb4_unicode_ci COMMENT 'Deskripsi kategori',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Icon/gambar kategori',
  `urutan` int DEFAULT '0' COMMENT 'Urutan tampil',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '1=Aktif, 0=Nonaktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Kategori utama jenis furniture';

/*Data for the table `kategori_jenis_perbaikan` */

insert  into `kategori_jenis_perbaikan`(`id`,`nama_kategori`,`deskripsi`,`icon`,`urutan`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Sofa','Perbaikan dan servis sofa berbagai ukuran dan model','',1,'1','2026-01-09 20:33:36','2026-01-09 14:24:50',NULL),
(2,'Kursi Kantor','Perbaikan kursi kantor, gaming, dan kerja',NULL,2,'1','2026-01-09 20:33:36',NULL,NULL),
(3,'Kursi Tamu','Perbaikan kursi tamu dan ruang tamu',NULL,3,'1','2026-01-09 20:33:36',NULL,NULL),
(4,'Jok Kendaraan','Perbaikan jok mobil, motor, dan kendaraan lainnya',NULL,4,'1','2026-01-09 20:33:36',NULL,NULL),
(5,'Springbed & Kasur','Perbaikan springbed, kasur, dan tempat tidur',NULL,5,'1','2026-01-09 20:33:36',NULL,NULL),
(6,'Lain-lain','Furniture dan mebel lainnya',NULL,6,'1','2026-01-09 20:33:36',NULL,NULL);

/*Table structure for table `m_jenis_produk` */

CREATE TABLE `m_jenis_produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `m_jenis_produk` */

insert  into `m_jenis_produk`(`id`,`nama`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Meja Kantor','1','2022-04-24 13:24:11','2022-04-24 13:26:07',NULL),
(4,'Kursi sofa','1','2022-04-24 13:26:28','2022-06-08 10:28:54',NULL),
(5,'Kursi Tamu','1','2022-06-08 10:29:12',NULL,NULL),
(6,'kursi minimalis','1','2022-06-08 10:29:27',NULL,NULL),
(7,'Spring bed','1','2022-06-08 10:29:36',NULL,NULL),
(8,'Jok Mobil','1','2022-06-10 15:01:07',NULL,NULL),
(9,'Kasur','1','2022-06-10 15:29:39',NULL,NULL),
(10,'Kursi Makan','1','2022-06-10 15:48:35',NULL,NULL);

/*Table structure for table `m_kategori_produk` */

CREATE TABLE `m_kategori_produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `m_kategori_produk` */

insert  into `m_kategori_produk`(`id`,`nama`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Jasa','1','2022-04-30 09:34:28','2022-06-08 10:29:59',NULL),
(2,'Barang','1','2022-05-01 22:16:21','2022-06-08 10:29:51',NULL);

/*Table structure for table `m_pelanggan` */

CREATE TABLE `m_pelanggan` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `no_telp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_user` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `m_pelanggan` */

insert  into `m_pelanggan`(`id`,`kode`,`nama`,`no_telp`,`email`,`alamat`,`keterangan`,`status`,`id_user`,`created_at`,`updated_at`,`deleted_at`) values 
('154b1fde-10a9-4dcd-9297-8fbbd7f7a733','CS005','Akbar Putra Pratama','082123333445','akbar@gmail.com','bekasi',NULL,'1','fae99e16-c361-4cc5-b58e-a4ab0a2bd453','2022-06-08 13:58:01',NULL,NULL),
('46963430-dc6d-4f41-ba8b-397331afda50','CS007','ely cakep','09833655','elycakep@gmail.com','jember',NULL,'1','31d80e68-947e-4fa1-924f-150c73f086d1','2022-06-14 11:30:31',NULL,NULL),
('647749c7-d0a8-417f-a837-c1dd76e5c103','CS006','riskavmh','0852','riska.vmh@gmail.com','jember',NULL,'1','5a99a97b-d44a-4c14-8cc9-c02c5fd18f38','2022-06-10 08:45:34',NULL,NULL),
('999bd02e-dcf2-4308-82c1-2ffc39d25e66','CS003','Ahmad Maulana','085334545054','maulana@gmail.com','Jl. Brigjend Katamso No.06, Ngeni, Kepuhkiriman, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur',NULL,'1','da1b1f5f-2d3e-4bbb-9a3a-c4ae88809ac3','2022-05-30 02:31:44',NULL,NULL),
('aefb92d5-78b5-4f6e-b273-718af436ba88','CS001','Adira Sahara','085334545054','adira@gmail.com','Surabaya','Pelanggan Cantik','1','a27a9d2a-3253-47f7-8622-c7d4a25a5684','2022-05-01 21:30:52','2022-05-01 21:34:26',NULL),
('d076531d-9406-4660-90f7-f73e188ef3b0','CS002','Ahmad Muhammad','085334545056','ahmad@gmail.com','Bojonegoro','-','1','76caf1ff-59e6-4722-b05a-d2b9eb91bafc','2022-05-01 21:38:17',NULL,NULL),
('f0f4f507-2abd-4b74-abb6-6e95e9e970d9','CS004','Fatimah Azzahra','085334545054','fatimah@gmail.com','Jl. Brigjend Katamso No.06, Ngeni, Kepuhkiriman, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur',NULL,'1','958757ae-2bba-4216-bacc-3b5baf3ef85e','2022-06-06 15:20:13',NULL,NULL);

/*Table structure for table `m_produk` */

CREATE TABLE `m_produk` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `id_jenis_produk` int DEFAULT NULL,
  `id_satuan` int DEFAULT NULL,
  `id_kategori_produk` int DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '1',
  `slug` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `m_produk` */

insert  into `m_produk`(`id`,`kode`,`nama`,`deskripsi`,`id_jenis_produk`,`id_satuan`,`id_kategori_produk`,`harga`,`stok`,`status`,`slug`,`created_at`,`updated_at`,`deleted_at`) values 
('209bbac2-4def-43a7-a154-a36acdf7d977','P08062022001','kursi ungu','',5,1,1,500000,20,'0',NULL,'2022-06-08 10:32:49','2022-06-08 13:26:29','2022-06-10 15:25:42'),
('246a4ebf-09d0-4ff6-9558-38bb7b14b72b','P10062022006','Kasur busa','kasur ukuran 14x160x2 m dengan kualitas spons royal\r\n-ukuran kasur bisa sesuai request pelaanggan',9,4,2,1600000,50,'1',NULL,'2022-06-10 15:31:52','2022-06-13 06:28:30',NULL),
('40d40c7a-1336-4967-80eb-0adbb21aa9b8','P10062022001','kursi tigeran','perbaikan Rp1.550.000 sudah meliputi ganti sarung, karet, dan busa',5,5,2,2750000,20,'1',NULL,'2022-06-10 14:53:56','2022-06-13 06:22:38',NULL),
('4799fb28-6b42-4984-9e7b-9842b64f8d76','P10062022008','Kursi makan','harga jual Rp2900000 kursi kayu jati',10,5,1,1200000,17,'1',NULL,'2022-06-10 15:50:49','2022-06-13 06:16:33',NULL),
('5f43ed05-84d4-4758-afbc-2f11c466fb1c','P15052222001','Kursi Kayu Jati Motif Eco 1','Kursi Kayu Jati Motif Eco 1',1,4,1,400000,20,'0','1','2022-05-15 15:24:18',NULL,'2022-06-13 06:32:02'),
('76418ee8-c9ce-4ea2-ae6f-0cb65c837646','P30052022001','Soffa ungu','Perbaikan 3500000 dengan bahan kualitas bagus',4,5,2,5500000,10,'1',NULL,'2022-05-30 21:06:12','2022-06-13 06:23:56',NULL),
('76b94c75-c434-4025-bdb2-144f19cd9548','P10062022009','Kursi Gajah Jumbo','Jika perbaikan 3100000',5,5,2,5500000,8,'1',NULL,'2022-06-10 15:55:15','2022-06-14 05:01:26',NULL),
('8b1f200d-acf6-40a7-991b-cf3c9ae41e28','P30042222002','Kursi Kerang minimalis','Jika perbaikan jok dudukan Rp1.700.000 kealitas bagus',6,5,2,3000000,201,'1','1','2022-04-30 11:44:23','2022-06-10 15:44:26',NULL),
('98b0fc09-1913-433a-868b-37624e99cf24','P01052222001','Kursi kayu mahoni Kerang tanpa bantalan','',6,4,2,2200000,20,'1','1','2022-05-01 22:17:05','2022-06-10 15:47:11',NULL),
('9c2691b6-c757-4d01-af4a-57d479cd0044','P10062022004','jok mobil sedan','-Perbaikan jok sedan dengan bahan mbtex seharga Rp2000000, jika bahan yang berkualitas di bawah mbtex  seperti bahan carvero atau ZEUSS itu per unitnya 1800000.\r\n-jika bahan imitasi bahan yang murah 1 unit nya sekitar Rp.1000000\r\nharga tersebut sudah termasuk pemasangannya.',8,2,1,2000000,10,'1',NULL,'2022-06-10 15:10:07','2022-06-13 06:20:51',NULL),
('b5b22786-e2d6-4667-bcce-2462023286f1','P10062022003','Jok Mobil','perbaikan jok mobil perbaris dengan bahan Mbtex (bahan dengan kualitas bagus)',8,6,1,1000000,10,'1',NULL,'2022-06-10 15:03:36','2022-06-13 06:21:23',NULL),
('bfe7ffeb-96da-4853-9ec1-d7445835ff8a','P30042222001','Produk 21','Deskripsi Produk1',4,2,1,500001,70,'0','1','2022-04-30 11:11:35','2022-05-19 20:00:06','2022-06-08 14:01:37'),
('c3ac01f9-ffad-4e1c-8b12-822376ea5c34','P10062022002','kursi gajah tanggung','perbaikan 2.550.000',5,5,2,3700000,10,'1',NULL,'2022-06-10 14:57:28','2022-06-13 06:21:55',NULL),
('c76aa3f1-6a64-4cbd-81a8-019d12d5cb46','P08062022003','kursi kayu jati panda','Perbaikan Rp 2.500.000',5,5,1,4250000,10,'1',NULL,'2022-06-08 18:16:31','2022-06-13 06:23:03',NULL),
('d52f9846-2389-47ec-b311-bc9e6e9b9d62','P10062022005','Kursi Gajah Jumbo','perbaikan kursi tamu gajah jumbo 1 set nya Rp3.100.000 dengan bahan kualitas terbaik.',5,5,2,5500000,10,'1',NULL,'2022-06-10 15:17:58','2022-06-13 06:20:10',NULL),
('fd58b9ab-53af-4c8a-8019-81a725297ca8','P08062022002','kursi Marybed','Perbaikan Rp2.700.000',5,5,2,4500000,10,'1',NULL,'2022-06-08 18:11:58','2022-06-13 06:25:03',NULL),
('fe2895f2-da0d-424d-821e-6e2e7cbd0631','P10062022007','kursi kantor','Perbaikan kursi kantor putar Rp350000\r\nJika barang baru harga Rp1200000',1,4,1,350000,7,'1',NULL,'2022-06-10 15:40:16','2022-06-13 06:26:36',NULL);

/*Table structure for table `m_produk_image` */

CREATE TABLE `m_produk_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_produk` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `foto` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `keterangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `m_produk_image` */

insert  into `m_produk_image`(`id`,`id_produk`,`foto`,`keterangan`,`status`,`created_at`,`updated_at`) values 
(12,'8b1f200d-acf6-40a7-991b-cf3c9ae41e28','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-05-01 21:44:59',NULL),
(13,'98b0fc09-1913-433a-868b-37624e99cf24','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-05-01 22:17:25',NULL),
(16,'5f43ed05-84d4-4758-afbc-2f11c466fb1c','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-05-15 15:24:26',NULL),
(17,'5f43ed05-84d4-4758-afbc-2f11c466fb1c','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-05-15 15:24:30',NULL),
(18,'5f43ed05-84d4-4758-afbc-2f11c466fb1c','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-05-15 15:24:34',NULL),
(19,'bfe7ffeb-96da-4853-9ec1-d7445835ff8a','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-05-19 20:00:03',NULL),
(21,'209bbac2-4def-43a7-a154-a36acdf7d977','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-08 13:26:12',NULL),
(26,'209bbac2-4def-43a7-a154-a36acdf7d977','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-08 19:42:56',NULL),
(27,'209bbac2-4def-43a7-a154-a36acdf7d977','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-08 19:43:00',NULL),
(38,'76b94c75-c434-4025-bdb2-144f19cd9548','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:11:49',NULL),
(39,'4799fb28-6b42-4984-9e7b-9842b64f8d76','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:16:15',NULL),
(40,'4799fb28-6b42-4984-9e7b-9842b64f8d76','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:16:28',NULL),
(41,'246a4ebf-09d0-4ff6-9558-38bb7b14b72b','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:17:06',NULL),
(42,'d52f9846-2389-47ec-b311-bc9e6e9b9d62','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:19:44',NULL),
(43,'d52f9846-2389-47ec-b311-bc9e6e9b9d62','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:20:05',NULL),
(44,'9c2691b6-c757-4d01-af4a-57d479cd0044','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:20:38',NULL),
(45,'9c2691b6-c757-4d01-af4a-57d479cd0044','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:20:46',NULL),
(46,'b5b22786-e2d6-4667-bcce-2462023286f1','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:21:21',NULL),
(47,'c3ac01f9-ffad-4e1c-8b12-822376ea5c34','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:21:49',NULL),
(48,'40d40c7a-1336-4967-80eb-0adbb21aa9b8','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:22:28',NULL),
(49,'c76aa3f1-6a64-4cbd-81a8-019d12d5cb46','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:22:59',NULL),
(50,'76418ee8-c9ce-4ea2-ae6f-0cb65c837646','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:23:43',NULL),
(51,'76418ee8-c9ce-4ea2-ae6f-0cb65c837646','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:23:52',NULL),
(52,'fd58b9ab-53af-4c8a-8019-81a725297ca8','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:24:58',NULL),
(53,'fe2895f2-da0d-424d-821e-6e2e7cbd0631','assets/uploads/produk/produk_1655075509.jpg',NULL,'1','2022-06-13 06:26:34',NULL);

/*Table structure for table `m_satuan` */

CREATE TABLE `m_satuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `m_satuan` */

insert  into `m_satuan`(`id`,`nama`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'PCS','1','2022-03-19 13:25:30',NULL,NULL),
(2,'UNIT','1','2022-03-19 13:26:01',NULL,NULL),
(3,'KARDUS','1','2022-03-19 13:26:08',NULL,NULL),
(4,'BUAH','1','2022-03-19 13:28:44','2022-05-01 20:56:07',NULL),
(5,'1 SET','1','2022-06-08 13:20:09',NULL,NULL),
(6,'per baris','1','2022-06-10 14:58:30',NULL,NULL);

/*Table structure for table `menu` */

CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `link` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `class_icon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `is_parent` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_parent` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `keterangan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `menu` */

insert  into `menu`(`id`,`nama`,`link`,`class_icon`,`is_parent`,`id_parent`,`keterangan`) values 
(1,'Dashboard','/dashboard','fa fa-home','1',NULL,'Menu Dashboard'),
(2,'Master Data','#','fa fa-list','1',NULL,'Menu Master Data'),
(3,'Produk','/master/produk',NULL,'2',NULL,'Menu Master Produk'),
(4,'Jenis Produk','/master/jenis-produk',NULL,'2',NULL,'Menu Master Jenis Produk'),
(5,'Kategori Produk','/master/kategori-produk',NULL,'2',NULL,'Menu Master Kategori Produk'),
(6,'Pelanggan','/master/pelanggan',NULL,'2',NULL,'Menu Master Pelanggan'),
(7,'Satuan','/master/satuan',NULL,'2',NULL,'Menu Master Satuan'),
(8,'Pengaturan','#','fa fa-wrench','1',NULL,'Menu Pengaturan'),
(9,'User','/pengaturan/user',NULL,'2',NULL,'Menu Pengaturan User'),
(10,'Menu','/Pengaturan/menu',NULL,'2',NULL,'Menu Pengaturan Menu'),
(11,'Aplikasi','/Pengaturan/aplikasi',NULL,'2',NULL,'Menu Pengaturan Aplikasi'),
(12,'Order','/Order','fa fa-list','1',NULL,'Menu Order'),
(13,'Laporan','#',NULL,'1',NULL,'Menu Laporan'),
(14,'Lap. Penjualan','/laporan/penjualan\r\n',NULL,NULL,NULL,'Menu Laporan Penjualan'),
(15,'Lap. Produk Terjual','/laporan/product-terjual',NULL,NULL,NULL,'Menu Laporan Produk Terjual'),
(16,'Laporan Pengiriman','/Order/laporan_pengiriman','fa fa-home','1','','Menu Laporan Pengiriman'),
(17,'Service Order','/service_order','fa fa-tools','1',NULL,'Menu Service Order'),
(18,'Sistem Rekomendasi','#','fa fa-cogs','1',NULL,'Menu Sistem Rekomendasi'),
(19,'Kategori Perbaikan','Kategori_perbaikan',NULL,'2','18','Data Master Kategori Perbaikan'),
(20,'Jenis Perbaikan','Jenis_perbaikan',NULL,'2','18','Data Master Jenis Perbaikan'),
(21,'Gejala Kerusakan','Gejala_kerusakan',NULL,'2','18','Data Master Gejala Kerusakan'),
(22,'Jenis Kerusakan','Jenis_kerusakan',NULL,'2','18','Data Master Jenis Kerusakan'),
(23,'Rekomendasi Perbaikan','Rekomendasi_perbaikan',NULL,'2','18','Data Master Rekomendasi Perbaikan');

/*Table structure for table `menu_user` */

CREATE TABLE `menu_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_menu` int DEFAULT NULL,
  `id_role` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `posisi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `urutan` smallint DEFAULT NULL,
  `level` smallint DEFAULT NULL,
  `id_parent` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_menu_user_menu` (`id_menu`) USING BTREE,
  KEY `FK_menu_user_roles` (`id_role`) USING BTREE,
  CONSTRAINT `FK_menu_user_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_menu_user_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `menu_user` */

insert  into `menu_user`(`id`,`id_menu`,`id_role`,`posisi`,`urutan`,`level`,`id_parent`,`created_at`,`updated_at`) values 
(1,1,'ADMIN','1',1,1,NULL,'2022-06-06 21:16:54','2022-03-19 12:55:59'),
(2,2,'ADMIN','1',2,1,NULL,'2022-06-06 21:17:38','2022-03-19 12:56:01'),
(3,8,'ADMIN','1',5,1,NULL,'2022-06-06 21:17:41','2022-03-19 12:56:05'),
(4,3,'ADMIN','1',1,2,2,'2022-06-06 21:17:58','2022-03-19 12:57:33'),
(5,4,'ADMIN','1',2,2,2,'2022-06-06 21:17:55','2022-03-19 12:57:36'),
(6,5,'ADMIN','1',3,2,2,'2022-06-06 21:17:54','2022-03-19 12:57:39'),
(7,6,'ADMIN','1',4,2,2,'2022-06-06 21:17:52','2022-03-19 12:57:42'),
(8,7,'ADMIN','1',5,2,2,'2022-06-06 21:17:51','2022-03-19 12:57:45'),
(9,9,'ADMIN','1',1,2,8,'2022-06-06 21:17:49','2022-03-19 12:59:18'),
(12,12,'ADMIN','1',2,1,NULL,'2022-06-06 21:17:45','2022-05-30 09:39:10'),
(13,13,'ADMIN','1',4,1,NULL,'2022-06-06 21:17:43','2022-05-30 09:40:22'),
(14,14,'ADMIN','1',1,2,13,'2022-06-06 21:17:47','2022-05-30 13:24:23'),
(15,15,'ADMIN','1',2,2,13,'2022-06-06 21:17:59','2022-05-30 13:24:30'),
(16,1,'OWNER','1',1,1,NULL,'2022-06-06 21:50:43','2022-06-06 21:50:28'),
(17,12,'OWNER','1',2,1,NULL,'2022-06-06 21:53:09','2022-06-06 21:52:57'),
(18,13,'OWNER','1',3,1,NULL,'2022-06-06 21:54:04','2022-06-06 21:53:54'),
(19,14,'OWNER','1',1,2,13,'2022-06-06 21:54:34','2022-06-06 21:54:16'),
(20,15,'OWNER','1',2,2,13,'2022-06-06 21:55:03','2022-06-06 21:54:40'),
(21,1,'KURIR','1',1,1,NULL,'2022-06-25 13:20:23','2022-06-25 13:20:23'),
(22,16,'KURIR','1',2,1,NULL,'2022-06-25 13:21:08','2022-06-25 13:21:08'),
(23,17,'ADMIN','1',3,1,NULL,'2025-08-30 10:44:09','2025-08-30 10:44:09'),
(24,17,'OWNER','1',4,1,NULL,'2025-08-30 10:44:21','2025-08-30 10:44:21'),
(25,18,'OWNER','1',4,1,NULL,'2026-01-01 19:17:36','2026-01-01 19:17:36'),
(30,19,'OWNER','1',1,2,18,'2026-01-09 21:08:45','2026-01-09 21:08:45'),
(31,20,'OWNER','1',2,2,18,'2026-01-09 21:08:45','2026-01-09 21:08:45'),
(32,21,'OWNER','1',3,2,18,'2026-01-09 21:08:45','2026-01-09 21:08:45'),
(33,22,'OWNER','1',4,2,18,'2026-01-09 21:08:45','2026-01-09 21:08:45'),
(34,23,'OWNER','1',5,2,18,'2026-01-09 21:08:45','2026-01-09 21:08:45');

/*Table structure for table `order_detail` */

CREATE TABLE `order_detail` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_order` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_produk` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_cart` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_order_detail_orders` (`id_order`) USING BTREE,
  KEY `FK_order_detail_m_produk` (`id_produk`) USING BTREE,
  CONSTRAINT `FK_order_detail_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `m_produk` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_order_detail_orders` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `order_detail` */

insert  into `order_detail`(`id`,`id_order`,`id_produk`,`qty`,`harga`,`created_at`,`updated_at`,`id_cart`) values 
('22e1a6bb-333e-4c73-864d-751a147e5530','26a7c06d-6d12-4d80-a6c8-6b78afbe98a0','76418ee8-c9ce-4ea2-ae6f-0cb65c837646',1,1000000,'2022-06-08 13:23:45','2022-06-08 13:23:45',31),
('3d6eb904-c0a3-4aaf-aaf6-9ec33d716d4c','8354b7bf-f079-4c23-829c-c62e9eb1e405','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1200000,'2022-06-13 22:36:42','2022-06-13 22:36:42',35),
('3fb99788-382b-4d15-aab8-bf378a485c49','64fd0aa2-5404-4550-95a7-1480ab44752b','5f43ed05-84d4-4758-afbc-2f11c466fb1c',1,400000,'2022-05-30 15:52:47','2022-05-30 15:52:47',18),
('40d2d4f1-15f2-4de5-92ad-8cd113619144','78682f6c-8bb0-43de-a9ad-21aa10f7bc57','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1200000,'2025-08-30 09:18:25','2025-08-30 09:18:25',42),
('4579d693-a94c-4fc8-84d0-ca8c8723df57','e5f56343-8e06-4404-957b-a44a50ba7d21','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1200000,'2022-06-14 11:35:44','2022-06-14 11:35:44',38),
('79a44f27-e1ef-48d3-bb08-59d68d526d97','5ff3e369-8e08-4e95-9355-a83125a8bd80','4799fb28-6b42-4984-9e7b-9842b64f8d76',1,1200000,'2022-06-14 04:49:20','2022-06-14 04:49:20',36),
('79e03725-d824-477d-83cf-d74db674c6f7','d1351f3a-3c3d-4ece-a4ed-126bce0b53af','fe2895f2-da0d-424d-821e-6e2e7cbd0631',2,350000,'2022-06-14 09:19:36','2022-06-14 09:19:36',37),
('7a0b85e7-579b-490a-9069-c7a05c4bbc8a','26a7c06d-6d12-4d80-a6c8-6b78afbe98a0','209bbac2-4def-43a7-a154-a36acdf7d977',1,500000,'2022-06-08 13:23:45','2022-06-08 13:23:45',29),
('7c418b74-6ca3-4b87-a7c9-66b8b142a9d1','e4667eb2-8791-4d51-9ee7-80bdafef3aaf','5f43ed05-84d4-4758-afbc-2f11c466fb1c',2,400000,'2022-05-30 20:30:52','2022-05-30 20:30:52',20),
('822898b4-5909-4456-8f25-7c7c79bc92f9','037bb80c-767a-4cc3-a825-b2692f80c0d0','76b94c75-c434-4025-bdb2-144f19cd9548',1,5500000,'2022-06-18 12:41:13','2022-06-18 12:41:13',40),
('84138d31-10fe-4c9a-a252-0aa972cd3809','e5f56343-8e06-4404-957b-a44a50ba7d21','fe2895f2-da0d-424d-821e-6e2e7cbd0631',1,350000,'2022-06-14 11:35:45','2022-06-14 11:35:45',39),
('8d31c024-f52d-46dc-a80e-dbb245cccf8e','5eb4cb20-32b8-44f4-b3b8-12807df2845d','98b0fc09-1913-433a-868b-37624e99cf24',1,1000000,'2022-06-07 00:01:17','2022-06-07 00:01:17',28),
('901d94bf-cf65-4424-8280-267f1ff745b6','ee18f3b6-1072-4c77-a43b-e791bb62f08c','98b0fc09-1913-433a-868b-37624e99cf24',1,1000000,'2022-05-30 20:47:13','2022-05-30 20:47:13',23),
('93d096da-7211-4df8-9f8b-5892cbee7d94','26a7c06d-6d12-4d80-a6c8-6b78afbe98a0','98b0fc09-1913-433a-868b-37624e99cf24',1,1000000,'2022-06-08 13:23:45','2022-06-08 13:23:45',30),
('9b6a2117-0d4b-4e2f-87ad-8e7b6094a133','781727a8-d246-475c-922b-ab05e646f3d9','5f43ed05-84d4-4758-afbc-2f11c466fb1c',2,400000,'2022-05-31 06:52:58','2022-05-31 06:52:58',24),
('a9bd0f94-e9b0-4bfd-80e6-bf8ffc585926','006095be-9a10-4df6-934e-8739ea7996b6','76b94c75-c434-4025-bdb2-144f19cd9548',1,5500000,'2022-06-13 21:15:24','2022-06-13 21:15:24',34),
('b03af72f-d450-4188-9ffd-06e90cc6d086','781727a8-d246-475c-922b-ab05e646f3d9','8b1f200d-acf6-40a7-991b-cf3c9ae41e28',1,60000,'2022-05-31 06:52:58','2022-05-31 06:52:58',25),
('c533b70f-fd5a-4247-a109-5be89910114a','422e4a74-512c-4725-b278-dead6bf94aa9','40d40c7a-1336-4967-80eb-0adbb21aa9b8',1,2750000,'2022-06-12 22:08:24','2022-06-12 22:08:24',33),
('cf02e372-36f6-48c0-9816-3a4f6dc473f9','4e479595-d9be-40a9-99f9-8458c18e6297','76b94c75-c434-4025-bdb2-144f19cd9548',1,5500000,'2022-06-18 12:59:54','2022-06-18 12:59:54',41),
('d9aa533f-1b30-4beb-bf78-5f476d4daeff','e4667eb2-8791-4d51-9ee7-80bdafef3aaf','98b0fc09-1913-433a-868b-37624e99cf24',1,1000000,'2022-05-30 20:30:52','2022-05-30 20:30:52',21),
('dfdd7249-05bc-4eb5-a135-c00fe2293154','ee18f3b6-1072-4c77-a43b-e791bb62f08c','5f43ed05-84d4-4758-afbc-2f11c466fb1c',2,400000,'2022-05-30 20:47:13','2022-05-30 20:47:13',22),
('e64fa479-5208-4079-bcfb-d09661a67b5c','48566ed3-e69e-45f4-8afb-01a10adeea91','76418ee8-c9ce-4ea2-ae6f-0cb65c837646',2,1000000,'2022-06-10 08:46:35','2022-06-10 08:46:35',32),
('e7463c59-a6c9-4da9-bdf3-55cc390db105','64fd0aa2-5404-4550-95a7-1480ab44752b','98b0fc09-1913-433a-868b-37624e99cf24',1,1000000,'2022-05-30 15:52:47','2022-05-30 15:52:47',19);

/*Table structure for table `order_status` */

CREATE TABLE `order_status` (
  `id` int NOT NULL,
  `keterangan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `order_status` */

insert  into `order_status`(`id`,`keterangan`) values 
(1,'Validasi Pembayaran'),
(2,'Pesanan Diproses'),
(3,'Pesanan Dikirim'),
(4,'Pesanan Selesai'),
(5,'Dibatalkan');

/*Table structure for table `orders` */

CREATE TABLE `orders` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_invoice` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_pelanggan` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_alamat` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bukti_bayar` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tanggal_upload` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_orders_m_pelanggan` (`id_pelanggan`) USING BTREE,
  CONSTRAINT `FK_orders_m_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `m_pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='1 => Validasi Pembayaran\r\n2 => Pesanan Diproses\r\n3 => Pesanan Dikirim\r\n4 => Pesanan Selesai\r\n5 => Batal';

/*Data for the table `orders` */

insert  into `orders`(`id`,`no_invoice`,`tanggal`,`id_pelanggan`,`total`,`keterangan`,`status`,`id_alamat`,`bukti_bayar`,`tanggal_upload`,`created_at`,`updated_at`) values 
('006095be-9a10-4df6-934e-8739ea7996b6','INV13062022001','2022-06-13','aefb92d5-78b5-4f6e-b273-718af436ba88',5500000,'order warna ungu','4','5f124bbc-84b4-4949-afc9-571befcd9b55','',NULL,'2022-06-13 21:15:24','2022-06-13 21:17:17'),
('037bb80c-767a-4cc3-a825-b2692f80c0d0','INV18062022001','2022-06-18','aefb92d5-78b5-4f6e-b273-718af436ba88',5500000,'','1','4aa5b1e8-56e4-4254-92f9-5573eb26e1d7','',NULL,'2022-06-18 12:41:13','2022-06-18 12:41:13'),
('26a7c06d-6d12-4d80-a6c8-6b78afbe98a0','INV08062022001','2022-06-08','f0f4f507-2abd-4b74-abb6-6e95e9e970d9',2500000,'','4','01da1de5-1437-4f83-b99f-cde5089b354d','',NULL,'2022-06-08 13:23:45','2022-06-08 13:24:42'),
('422e4a74-512c-4725-b278-dead6bf94aa9','INV12062022001','2022-06-12','aefb92d5-78b5-4f6e-b273-718af436ba88',2750000,'','1','5f124bbc-84b4-4949-afc9-571befcd9b55','',NULL,'2022-06-12 22:08:24','2022-06-12 22:08:24'),
('48566ed3-e69e-45f4-8afb-01a10adeea91','INV10062022001','2022-06-10','647749c7-d0a8-417f-a837-c1dd76e5c103',2000000,'','1','fd6ea135-9193-4239-848d-4a415c26ebc3','',NULL,'2022-06-10 08:46:35','2022-06-10 08:46:35'),
('4e479595-d9be-40a9-99f9-8458c18e6297','INV18062022002','2022-06-18','aefb92d5-78b5-4f6e-b273-718af436ba88',5500000,'','1','4aa5b1e8-56e4-4254-92f9-5573eb26e1d7','',NULL,'2022-06-18 12:59:54','2022-06-18 12:59:54'),
('5eb4cb20-32b8-44f4-b3b8-12807df2845d','INV07062022001','2022-06-07','999bd02e-dcf2-4308-82c1-2ffc39d25e66',1000000,'Segera dikirim ya','4','1c0ce4de-fd33-471f-ad23-153ae79dcf1f','',NULL,'2022-06-07 00:01:17','2022-06-07 00:02:45'),
('5ff3e369-8e08-4e95-9355-a83125a8bd80','INV14062022001','2022-06-14','aefb92d5-78b5-4f6e-b273-718af436ba88',1200000,'segera dikirim ya','4','f4e67a1e-a0a4-4750-b8b9-0c9a5709ee00','',NULL,'2022-06-14 04:49:20','2022-06-14 04:55:44'),
('64fd0aa2-5404-4550-95a7-1480ab44752b','INV30052022001','2022-05-30','aefb92d5-78b5-4f6e-b273-718af436ba88',1400000,'sdfdsfsdf','4','5f124bbc-84b4-4949-afc9-571befcd9b55','',NULL,'2022-05-30 15:52:47','2022-05-31 06:20:01'),
('781727a8-d246-475c-922b-ab05e646f3d9','INV31052022001','2022-05-31','aefb92d5-78b5-4f6e-b273-718af436ba88',860000,'segera dikirim ya ka','4','5f124bbc-84b4-4949-afc9-571befcd9b55','',NULL,'2022-05-31 06:52:58','2022-05-31 06:56:17'),
('78682f6c-8bb0-43de-a9ad-21aa10f7bc57','INV30082025001','2025-08-30','aefb92d5-78b5-4f6e-b273-718af436ba88',1200000,'test','1','4aa5b1e8-56e4-4254-92f9-5573eb26e1d7','assets/uploads/bukti_pembayaran/bukti_pembayaran_1756520318.png','2025-08-30 09:18:38','2025-08-30 09:18:25','2025-08-30 09:18:25'),
('8354b7bf-f079-4c23-829c-c62e9eb1e405','INV13062022002','2022-06-13','aefb92d5-78b5-4f6e-b273-718af436ba88',1200000,'','4','5f124bbc-84b4-4949-afc9-571befcd9b55','',NULL,'2022-06-13 22:36:42','2022-06-13 22:37:59'),
('d1351f3a-3c3d-4ece-a4ed-126bce0b53af','INV14062022002','2022-06-14','aefb92d5-78b5-4f6e-b273-718af436ba88',700000,'','4','4aa5b1e8-56e4-4254-92f9-5573eb26e1d7','',NULL,'2022-06-14 09:19:36','2022-06-14 09:21:08'),
('e4667eb2-8791-4d51-9ee7-80bdafef3aaf','INV30052022002','2022-05-30','aefb92d5-78b5-4f6e-b273-718af436ba88',1800000,'segera dikirim','4','5f124bbc-84b4-4949-afc9-571befcd9b55','',NULL,'2022-05-30 20:30:52','2022-05-31 03:00:28'),
('e5f56343-8e06-4404-957b-a44a50ba7d21','INV14062022003','2022-06-14','46963430-dc6d-4f41-ba8b-397331afda50',1550000,'','4','e0f0ab25-5471-416c-a8bf-1c52b902c6e7','',NULL,'2022-06-14 11:35:44','2022-06-14 11:40:40'),
('ee18f3b6-1072-4c77-a43b-e791bb62f08c','INV30052022003','2022-05-30','aefb92d5-78b5-4f6e-b273-718af436ba88',1800000,'Segera Dikirim ya kak','3','5f124bbc-84b4-4949-afc9-571befcd9b55','',NULL,'2022-05-30 20:47:13','2022-05-30 19:56:08');

/*Table structure for table `pelanggan_alamat` */

CREATE TABLE `pelanggan_alamat` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_pelanggan` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `kode_pos` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `penerima` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `no_telp` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_utama` tinyint(1) DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `pelanggan_alamat` */

insert  into `pelanggan_alamat`(`id`,`id_pelanggan`,`alamat`,`kode_pos`,`penerima`,`no_telp`,`is_utama`,`keterangan`,`status`,`created_at`,`updated_at`) values 
('01da1de5-1437-4f83-b99f-cde5089b354d','f0f4f507-2abd-4b74-abb6-6e95e9e970d9','Jl Patrang No 31 Jember','62166','Fatimah','08667456718',1,'-','1','2022-06-14 03:11:57',NULL),
('1c0ce4de-fd33-471f-ad23-153ae79dcf1f','999bd02e-dcf2-4308-82c1-2ffc39d25e66','Jl Pattimura No 31','62166','Ahmad Maulana','085667454312',1,'-','1','2022-06-14 03:09:13',NULL),
('4aa5b1e8-56e4-4254-92f9-5573eb26e1d7','aefb92d5-78b5-4f6e-b273-718af436ba88','jalan manggar gg 5 no 9','19021','dewi','089080802020',1,'depan mushola','1','2022-06-14 04:52:55','2022-06-14 04:53:10'),
('5f124bbc-84b4-4949-afc9-571befcd9b55','aefb92d5-78b5-4f6e-b273-718af436ba88','Jl. Amir Mahmud No 1 Gunung Anyar','62166','Ibu Aminah','085334545054',0,'Depan Musholla Al-Waqqifin','1','2022-06-13 01:56:51','2022-06-14 04:53:24'),
('e0f0ab25-5471-416c-a8bf-1c52b902c6e7','46963430-dc6d-4f41-ba8b-397331afda50','jember','86778','ely','09765443',0,'depan masjid','1','2022-06-14 11:35:20',NULL),
('f4e67a1e-a0a4-4750-b8b9-0c9a5709ee00','aefb92d5-78b5-4f6e-b273-718af436ba88','Jl. Kenangan Jember','62166','Bambang','085334545054',0,'Dekat Musholla','1','2022-06-13 21:14:21',NULL),
('fd6ea135-9193-4239-848d-4a415c26ebc3','647749c7-d0a8-417f-a837-c1dd76e5c103','Jl Ir Soekarno no 4','62166','Riska','085667878915',1,'-','1','2022-06-14 03:36:19',NULL);

/*Table structure for table `produk_rating` */

CREATE TABLE `produk_rating` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_produk_detail` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_user` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ulasan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `rating` int DEFAULT NULL,
  `anonim` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_produk_rating_users` (`id_user`) USING BTREE,
  KEY `FK_produk_rating_order_detail` (`id_produk_detail`) USING BTREE,
  CONSTRAINT `FK_produk_rating_order_detail` FOREIGN KEY (`id_produk_detail`) REFERENCES `order_detail` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_produk_rating_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `produk_rating` */

insert  into `produk_rating`(`id`,`id_produk_detail`,`id_user`,`ulasan`,`rating`,`anonim`,`created_at`,`updated_at`) values 
(22,'3fb99788-382b-4d15-aab8-bf378a485c49','a27a9d2a-3253-47f7-8622-c7d4a25a5684','Bagus',4,'0','2022-06-05 22:55:32','2022-06-05 22:55:32'),
(23,'e7463c59-a6c9-4da9-bdf3-55cc390db105','a27a9d2a-3253-47f7-8622-c7d4a25a5684','Mantapp',5,'0','2022-06-05 22:55:32','2022-06-05 22:55:32'),
(24,'9b6a2117-0d4b-4e2f-87ad-8e7b6094a133','a27a9d2a-3253-47f7-8622-c7d4a25a5684','Sipp',5,'0','2022-06-06 19:43:57','2022-06-06 19:43:57'),
(25,'b03af72f-d450-4188-9ffd-06e90cc6d086','a27a9d2a-3253-47f7-8622-c7d4a25a5684','Keren',4,'0','2022-06-06 19:43:57','2022-06-06 19:43:57'),
(26,'8d31c024-f52d-46dc-a80e-dbb245cccf8e','da1b1f5f-2d3e-4bbb-9a3a-c4ae88809ac3','Kualitas bagus',4,'0','2022-06-07 00:03:10','2022-06-07 00:03:10'),
(27,'22e1a6bb-333e-4c73-864d-751a147e5530','958757ae-2bba-4216-bacc-3b5baf3ef85e','',4,'0','2022-06-08 13:25:22','2022-06-08 13:25:22'),
(28,'7a0b85e7-579b-490a-9069-c7a05c4bbc8a','958757ae-2bba-4216-bacc-3b5baf3ef85e','',5,'0','2022-06-08 13:25:22','2022-06-08 13:25:22'),
(29,'93d096da-7211-4df8-9f8b-5892cbee7d94','958757ae-2bba-4216-bacc-3b5baf3ef85e','',5,'0','2022-06-08 13:25:22','2022-06-08 13:25:22'),
(30,'7c418b74-6ca3-4b87-a7c9-66b8b142a9d1','a27a9d2a-3253-47f7-8622-c7d4a25a5684','',5,'0','2022-06-08 13:29:39','2022-06-08 13:29:39'),
(31,'d9aa533f-1b30-4beb-bf78-5f476d4daeff','a27a9d2a-3253-47f7-8622-c7d4a25a5684','',4,'0','2022-06-08 13:29:39','2022-06-08 13:29:39'),
(32,'a9bd0f94-e9b0-4bfd-80e6-bf8ffc585926','a27a9d2a-3253-47f7-8622-c7d4a25a5684','Barang Bagus dan pengiriman cepat',5,'0','2022-06-13 21:18:51','2022-06-13 21:18:51'),
(33,'3d6eb904-c0a3-4aaf-aaf6-9ec33d716d4c','a27a9d2a-3253-47f7-8622-c7d4a25a5684','bagus layanan memuaskan',4,'0','2022-06-13 22:39:40','2022-06-13 22:39:40'),
(34,'3d6eb904-c0a3-4aaf-aaf6-9ec33d716d4c','a27a9d2a-3253-47f7-8622-c7d4a25a5684','bagus layanan memuaskan',4,'0','2022-06-13 22:39:41','2022-06-13 22:39:41'),
(35,'79a44f27-e1ef-48d3-bb08-59d68d526d97','a27a9d2a-3253-47f7-8622-c7d4a25a5684','kualitas produk sangat baik',5,'0','2022-06-14 04:56:36','2022-06-14 04:56:36'),
(36,'79e03725-d824-477d-83cf-d74db674c6f7','a27a9d2a-3253-47f7-8622-c7d4a25a5684','kualitas bahan bagus',5,'0','2022-06-14 09:22:10','2022-06-14 09:22:10'),
(37,'4579d693-a94c-4fc8-84d0-ca8c8723df57','31d80e68-947e-4fa1-924f-150c73f086d1','cakep',4,'0','2022-06-14 11:43:05','2022-06-14 11:43:05'),
(38,'84138d31-10fe-4c9a-a252-0aa972cd3809','31d80e68-947e-4fa1-924f-150c73f086d1','cakep',4,'0','2022-06-14 11:43:05','2022-06-14 11:43:05');

/*Table structure for table `rekomendasi_perbaikan` */

CREATE TABLE `rekomendasi_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_rekomendasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kode unik (R001, R002, ...)',
  `nama_rekomendasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama rekomendasi singkat',
  `detail_perbaikan` text COLLATE utf8mb4_unicode_ci COMMENT 'Detail langkah perbaikan',
  `estimasi_harga_min` decimal(12,2) DEFAULT NULL COMMENT 'Harga minimum',
  `estimasi_harga_max` decimal(12,2) DEFAULT NULL COMMENT 'Harga maksimum',
  `estimasi_waktu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Estimasi waktu (2-3 hari, 1 minggu, dll)',
  `mb_value` decimal(3,2) DEFAULT '0.00' COMMENT 'Measure of Belief (0.00 - 1.00)',
  `md_value` decimal(3,2) DEFAULT '0.00' COMMENT 'Measure of Disbelief (0.00 - 1.00)',
  `urutan` int DEFAULT '0',
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_kode_rekomendasi` (`kode_rekomendasi`) USING BTREE,
  KEY `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Master data rekomendasi perbaikan dengan MB & MD';

/*Data for the table `rekomendasi_perbaikan` */

insert  into `rekomendasi_perbaikan`(`id`,`kode_rekomendasi`,`nama_rekomendasi`,`detail_perbaikan`,`estimasi_harga_min`,`estimasi_harga_max`,`estimasi_waktu`,`mb_value`,`md_value`,`urutan`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'R01','Ganti sarung jok','Untuk kerusakan: Sarung jok robek. Tingkat: berat',NULL,NULL,NULL,1.00,0.00,1,'1','2026-01-09 20:53:27',NULL,NULL),
(2,'R02','Ganti kain','Untuk kerusakan: Kain kursi/ sofa / springbed / matras robek. Tingkat: berat',NULL,NULL,NULL,1.00,0.00,2,'1','2026-01-09 20:53:27',NULL,NULL),
(3,'R03','Menambal / ganti spons dudukan','Untuk kerusakan: Spons berlubang. Tingkat: berat',NULL,NULL,NULL,0.80,0.20,3,'1','2026-01-09 20:53:27',NULL,NULL),
(4,'R04','Menambah / ganti spons','Untuk kerusakan: Spons kempes. Tingkat: berat',NULL,NULL,NULL,0.80,0.20,4,'1','2026-01-09 20:53:27',NULL,NULL),
(5,'R05','Mengencangkan atau ganti karet','Untuk kerusakan: Karet kendor. Tingkat: berat',NULL,NULL,NULL,0.60,0.40,5,'1','2026-01-09 20:53:27',NULL,NULL),
(6,'R06','Mengganti pir / sistem perdudukan','Untuk kerusakan: Karet / pir putus. Tingkat: berat',NULL,NULL,NULL,0.80,0.20,6,'1','2026-01-09 20:53:27',NULL,NULL),
(7,'R07','Penggantian sebagian rangka kayu','Untuk kerusakan: kerangka kayu lapuk. Tingkat: berat',NULL,NULL,NULL,0.60,0.40,7,'1','2026-01-09 20:53:27',NULL,NULL),
(8,'R08','Penggantian rangka dudukan','Untuk kerusakan: Kerangka kayu patah. Tingkat: berat',NULL,NULL,NULL,1.00,0.00,8,'1','2026-01-09 20:53:27',NULL,NULL),
(9,'R09','Penyesuaian dan pengencangan sarung jok','Untuk kerusakan: sarung jok kendor. Tingkat: ringan',NULL,NULL,NULL,0.80,0.20,9,'1','2026-01-09 20:53:27',NULL,NULL),
(10,'R10','Menjahit ulang jahitan','Untuk kerusakan: Jahitan lepas. Tingkat: ringan',NULL,NULL,NULL,1.00,0.00,10,'1','2026-01-09 20:53:27',NULL,NULL),
(11,'R11','Penggantian kain jok','Untuk kerusakan: Warna kain memudar. Tingkat: berat',NULL,NULL,NULL,1.00,0.00,11,'1','2026-01-09 20:53:27',NULL,NULL),
(12,'R12','Mengganti pasak, menambah lem, dan paku','Untuk kerusakan: Pasak kerangka menyusut / paku lepas. Tingkat: sedang',NULL,NULL,NULL,0.60,0.40,12,'1','2026-01-09 20:53:27',NULL,NULL);

/*Table structure for table `relasi_gejala_jenis_perbaikan` */

CREATE TABLE `relasi_gejala_jenis_perbaikan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jenis_perbaikan` int NOT NULL,
  `id_gejala_kerusakan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_relasi_gejala_jp` (`id_jenis_perbaikan`,`id_gejala_kerusakan`) USING BTREE,
  KEY `fk_relasi_gejala_jp` (`id_jenis_perbaikan`) USING BTREE,
  KEY `fk_relasi_gejala_gk` (`id_gejala_kerusakan`) USING BTREE,
  CONSTRAINT `fk_relasi_gejala_gk` FOREIGN KEY (`id_gejala_kerusakan`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_relasi_gejala_jp` FOREIGN KEY (`id_jenis_perbaikan`) REFERENCES `jenis_perbaikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi gejala dengan jenis perbaikan';

/*Data for the table `relasi_gejala_jenis_perbaikan` */

/*Table structure for table `relasi_jenis_kerusakan_gejala` */

CREATE TABLE `relasi_jenis_kerusakan_gejala` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jenis_kerusakan` int NOT NULL,
  `id_gejala_kerusakan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_relasi_jk_gejala` (`id_jenis_kerusakan`,`id_gejala_kerusakan`) USING BTREE,
  KEY `fk_relasi_jk_jk` (`id_jenis_kerusakan`) USING BTREE,
  KEY `fk_relasi_jk_gejala` (`id_gejala_kerusakan`) USING BTREE,
  CONSTRAINT `fk_relasi_jk_gejala` FOREIGN KEY (`id_gejala_kerusakan`) REFERENCES `gejala_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_relasi_jk_jk` FOREIGN KEY (`id_jenis_kerusakan`) REFERENCES `jenis_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi jenis kerusakan dengan gejala';

/*Data for the table `relasi_jenis_kerusakan_gejala` */

/*Table structure for table `relasi_rekomendasi_jenis_kerusakan` */

CREATE TABLE `relasi_rekomendasi_jenis_kerusakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_rekomendasi_perbaikan` int NOT NULL,
  `id_jenis_kerusakan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uk_relasi_rek_jk` (`id_rekomendasi_perbaikan`,`id_jenis_kerusakan`) USING BTREE,
  KEY `fk_relasi_rek_rek` (`id_rekomendasi_perbaikan`) USING BTREE,
  KEY `fk_relasi_rek_jk` (`id_jenis_kerusakan`) USING BTREE,
  CONSTRAINT `fk_relasi_rek_jk` FOREIGN KEY (`id_jenis_kerusakan`) REFERENCES `jenis_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_relasi_rek_rek` FOREIGN KEY (`id_rekomendasi_perbaikan`) REFERENCES `rekomendasi_perbaikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relasi rekomendasi dengan jenis kerusakan';

/*Data for the table `relasi_rekomendasi_jenis_kerusakan` */

/*Table structure for table `roles` */

CREATE TABLE `roles` (
  `id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `nama` (`nama`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `roles` */

insert  into `roles`(`id`,`nama`,`keterangan`,`created_at`,`updated_at`) values 
('ADMIN','Admin','Hak Akses Paling Tinggi','2022-03-19 11:42:35','2022-03-19 11:42:36'),
('KURIR','Kurir','Hak Akses Kurir',NULL,NULL),
('OWNER','Owner','Hak Akses Owner','2022-03-19 13:47:04','2022-03-19 13:47:05'),
('PELANGGAN','Pelanggan','Hak Akses Pelanggan','2022-05-01 21:16:39','2022-05-01 21:16:40');

/*Table structure for table `service_orders` */

CREATE TABLE `service_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `customer_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `service_type` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `service_method` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `damage_description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `material_type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `foam_modification` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `shape_modification` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `service_date` date NOT NULL,
  `service_time` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `special_notes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `estimated_cost` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `vehicle_brand` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `chair_type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bed_size` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `order_photos` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `order_date` datetime NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pesanan_diterima',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `admin_notes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

/*Data for the table `service_orders` */

insert  into `service_orders`(`id`,`order_id`,`customer_name`,`phone_number`,`address`,`service_type`,`service_method`,`damage_description`,`material_type`,`foam_modification`,`shape_modification`,`service_date`,`service_time`,`special_notes`,`estimated_cost`,`vehicle_brand`,`chair_type`,`bed_size`,`order_photos`,`order_date`,`status`,`updated_at`,`created_at`,`user_id`,`admin_notes`) values 
(1,'ORD-20250830-3904','12','213','321','jok-mobil','antar-lokasi','321','kulit-sintetis','tambah-busa','123','2025-08-31','08:00-10:00','123','Rp 600.000','123',NULL,NULL,NULL,'2025-08-30 02:51:19','pesanan_diterima',NULL,'2025-08-30 09:51:19',NULL,NULL),
(2,'ORD-20250830-2909','Test','0123123','asdsad123','jok-motor','antar-lokasi','321','kulit-asli','kurangi-busa','123','2025-08-31','08:00-10:00','321321','Rp 350.000','123',NULL,NULL,NULL,'2025-08-30 02:54:13','pesanan_diterima',NULL,'2025-08-30 09:54:13',NULL,NULL),
(3,'ORD-20250830-2662','Test','0123123','asdsad123','jok-motor','antar-lokasi','321','kulit-asli','kurangi-busa','123','2025-08-31','08:00-10:00','321321','Rp 350.000','123',NULL,NULL,NULL,'2025-08-30 02:54:25','pesanan_diterima',NULL,'2025-08-30 09:54:25',NULL,NULL),
(4,'ORD-20250830-1680','Test','0123123','asdsad123','jok-motor','antar-lokasi','321','kulit-asli','kurangi-busa','123','2025-08-31','08:00-10:00','321321','Rp 350.000','123',NULL,NULL,NULL,'2025-08-30 02:54:30','pesanan_diterima',NULL,'2025-08-30 09:54:30',NULL,NULL),
(5,'ORD-20250830-0708','Ryan','123','123123','spring-bed','antar-lokasi','213','kulit-asli','','123','2025-08-31','08:00-10:00','32132','Rp 1.000.000',NULL,NULL,'super-single',NULL,'2025-08-30 02:55:32','pesanan_diterima',NULL,'2025-08-30 09:55:32',NULL,NULL),
(6,'ORD-20250830-6003','Ryan','123','123123','spring-bed','antar-lokasi','213','kulit-asli','','123','2025-08-31','08:00-10:00','32132','Rp 1.000.000',NULL,NULL,'super-single',NULL,'2025-08-30 02:56:10','pesanan_diterima',NULL,'2025-08-30 09:56:10',NULL,NULL),
(7,'ORD-20250830-5887','Ryan','123','123123','spring-bed','antar-lokasi','213','kulit-asli','','123','2025-08-31','08:00-10:00','32132','Rp 1.000.000',NULL,NULL,'super-single',NULL,'2025-08-30 02:56:36','pesanan_diterima',NULL,'2025-08-30 09:56:36',NULL,NULL),
(8,'ORD-20250830-0646','12312312','32131','2321','jok-motor','antar-lokasi','1123','kulit-sintetis','ganti-busa','123','2025-08-31','08:00-10:00','123','Rp 250.000','213',NULL,NULL,NULL,'2025-08-30 02:59:19','pesanan_diterima',NULL,'2025-08-30 09:59:19',NULL,NULL),
(9,'ORD-20250830-4932','12312312','32131','2321','jok-motor','antar-lokasi','1123','kulit-sintetis','ganti-busa','123','2025-08-31','08:00-10:00','123','Rp 250.000','213',NULL,NULL,NULL,'2025-08-30 02:59:44','pesanan_diterima',NULL,'2025-08-30 09:59:44',NULL,NULL),
(10,'ORD-20250830-6549','12312312','123213','12','jok-mobil','antar-lokasi','1321','kulit-sintetis','ganti-busa','123','2025-09-02','15:00-17:00','123','Rp 600.000','12312312',NULL,NULL,NULL,'2025-08-30 03:01:09','pesanan_diterima',NULL,'2025-08-30 10:01:09',NULL,NULL),
(11,'ORD-20250830-4685','12312312','123213','12','jok-mobil','antar-lokasi','1321','kulit-sintetis','ganti-busa','123','2025-09-02','15:00-17:00','123','Rp 600.000','12312312',NULL,NULL,NULL,'2025-08-30 03:03:21','pesanan_diterima',NULL,'2025-08-30 10:03:21',NULL,NULL),
(12,'ORD-20250830-9181','12312312','123213','12','jok-mobil','antar-lokasi','1321','kulit-sintetis','ganti-busa','123','2025-09-02','15:00-17:00','123','Rp 600.000','12312312',NULL,NULL,NULL,'2025-08-30 03:03:53','pesanan_diterima',NULL,'2025-08-30 10:03:53',NULL,NULL),
(13,'ORD-20250830-0959','123123','123123123','12312312','spring-bed','antar-lokasi','21312312','kulit-sintetis','','123','2025-08-31','10:00-12:00','123','Rp 900.000',NULL,NULL,'double',NULL,'2025-08-30 03:04:46','pesanan_diterima',NULL,'2025-08-30 10:04:46',NULL,NULL),
(14,'ORD-20250830-4121','12312312','123','123213','jok-mobil','antar-lokasi','1123','kain-oscar','kurangi-busa','123','2025-09-02','13:00-15:00','21','Rp 575.000','123',NULL,NULL,NULL,'2025-08-30 03:06:08','pesanan_diterima',NULL,'2025-08-30 10:06:08',NULL,NULL),
(15,'ORD-20250830-0972','12312312','123','123213','jok-mobil','antar-lokasi','1123','kain-oscar','kurangi-busa','123','2025-09-02','13:00-15:00','21','Rp 575.000','123',NULL,NULL,NULL,'2025-08-30 03:06:35','pesanan_diterima',NULL,'2025-08-30 10:06:35',NULL,NULL),
(16,'ORD-20250830-3028','12312312','3123213','123231','kursi-rumah','antar-lokasi','231321','kain-oscar','ganti-busa','123','2025-08-31','13:00-15:00','123','100000',NULL,'12312312',NULL,NULL,'2025-08-30 03:07:09','selesai','2025-08-30 03:54:46','2025-08-30 10:07:09',NULL,'231'),
(17,'ORD-20250830-1083','12312321','12312312','123123','jok-motor','antar-lokasi','123','kulit-sintetis','kurangi-busa','123','2025-09-01','10:00-12:00','123','1221','1231',NULL,NULL,NULL,'2025-08-30 03:15:26','selesai','2025-12-07 07:38:32','2025-08-30 10:15:26','a27a9d2a-3253-47f7-8622-c7d4a25a5684','Selesai');

/*Table structure for table `status_pengiriman` */

CREATE TABLE `status_pengiriman` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_order` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_user` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT NULL,
  `foto` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `penerima` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `status_pengiriman` */

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `id_role` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `foto` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `users` */

insert  into `users`(`id`,`nama`,`username`,`email`,`password`,`status`,`created_at`,`updated_at`,`email_verified_at`,`id_role`,`foto`) values 
('31d80e68-947e-4fa1-924f-150c73f086d1','ely cakep','cakep','elycakep@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-06-14 11:30:31','2022-06-14 11:30:31',NULL,'PELANGGAN',NULL),
('4a0f855b-8767-11ea-bede-f832e401uia8','Owner','owner','owner@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-03-19 13:49:02','2022-04-24 13:01:06','2022-03-19 13:49:09','OWNER',NULL),
('5a99a97b-d44a-4c14-8cc9-c02c5fd18f38','riskavmh','riskavmh','riska.vmh@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','1','2022-06-10 08:45:34','2022-06-10 08:45:34',NULL,'PELANGGAN',NULL),
('76caf1ff-59e6-4722-b05a-d2b9eb91bafc','Ahmad Muhammad','ahmad','ahmad@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-05-01 21:38:17',NULL,NULL,'PELANGGAN',NULL),
('958757ae-2bba-4216-bacc-3b5baf3ef85e','Fatimah Azzahra','fatimah','fatimah@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-06-06 15:20:13','2022-06-06 15:20:13',NULL,'PELANGGAN',NULL),
('a27a9d2a-3253-47f7-8622-c7d4a25a5684','Adira Sahara','adira','adira@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-05-01 21:30:52',NULL,NULL,'PELANGGAN',NULL),
('c703b854-1e0e-4dd4-b7ef-77af72c3775a','dewi','dewi','dewi@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-06-14 11:48:03',NULL,NULL,'ADMIN',NULL),
('da1b1f5f-2d3e-4bbb-9a3a-c4ae88809ac3','Ahmad Maulana','maulana','maulana@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-05-30 02:31:44','2022-05-30 02:31:44',NULL,'PELANGGAN',NULL),
('fae99e16-c361-4cc5-b58e-a4ab0a2bd453','Akbar Putra Pratama','akbar','akbar@gmail.com','e10adc3949ba59abbe56e057f20f883e','1','2022-06-08 13:58:01','2022-06-08 13:58:01',NULL,'PELANGGAN',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
