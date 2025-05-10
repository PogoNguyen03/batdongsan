<?php
require_once '../includes/header.php';

if(!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->execute([$id]);
$property = $stmt->fetch();

if(!$property) {
    header('Location: ../index.php');
    exit();
}

$images = json_decode($property['images'], true);
?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="../list.php">Danh sách bất động sản</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($property['title']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Image Gallery -->
        <div class="col-md-8">
            <div id="propertyCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach($images as $index => $image): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="../uploads/<?php echo $image; ?>" class="d-block w-100" alt="Property Image" style="height: 500px; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Thumbnail Gallery -->
            <div class="row">
                <?php foreach($images as $index => $image): ?>
                    <div class="col-3 mb-3">
                        <img src="../uploads/<?php echo $image; ?>" class="img-thumbnail" alt="Thumbnail" 
                             onclick="$('#propertyCarousel').carousel(<?php echo $index; ?>)" 
                             style="height: 100px; object-fit: cover; cursor: pointer;">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Property Details -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h2>
                    <h3 class="text-danger mb-4"><?php echo number_format($property['price']); ?> VNĐ</h3>
                    
                    <div class="mb-4">
                        <h4>Thông tin chi tiết</h4>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($property['address']); ?></li>
                            <li><i class="bi bi-arrows-angle-expand"></i> Diện tích: <?php echo $property['area']; ?> m²</li>
                            <li><i class="bi bi-door-open"></i> Số phòng ngủ: <?php echo $property['bedrooms']; ?></li>
                            <li><i class="bi bi-droplet"></i> Số phòng tắm: <?php echo $property['bathrooms']; ?></li>
                            <li><i class="bi bi-building"></i> Loại: 
                                <?php
                                $types = [
                                    'apartment' => 'Căn hộ',
                                    'house' => 'Nhà riêng',
                                    'land' => 'Đất',
                                    'commercial' => 'Thương mại'
                                ];
                                echo $types[$property['type']] ?? $property['type'];
                                ?>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4>Mô tả</h4>
                        <p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" onclick="showContactForm()">
                            <i class="bi bi-telephone"></i> Liên hệ ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Liên hệ tư vấn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showContactForm() {
    var modal = new bootstrap.Modal(document.getElementById('contactModal'));
    modal.show();
}

document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Xử lý gửi form ở đây
    alert('Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể!');
    bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
});
</script>

<?php require_once '../includes/footer.php'; ?> 