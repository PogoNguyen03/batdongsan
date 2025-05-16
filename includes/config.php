<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'batdongsan');
define('DB_USER', 'root');
define('DB_PASS', '');

// Email configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'nguyencanhphong135@gmail.com');
define('SMTP_PASSWORD', 'pswohiikrmnmzqnb'); // Hướng dẫn lấy App Password:
                            // 1. Vào https://myaccount.google.com/security
                            // 2. Bật "Xác minh 2 bước" nếu chưa bật
                            // 3. Vào https://myaccount.google.com/apppasswords
                            // 4. Chọn "Ứng dụng" là "Khác (Tên tùy chỉnh)"
                            // 5. Đặt tên là "Bất Động Sản Website"
                            // 6. Nhấn "Tạo"
                            // 7. Copy mật khẩu 16 ký tự và dán vào đây
                            // Lưu ý: Không sử dụng mật khẩu Gmail thông thường
define('SMTP_FROM_EMAIL', 'nguyencanhphong135@gmail.com');
define('SMTP_FROM_NAME', 'Bất Động Sản');

// Site configuration
define('SITE_NAME', 'Bất Động Sản');
define('SITE_URL', 'http://localhost/batdongsan');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1); 