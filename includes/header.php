<?php
session_start();
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bất Động Sản - Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">Bất Động Sản</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/home.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/list.php">Danh sách bất động sản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/about.php">Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/pages/contact.php">Liên hệ</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <?php if(isset($_SESSION['admin_logged_in'])): ?>
                            <a href="/admin/dashboard.php" class="btn btn-primary me-2">Quản trị</a>
                            <a href="/admin/logout.php" class="btn btn-outline-danger">Đăng xuất</a>
                        <?php else: ?>
                            <a href="/admin/login.php" class="btn btn-outline-primary">Đăng nhập</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container py-4"> 