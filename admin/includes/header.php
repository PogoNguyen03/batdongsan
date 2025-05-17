<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../includes/db.php';

// Kiểm tra đăng nhập và role admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$page_name = isset($page_name) ? $page_name : basename($_SERVER['PHP_SELF'], '.php');
$stmt = $pdo->prepare("SELECT * FROM seo_settings WHERE page = ?");
$seo = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seo['title'] ?? 'Tên website mặc định'; ?></title>
    <meta name="description" content="<?php echo $seo['description'] ?? 'Mô tả website mặc định'; ?>">
    <meta name="keywords" content="<?php echo $seo['keywords'] ?? 'bat dong san, nha dat, mua ban, cho thue'; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 6rem 0 0;
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
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .main-content {
            margin-top: 6rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
            <div class="d-flex">
                <span class="navbar-text me-3">
                    Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light">Đăng xuất</a>
            </div>
        </div>
    </nav>
</body>
</html> 