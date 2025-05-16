<?php
$page_name = 'dashboard';
require_once 'includes/header.php';
require_once '../includes/db.php';

// Kiểm tra đăng nhập và role admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Lấy danh sách bài đăng
$stmt = $pdo->query("SELECT * FROM properties ORDER BY created_at DESC");
$properties = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quản lý bất động sản</h1>
                <a href="add_post.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Thêm bài đăng mới
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Giá</th>
                                    <th>Diện tích</th>
                                    <th>Ngày đăng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($properties as $property): ?>
                                <tr>
                                    <td><?php echo $property['id']; ?></td>
                                    <td><?php echo htmlspecialchars($property['title']); ?></td>
                                    <td><?php echo number_format($property['price']); ?> VNĐ</td>
                                    <td><?php echo $property['area']; ?> m²</td>
                                    <td><?php echo date('d/m/Y', strtotime($property['created_at'])); ?></td>
                                    <td>
                                        <a href="edit_post.php?id=<?php echo $property['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete_post.php?id=<?php echo $property['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
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