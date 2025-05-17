CREATE TABLE IF NOT EXISTS `seo_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_type` (`page_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default values
INSERT INTO `seo_settings` (`page_type`, `title`, `keywords`, `description`) VALUES
('home', 'Bất Động Sản - Trang chủ', 'Bất Động Sản, Trang chủ, Bất động sản, nhà đất, môi giới bất động sản, TP. Hồ Chí Minh', 'Bất Động Sản - Trang chủ'),
('property_detail', '{address} - Bất Động Sản', 'Bất Động Sản, {address}, nhà đất, môi giới bất động sản', '{address} - Bất Động Sản'); 