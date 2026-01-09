-- Tabel untuk menyimpan laporan kerusakan furniture
CREATE TABLE `damage_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `damage_type` enum('struktural','finishing','upholstery','hardware','lainnya') NOT NULL,
  `damage_description` text NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `warranty_claim` tinyint(1) DEFAULT 0,
  `damage_photos` text DEFAULT NULL COMMENT 'JSON array of photo filenames',
  `report_date` datetime NOT NULL,
  `status` enum('pending','in_progress','completed','cancelled') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `repair_cost` decimal(10,2) DEFAULT NULL,
  `completion_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_customer_name` (`customer_name`),
  KEY `idx_status` (`status`),
  KEY `idx_report_date` (`report_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data (optional)
INSERT INTO `damage_reports` (`customer_name`, `phone_number`, `product_name`, `damage_type`, `damage_description`, `purchase_date`, `warranty_claim`, `report_date`, `status`) VALUES
('John Doe', '081234567890', 'Kursi Kantor Ergonomis', 'struktural', 'Roda kursi patah dan tidak bisa berputar dengan baik', '2024-01-15', 1, '2024-02-20 10:30:00', 'completed'),
('Jane Smith', '082345678901', 'Meja Makan Kayu Jati', 'finishing', 'Cat permukaan meja mengelupas di beberapa bagian', '2023-12-10', 0, '2024-02-21 14:45:00', 'in_progress'),
('Robert Johnson', '083456789012', 'Sofa 3 Dudukan', 'upholstery', 'Kain sofa sobek di bagian samping dan busa mulai kempes', '2024-01-05', 1, '2024-02-22 09:15:00', 'pending');
