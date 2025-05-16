<?php
require_once '../includes/header.php';
require_once '../includes/db.php';

// Lấy các tham số lọc từ GET
$keyword = $_GET['keyword'] ?? '';
$type = $_GET['type'] ?? '';
$price_range = $_GET['price_range'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$min_area = $_GET['min_area'] ?? '';
$max_area = $_GET['max_area'] ?? '';

// Xây dựng câu truy vấn động
$sql = "SELECT * FROM properties WHERE 1";
$params = [];

if ($keyword !== '') {
    $sql .= " AND title LIKE ?";
    $params[] = '%' . $keyword . '%';
}
if ($type !== '') {
    $sql .= " AND type = ?";
    $params[] = $type;
}
if ($price_range !== '') {
    list($min, $max) = explode('-', $price_range);
    $sql .= " AND price >= ? AND price <= ?";
    $params[] = $min;
    $params[] = $max;
}

// Thêm lọc theo min_price và max_price
if ($min_price !== '') {
    $sql .= " AND price >= ?";
    $params[] = $min_price;
}
if ($max_price !== '') {
    $sql .= " AND price <= ?";
    $params[] = $max_price;
}

// Thêm lọc diện tích nếu muốn
if ($min_area !== '') {
    $sql .= " AND area >= ?";
    $params[] = $min_area;
}
if ($max_area !== '') {
    $sql .= " AND area <= ?";
    $params[] = $max_area;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$properties = $stmt->fetchAll();
?>

<div class="container mt-5">
    <div class="row">
        <!-- Bộ lọc -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bộ lọc</h5>
                    <form method="GET" action="">
                        <div class="mb-3">
                            <label class="form-label">Loại bất động sản</label>
                            <select name="type" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="apartment" <?php echo $type === 'apartment' ? 'selected' : ''; ?>>Căn hộ</option>
                                <option value="house" <?php echo $type === 'house' ? 'selected' : ''; ?>>Nhà riêng</option>
                                <option value="land" <?php echo $type === 'land' ? 'selected' : ''; ?>>Đất</option>
                                <option value="commercial" <?php echo $type === 'commercial' ? 'selected' : ''; ?>>Thương mại</option>
                            </select>
                        </div>
                        <!-- <div class="mb-3">
                            <label class="form-label">Giá (triệu)</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="min_price" class="form-control" placeholder="Từ" value="<?php echo $min_price; ?>">
                                </div>
                                <div class="col">
                                    <input type="number" name="max_price" class="form-control" placeholder="Đến" value="<?php echo $max_price; ?>">
                                </div>
                            </div>
                        </div> -->
                        <div class="mb-3">
                            <label class="form-label">Diện tích (m²)</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="min_area" class="form-control" placeholder="Từ" value="<?php echo $min_area; ?>">
                                </div>
                                <div class="col">
                                    <input type="number" name="max_area" class="form-control" placeholder="Đến" value="<?php echo $max_area; ?>">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách bất động sản -->
        <div class="col-md-9">
            <h1 class="mb-4">Danh Sách Bất Động Sản</h1>
            <?php if (empty($properties)): ?>
                <div class="alert alert-info">
                    Không tìm thấy bất động sản nào phù hợp với tiêu chí tìm kiếm.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($properties as $property): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <?php
                                $images = json_decode($property['images'] ?? '[]', true);
                                $first_image = $images[0] ?? 'default.jpg';
                                ?>
                                <img src="../uploads/<?php echo htmlspecialchars($first_image); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($property['title']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                                    <p class="card-text">
                                        <strong>Giá:</strong> <?php echo number_format($property['price']); ?> triệu<br>
                                        <strong>Diện tích:</strong> <?php echo $property['area']; ?> m²<br>
                                        <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($property['address']); ?>
                                    </p>
                                    <a href="products/view.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?> 