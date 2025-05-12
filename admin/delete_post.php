<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/db.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit();
}

try {
    $stmt = $pdo->prepare('DELETE FROM properties WHERE id = ?');
    $stmt->execute([$id]);
} catch (PDOException $e) {
    // Có thể log lỗi nếu cần
}
header('Location: dashboard.php');
exit(); 