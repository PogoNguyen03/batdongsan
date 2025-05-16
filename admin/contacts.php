<?php
$page_name = 'contacts';
require_once 'includes/header.php';
require_once '../includes/db.php';
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Xử lý xóa liên hệ
if (isset($_POST['delete_contact'])) {
    $contact_id = $_POST['contact_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$contact_id]);
        $success_message = "Đã xóa liên hệ thành công!";
    } catch (PDOException $e) {
        $error_message = "Có lỗi xảy ra khi xóa liên hệ!";
    }
}

// Lấy danh sách liên hệ
try {
    $stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Có lỗi xảy ra khi lấy danh sách liên hệ!";
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quản lý liên hệ</h1>
            </div>

            <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Nội dung</th>
                                    <th>Ngày gửi</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($contacts) && !empty($contacts)): ?>
                                    <?php foreach ($contacts as $contact): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($contact['id']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['message']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($contact['created_at'])); ?></td>
                                            <td>
                                                <form method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?');">
                                                    <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                                    <button type="submit" name="delete_contact" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Không có liên hệ nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 