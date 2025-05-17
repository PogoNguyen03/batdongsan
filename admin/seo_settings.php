<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/db.php';
require_once 'includes/auth_check.php';

$page_title = "Quản lý SEO";
require_once 'includes/header.php';

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page_type = $_POST['page_type'];
    $title = $_POST['title'];
    $keywords = $_POST['keywords'];
    $description = $_POST['description'];

    $sql = "UPDATE seo_settings SET title = ?, keywords = ?, description = ? WHERE page_type = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$title, $keywords, $description, $page_type])) {
        $success_message = "Cập nhật SEO thành công!";
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật SEO!";
    }
}

// Lấy danh sách SEO settings
$sql = "SELECT * FROM seo_settings ORDER BY page_type";
$stmt = $pdo->query($sql);
$seo_settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
        <h1 class="h3 mb-4 text-gray-800">Quản lý SEO</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cài đặt SEO</h6>
            </div>
            <div class="card-body">
                <?php foreach ($seo_settings as $row): ?>
                    <form method="POST" class="mb-4">
                        <input type="hidden" name="page_type" value="<?php echo htmlspecialchars($row['page_type']); ?>">

                        <div class="form-group">
                            <label>Loại trang</label>
                            <input type="text" class="form-control"
                                value="<?php echo htmlspecialchars($row['page_type']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Tiêu đề (Title)</label>
                            <input type="text" name="title" class="form-control"
                                value="<?php echo htmlspecialchars($row['title']); ?>" required>
                            <small class="form-text text-muted">Sử dụng {address} để chèn địa chỉ vào tiêu đề (chỉ áp dụng
                                cho trang chi tiết)</small>
                        </div>

                        <div class="form-group">
                            <label>Từ khóa (Keywords)</label>
                            <textarea name="keywords" class="form-control" rows="3"
                                required><?php echo htmlspecialchars($row['keywords']); ?></textarea>
                            <small class="form-text text-muted">Sử dụng {address} để chèn địa chỉ vào từ khóa (chỉ áp dụng
                                cho trang chi tiết)</small>
                        </div>

                        <div class="form-group">
                            <label>Mô tả (Description)</label>
                            <textarea name="description" class="form-control" rows="3"
                                required><?php echo htmlspecialchars($row['description']); ?></textarea>
                            <small class="form-text text-muted">Sử dụng {address} để chèn địa chỉ vào mô tả (chỉ áp dụng cho
                                trang chi tiết)</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</div>

<?php require_once 'includes/footer.php'; ?>