<?php
require_once '../../includes/header.php';
require_once '../../includes/db.php';
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

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

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $property_id = $_POST['property_id'] ?? null;

    // Validate input
    if (empty($name)) {
        $error = 'Vui lòng nhập họ và tên';
    } elseif (empty($email)) {
        $error = 'Vui lòng nhập email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ';
    } elseif (empty($phone)) {
        $error = 'Vui lòng nhập số điện thoại';
    } elseif (empty($message)) {
        $error = 'Vui lòng nhập nội dung tin nhắn';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, message, property_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $message, $property_id]);
            
            // Gửi email thông báo
            $to = SMTP_FROM_EMAIL;
            $subject = "Liên hệ mới từ website bất động sản";
            $email_message = "Có liên hệ mới từ website:\n\n";
            $email_message .= "Họ và tên: " . $name . "\n";
            $email_message .= "Email: " . $email . "\n";
            $email_message .= "Số điện thoại: " . $phone . "\n";
            $email_message .= "Nội dung: " . $message . "\n";
            if ($property_id) {
                $email_message .= "Bất động sản: " . $property['title'] . "\n";
            }
            
            sendEmail($to, $subject, $email_message);
            $success = true;
            
            // Clear form data after successful submission
            $_POST = array();
        } catch (PDOException $e) {
            $error = 'Có lỗi xảy ra, vui lòng thử lại sau';
        }
    }
}
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
            <div id="propertyCarousel" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach($images as $index => $image): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="../../uploads/<?php echo $image; ?>" class="d-block w-100" alt="Property Image" style="height: 100%; object-fit: cover;">
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
                        <img src="../../uploads/<?php echo $image; ?>" class="img-thumbnail" alt="Thumbnail" 
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
                    <!-- <h3 class="text-danger mb-4"><?php echo number_format($property['price']); ?> VNĐ</h3> -->
                    
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
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Thành công!</strong> Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Lỗi!</strong> <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" id="contactForm">
                    <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" required
                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" rows="3" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="contact_submit" class="btn btn-primary">
                            <i class="bi bi-send-fill me-2"></i>Gửi yêu cầu
                        </button>
                    </div>
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

// Xóa event listener cũ vì chúng ta đã xử lý form submission bằng PHP
document.getElementById('contactForm').removeEventListener('submit', function(e) {
    e.preventDefault();
});

// Thêm code để tự động đóng modal sau khi gửi thành công
<?php if ($success): ?>
    setTimeout(function() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
        if (modal) {
            modal.hide();
        }
    }, 2000); // Đóng modal sau 2 giây
<?php endif; ?>
</script>

<?php require_once '../../includes/footer.php'; ?> 