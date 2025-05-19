<?php
require_once '../includes/header.php';

// Lấy danh sách bất động sản mới nhất
$stmt = $pdo->query("SELECT * FROM properties ORDER BY created_at DESC LIMIT 12");
$properties = $stmt->fetchAll();
?>

<div class="container">
    <!-- Banner Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../assets/img/banner1.webp?=1" class="d-block w-100" alt="Banner 1"
                            style="height: 500px; object-fit: cover;">
                        <!-- <div class="carousel-caption d-none d-md-block">
                            <h1 class="display-4 fw-bold">Tìm Kiếm Bất Động Sản Mơ Ước</h1>
                            <p class="lead">Hàng ngàn bất động sản chất lượng đang chờ bạn</p>
                            <a href="list.php" class="btn btn-primary btn-lg mt-3">Xem Ngay</a>
                        </div> -->
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/banner2.webp?=1" class="d-block w-100" alt="Banner 2"
                            style="height: 500px; object-fit: cover;">
                        <!-- <div class="carousel-caption d-none d-md-block">
                            <h1 class="display-4 fw-bold">Đầu Tư Thông Minh</h1>
                            <p class="lead">Cơ hội đầu tư bất động sản với tiềm năng sinh lời cao</p>
                            <a href="list.php" class="btn btn-primary btn-lg mt-3">Khám Phá Ngay</a>
                        </div> -->
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/banner3.webp?=1" class="d-block w-100" alt="Banner 3"
                            style="height: 500px; object-fit: cover;">
                        <!-- <div class="carousel-caption d-none d-md-block">
                            <h1 class="display-4 fw-bold">Tư Vấn Chuyên Nghiệp</h1>
                            <p class="lead">Đội ngũ chuyên gia tư vấn giàu kinh nghiệm</p>
                            <a href="contact.php" class="btn btn-primary btn-lg mt-3">Liên Hệ Ngay</a>
                        </div> -->
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
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
                            <input type="text" class="form-control" name="keyword"
                                placeholder="Tìm kiếm theo từ khóa...">
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
                        <!-- <div class="col-md-3">
                            <select class="form-select" name="price_range">
                                <option value="">Khoảng giá</option>
                                <option value="0-1000000000">Dưới 1 tỷ</option>
                                <option value="1000000000-2000000000">1 - 2 tỷ</option>
                                <option value="2000000000-5000000000">2 - 5 tỷ</option>
                                <option value="5000000000-10000000000">5 - 10 tỷ</option>
                                <option value="10000000000-999999999999">Trên 10 tỷ</option>
                            </select>
                        </div> -->
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
        <?php foreach ($properties as $property): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php
                    $images = json_decode($property['images'], true);
                    $first_image = $images[0] ?? 'default.jpg';
                    ?>
                    <a href="../products/view.php?id=<?php echo $property['id']; ?>" class="text-decoration-none">
                        <img src="../uploads/<?php echo $first_image; ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($property['title']); ?>"
                            style="height: 200px; object-fit: cover;"></a>
                    <div class="card-body">
                        <a href="../products/view.php?id=<?php echo $property['id']; ?>" class="text-decoration-none">
                            <h5 class="card-title text-dark"><?php echo htmlspecialchars($property['title']); ?></h5>
                        </a>
                        <!-- <p class="card-text text-danger fw-bold"><?php echo number_format($property['price']); ?> VNĐ</p> -->
                        <p class="card-text">
                            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($property['address']); ?><br>
                            <i class="bi bi-arrows-angle-expand"></i> <?php echo $property['area']; ?> m²
                        </p>
                        <a href="../products/view.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">Xem chi
                            tiết</a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>