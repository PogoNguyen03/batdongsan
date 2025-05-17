<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyên Bán Nhà Đất Sổ Đỏ TP.HCM</title>
    <meta name="keywords"
        content="bán nhà sổ đỏ TP.HCM, nhà đất chính chủ quận 7, mua bán nhà đất quận 4, nhà sổ đỏ Nhà Bè, môi giới nhà đất uy tín, Nguyễn Cảnh Phong, bất động sản TP.HCM, nhà phố sổ hồng, nhà đất quận 8, nhà giá tốt HCM, nhà chính chủ">
    <meta name="description"
        content="Nguyễn Cảnh Phong - Môi giới bất động sản chuyên bán nhà đất chính chủ, sổ đỏ, pháp lý rõ ràng tại Quận 7, Quận 4, Quận 8 và Nhà Bè, TP.HCM. Cam kết tư vấn tận tâm, hỗ trợ xem nhà miễn phí.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="http://batdongsan.local/pages/about.php" />
    <link rel="publisher" href="http://batdongsan.local" />
    <link rel="author" href="http://batdongsan.local/pages/about.php" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" href="/assets/img/logo.ico" type="image/x-icon">
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Nguyễn Cảnh Phong",
        "jobTitle": "Nhân viên môi giới bất động sản",
        "url": "http://batdongsan.local",
        "image": "http://batdongsan.local/assets/img/logo.webp",
        "worksFor": {
            "@type": "Organization",
            "name": "Bất Động Sản Tư Nhân"
        },
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Quận 7, Quận 4, Quận 8, Nhà Bè",
            "addressRegion": "TP. Hồ Chí Minh",
            "addressCountry": "VN"
        },
        "description": "Nguyễn Cảnh Phong là môi giới bất động sản chuyên bán nhà đất sổ đỏ tại TP.HCM, khu vực Quận 7, Quận 4, Quận 8 và Nhà Bè.",
        "sameAs": [
            "https://www.facebook.com/share/15LLfMkqvJ/",
            "https://zalo.me/0774651178",
            "http://batdongsan.local/pages/about.php"
        ]
        }
    </script>

</head>

<body>
    <header class="header-wrapper">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="/assets/img/logo.webp" alt="Logo" style="height: 36px;" class="me-2">
                    <span class="brand-text fw-bold">Bất Động Sản</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/home.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/list.php">Danh sách</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/about.php">Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/contact.php">Liên hệ</a>
                        </li>
                    </ul>
                    <div class="nav-buttons">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <a href="/admin/dashboard.php" class="btn btn-primary me-2">Quản trị</a>
                            <?php else: ?>
                                <a href="/pages/user-dashboard.php" class="btn btn-primary me-2">Tài khoản</a>
                            <?php endif; ?>
                            <a href="/admin/logout.php" class="btn btn-outline">Đăng xuất</a>
                        <?php else: ?>
                            <a href="/admin/login.php" class="btn btn-outline">Đăng nhập</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="main-content">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Xử lý hiệu ứng scroll
            window.addEventListener('scroll', function () {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Xử lý active menu item
            document.addEventListener('DOMContentLoaded', function () {
                const currentLocation = window.location.pathname;
                const navLinks = document.querySelectorAll('.nav-link');

                navLinks.forEach(link => {
                    if (link.getAttribute('href') === currentLocation) {
                        link.classList.add('active');
                    }
                });
            });
        </script>