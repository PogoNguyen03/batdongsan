<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/seo_functions.php';

// Kiểm tra đăng nhập và role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$page_name = isset($page_name) ? $page_name : basename($_SERVER['PHP_SELF'], '.php');
$stmt = $pdo->prepare("SELECT * FROM seo_settings WHERE page = ?");
$seo = $stmt->fetch();

// Xác định loại trang hiện tại
$current_page = 'admin';
$address = '';

// Lấy SEO settings cho trang hiện tại
$seo = get_seo_settings($current_page, $address);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - ' : ''; ?>Quản trị</title>
    <meta name="description" content="<?php echo $seo['description'] ?? 'Mô tả website mặc định'; ?>">
    <meta name="keywords" content="<?php echo $seo['keywords'] ?? 'bat dong san, nha dat, mua ban, cho thue'; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="icon" href="/assets/img/logo.ico" type="image/x-icon">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 2rem 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #f8f9fa;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .main-content {
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="ms-auto">
                        <span class="navbar-text me-3">
                            Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                        <a href="/" class="btn btn-outline-primary me-2" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i> Xem website
                        </a>
                        <a href="/admin/logout.php" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</body>

</html>