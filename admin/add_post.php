<?php
session_start();
require_once '../includes/db.php';

// Kiểm tra đăng nhập
if(!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $type = $_POST['type'];
    
    // Xử lý upload ảnh
    $images = [];
    if(isset($_FILES['images'])) {
        $upload_dir = '../uploads/';
        foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['images']['name'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $new_file_name = uniqid() . '.' . $file_ext;
            
            if(move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
                $images[] = $new_file_name;
            }
        }
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO properties (title, description, price, area, address, bedrooms, bathrooms, type, images, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$title, $description, $price, $area, $address, $bedrooms, $bathrooms, $type, json_encode($images)]);
        
        header('Location: dashboard.php');
        exit();
    } catch(PDOException $e) {
        $error = "Lỗi: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài đăng mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="add_post.php">Thêm bài đăng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <h2 class="mb-4">Thêm bài đăng mới</h2>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Giá (VNĐ)</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Diện tích (m²)</label>
                            <input type="number" class="form-control" id="area" name="area" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="bedrooms" class="form-label">Số phòng ngủ</label>
                            <input type="number" class="form-control" id="bedrooms" name="bedrooms" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="bathrooms" class="form-label">Số phòng tắm</label>
                            <input type="number" class="form-control" id="bathrooms" name="bathrooms" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Loại bất động sản</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="apartment">Căn hộ</option>
                                <option value="house">Nhà riêng</option>
                                <option value="land">Đất</option>
                                <option value="commercial">Thương mại</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="images" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Thêm bài đăng</button>
                        <a href="dashboard.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 