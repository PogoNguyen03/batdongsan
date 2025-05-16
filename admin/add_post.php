<?php
$page_name = 'add_post';
require_once 'includes/header.php';
require_once '../includes/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $area = trim($_POST['area']);
    $address = trim($_POST['location']);
    $bedrooms = trim($_POST['bedrooms']);
    $bathrooms = trim($_POST['bathrooms']);
    $type = trim($_POST['type']);
    
    // Validate input
    if(empty($title) || empty($description) || empty($price) || empty($area) || empty($address)) {
        $error = "Vui lòng điền đầy đủ thông tin bắt buộc";
    } else {
        // Xử lý upload ảnh
        $images = [];
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = '../uploads/';
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    $error = "Không thể tạo thư mục upload";
                }
            }
            
            if (empty($error)) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    // Kiểm tra loại file
                    $fileType = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));
                    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
                    
                    if (!in_array($fileType, $allowedTypes)) {
                        $error = "Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF)";
                        break;
                    }
                    
                    $fileName = time() . '_' . $_FILES['images']['name'][$key];
                    $uploadFile = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($tmp_name, $uploadFile)) {
                        $images[] = $fileName;
                    } else {
                        $error = "Không thể upload file " . $_FILES['images']['name'][$key];
                        break;
                    }
                }
            }
        }
        
        if (empty($error)) {
            $imagesJson = json_encode($images);
            
            try {
                $stmt = $pdo->prepare("INSERT INTO properties (title, description, price, area, address, bedrooms, bathrooms, type, images, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$title, $description, $price, $area, $address, $bedrooms, $bathrooms, $type, $imagesJson]);
                
                $success = "Đăng bài thành công!";
                // Chuyển hướng sau 2 giây
                header("refresh:2;url=dashboard.php");
            } catch(PDOException $e) {
                $error = "Lỗi: " . $e->getMessage();
            }
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Thêm bài đăng mới</h1>
            </div>

            <?php if($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" required value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="area" class="form-label">Diện tích (m²) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="area" name="area" required value="<?php echo isset($_POST['area']) ? htmlspecialchars($_POST['area']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" required value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="bedrooms" class="form-label">Số phòng ngủ <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="bedrooms" name="bedrooms" required value="<?php echo isset($_POST['bedrooms']) ? htmlspecialchars($_POST['bedrooms']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="bathrooms" class="form-label">Số phòng tắm <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms" required value="<?php echo isset($_POST['bathrooms']) ? htmlspecialchars($_POST['bathrooms']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Loại bất động sản <span class="text-danger">*</span></label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="house" <?php echo (isset($_POST['type']) && $_POST['type'] == 'house') ? 'selected' : ''; ?>>Nhà ở</option>
                                    <option value="apartment" <?php echo (isset($_POST['type']) && $_POST['type'] == 'apartment') ? 'selected' : ''; ?>>Căn hộ</option>
                                    <option value="land" <?php echo (isset($_POST['type']) && $_POST['type'] == 'land') ? 'selected' : ''; ?>>Đất</option>
                                    <option value="commercial" <?php echo (isset($_POST['type']) && $_POST['type'] == 'commercial') ? 'selected' : ''; ?>>Thương mại</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="images" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            <div class="form-text">Có thể chọn nhiều ảnh (JPG, JPEG, PNG, GIF)</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Đăng bài</button>
                        <a href="dashboard.php" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 