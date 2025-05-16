<?php
$page_name = 'Liên hệ';
require_once '../includes/header.php';
require_once '../includes/db.php';
require_once '../includes/config.php';
require_once '../includes/functions.php';

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
            
            // Gửi email thông báo
            $to = SMTP_FROM_EMAIL;
            $subject = "Liên hệ mới từ website bất động sản";
            $email_message = "Có liên hệ mới từ website:\n\n";
            $email_message .= "Họ và tên: " . $name . "\n";
            $email_message .= "Email: " . $email . "\n";
            $email_message .= "Số điện thoại: " . $phone . "\n";
            $email_message .= "Nội dung: " . $message . "\n";
            
            sendEmail($to, $subject, $email_message);
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
                    Gửi thông tin thành công!
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
                    <label for="message" class="form-label">Nội dung (Ví dụ: Nhà tại Quận 7, diện tích 60m2, giá 4-5 tỷ)</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2 class="mb-4">Thông Tin Liên Hệ</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Môi giới bất động sản Nguyễn Cảnh Phong</h5>
                    <p class="card-text">
                        <strong>Địa chỉ:</strong> 1041/80/6A Trần Xuân Soạn, P. Tân Hưng, Q. 7, TP. HCM<br>
                        <strong>Điện thoại:</strong> 0774 651 178<br>
                        <strong>Email:</strong> nguyencanhphong135@gmail.com<br>
                        <strong>Giờ làm việc:</strong> 8:00 - 19:00 (Thứ 2 - CN)
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.8170202252923!2d106.69413899999998!3d10.74858140000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f0983d9f1e7%3A0x5974e2a812fdddd!2zMTA0MS84MC8yMCBUcuG6p24gWHXDom4gU2_huqFuLCBUw6JuIEjGsG5nLCBRdeG6rW4gNywgSOG7kyBDaMOtIE1pbmggNzAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1747382629086!5m2!1svi!2s"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>