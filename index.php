<?php
require_once 'includes/header.php';

// Lấy danh sách bất động sản mới nhất
$stmt = $pdo->query("SELECT * FROM properties ORDER BY created_at DESC LIMIT 12");
$properties = $stmt->fetchAll();
?>

<div class="container">
    <!-- Banner Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-dark text-white">
                <img src="assets/images/banner.jpg" class="card-img" alt="Banner" style="height: 400px; object-fit: cover;">
                <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                    <h1 class="card-title">Tìm Kiếm Bất Động Sản Mơ Ước</h1>
                    <p class="card-text">Hàng ngàn bất động sản chất lượng đang chờ bạn</p>
                    <div class="mt-3">
                        <a href="list.php" class="btn btn-primary btn-lg">Xem Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="list.php" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm theo từ khóa...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="type">
                                <option value="">Loại bất động sản</option>
                                <option value="apartment">Căn hộ</option>
                                <option value="house">Nhà riêng</option>
                                <option value="land">Đất</option>
                                <option value="commercial">Thương mại</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="price_range">
                                <option value="">Khoảng giá</option>
                                <option value="0-1000000000">Dưới 1 tỷ</option>
                                <option value="1000000000-2000000000">1 - 2 tỷ</option>
                                <option value="2000000000-5000000000">2 - 5 tỷ</option>
                                <option value="5000000000-10000000000">5 - 10 tỷ</option>
                                <option value="10000000000-999999999999">Trên 10 tỷ</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Properties -->
    <h2 class="mb-4">Bất Động Sản Mới Nhất</h2>
    <div class="row">
        <?php foreach($properties as $property): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php 
                    $images = json_decode($property['images'], true);
                    $first_image = $images[0] ?? 'default.jpg';
                    ?>
                    <img src="uploads/<?php echo $first_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title']); ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                        <p class="card-text text-danger fw-bold"><?php echo number_format($property['price']); ?> VNĐ</p>
                        <p class="card-text">
                            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($property['address']); ?><br>
                            <i class="bi bi-arrows-angle-expand"></i> <?php echo $property['area']; ?> m²
                        </p>
                        <a href="products/view.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 