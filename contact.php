<?php
require_once 'includes/header.php';
require_once 'includes/db.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $property_id = $_POST['property_id'] ?? null;

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $error = 'Vui lòng điền đầy đủ thông tin';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, message, property_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $message, $property_id]);
            $success = true;
        } catch (PDOException $e) {
            $error = 'Có lỗi xảy ra, vui lòng thử lại sau';
        }
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4">Liên Hệ</h1>
            <?php if ($success): ?>
                <div class="alert alert-success">
                    Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể.
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2 class="mb-4">Thông Tin Liên Hệ</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Công Ty Bất Động Sản ABC</h5>
                    <p class="card-text">
                        <strong>Địa chỉ:</strong> 123 Đường ABC, Quận XYZ, TP. HCM<br>
                        <strong>Điện thoại:</strong> (028) 1234 5678<br>
                        <strong>Email:</strong> info@batdongsan.local<br>
                        <strong>Giờ làm việc:</strong> 8:00 - 17:30 (Thứ 2 - Thứ 6)
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4241674816727!2d106.6986!3d10.7756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTDCsDQ2JzMyLjEiTiAxMDbCsDQxJzU0LjkiRQ!5e0!3m2!1svi!2s!4v1234567890" 
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?> 