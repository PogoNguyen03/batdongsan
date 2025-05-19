<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/db.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Lấy id bài đăng
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit();
}

// Lấy thông tin bài đăng
$stmt = $pdo->prepare('SELECT * FROM properties WHERE id = ?');
$stmt->execute([$id]);
$property = $stmt->fetch();
if (!$property) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $type = $_POST['type'];

    // Xử lý hình ảnh
    $images = json_decode($property['images'], true) ?: [];
    
    // Xử lý xóa ảnh
    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $delete_image) {
            // Xóa file ảnh từ thư mục uploads
            $file_path = '../uploads/' . $delete_image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            // Xóa ảnh khỏi mảng images
            $key = array_search($delete_image, $images);
            if ($key !== false) {
                unset($images[$key]);
            }
        }
        // Đánh lại index của mảng
        $images = array_values($images);
    }

    // Xử lý upload ảnh mới
    if (isset($_FILES['images']) && $_FILES['images']['name'][0] != '') {
        $upload_dir = '../uploads/';
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['images']['name'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            
            if (in_array($file_ext, $allowed_types)) {
                $new_file_name = uniqid() . '.' . $file_ext;
                if (move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
                    $images[] = $new_file_name;
                }
            }
        }
    }

    try {
        $stmt = $pdo->prepare('UPDATE properties SET title=?, description=?, price=?, area=?, address=?, bedrooms=?, bathrooms=?, type=?, images=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([$title, $description, $price, $area, $address, $bedrooms, $bathrooms, $type, json_encode($images), $id]);
        header('Location: dashboard.php');
        exit();
    } catch (PDOException $e) {
        $error = 'Lỗi: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài đăng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
            margin: 5px;
        }
        .image-preview img {
            height: 100px;
            width: 100px;
            object-fit: cover;
            border-radius: 4px;
        }
        .delete-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            cursor: pointer;
        }
        .delete-image:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
        </div>
    </nav>
    <div class="container py-4">
        <h2 class="mb-4">Chỉnh sửa bài đăng</h2>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?php echo htmlspecialchars($property['description']); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Giá (VNĐ)</label>
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo $property['price']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Diện tích (m²)</label>
                            <input type="number" class="form-control" id="area" name="area" value="<?php echo $property['area']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($property['address']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="bedrooms" class="form-label">Số phòng ngủ</label>
                            <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="<?php echo $property['bedrooms']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="bathrooms" class="form-label">Số phòng tắm</label>
                            <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="<?php echo $property['bathrooms']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Loại bất động sản</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="apartment" <?php if($property['type']==='apartment') echo 'selected'; ?>>Căn hộ</option>
                                <option value="house" <?php if($property['type']==='house') echo 'selected'; ?>>Nhà riêng</option>
                                <option value="land" <?php if($property['type']==='land') echo 'selected'; ?>>Đất</option>
                                <option value="commercial" <?php if($property['type']==='commercial') echo 'selected'; ?>>Thương mại</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh hiện tại</label>
                        <div class="d-flex flex-wrap">
                            <?php foreach(json_decode($property['images'], true) as $img): ?>
                                <div class="image-preview">
                                    <img src="../uploads/<?php echo $img; ?>" alt="" class="img-thumbnail">
                                    <div class="delete-image" onclick="toggleImageDelete('<?php echo $img; ?>')">
                                        <i class="bi bi-x"></i>
                                    </div>
                                    <input type="checkbox" name="delete_images[]" value="<?php echo $img; ?>" 
                                           id="delete_<?php echo $img; ?>" style="display: none;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Thêm hình ảnh mới</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                        <div class="form-text">Có thể chọn nhiều ảnh (JPG, JPEG, PNG, GIF)</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="dashboard.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleImageDelete(imageName) {
        const checkbox = document.getElementById('delete_' + imageName);
        const imagePreview = checkbox.parentElement;
        
        if (checkbox.checked) {
            checkbox.checked = false;
            imagePreview.style.opacity = '1';
        } else {
            checkbox.checked = true;
            imagePreview.style.opacity = '0.5';
        }
    }
    </script>
</body>
</html> 