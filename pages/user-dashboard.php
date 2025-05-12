<?php
session_start();
require_once '../includes/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: /admin/login.php");
    exit();
}

// Lấy thông tin user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Lấy danh sách bất động sản đã lưu
$stmt = $pdo->prepare("
    SELECT p.* 
    FROM properties p 
    INNER JOIN saved_properties sp ON p.id = sp.property_id 
    WHERE sp.user_id = ?
    ORDER BY sp.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$saved_properties = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bất Động Sản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-circle display-1"></i>
                            <h5 class="mt-3"><?php echo htmlspecialchars($user['full_name']); ?></h5>
                            <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action active">
                                <i class="bi bi-house-door me-2"></i> Bất động sản đã lưu
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="bi bi-gear me-2"></i> Cài đặt tài khoản
                            </a>
                            <a href="/admin/logout.php" class="list-group-item list-group-item-action text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bất động sản đã lưu</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($saved_properties)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-bookmark-x display-1 text-muted"></i>
                                <p class="mt-3">Bạn chưa lưu bất động sản nào</p>
                                <a href="/pages/list.php" class="btn btn-primary">Xem danh sách bất động sản</a>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($saved_properties as $property): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100">
                                            <?php 
                                            $images = json_decode($property['images'], true);
                                            $first_image = $images[0] ?? 'default.jpg';
                                            ?>
                                            <img src="/uploads/<?php echo $first_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title']); ?>" style="height: 200px; object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                                                <p class="card-text text-danger fw-bold"><?php echo number_format($property['price']); ?> VNĐ</p>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($property['address']); ?><br>
                                                    <i class="bi bi-arrows-angle-expand"></i> <?php echo $property['area']; ?> m²
                                                </p>
                                                <div class="d-flex justify-content-between">
                                                    <a href="/products/view.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                                                    <button class="btn btn-outline-danger remove-saved" data-id="<?php echo $property['id']; ?>">
                                                        <i class="bi bi-bookmark-dash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Xử lý xóa bất động sản đã lưu
        document.querySelectorAll('.remove-saved').forEach(button => {
            button.addEventListener('click', function() {
                const propertyId = this.dataset.id;
                if (confirm('Bạn có chắc muốn xóa bất động sản này khỏi danh sách đã lưu?')) {
                    // Gửi request xóa
                    fetch('/api/remove-saved.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            property_id: propertyId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.col-md-6').remove();
                        } else {
                            alert('Có lỗi xảy ra khi xóa bất động sản');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html> 