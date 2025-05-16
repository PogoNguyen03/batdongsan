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
    <title>Bất Động Sản - Trang chủ</title>
    <meta name="keywords"
        content="Bất Động Sản, Trang chủ, Bất động sản, nhà đất, môi giới bất động sản, TP. Hồ Chí Minh">
    <meta name="description" content="Bất Động Sản - Trang chủ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" href="/assets/img/logo.ico" type="image/x-icon">
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