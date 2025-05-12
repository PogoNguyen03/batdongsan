<?php
session_start();
require_once '../includes/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);
$property_id = $data['property_id'] ?? null;

if (!$property_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing property_id']);
    exit();
}

try {
    // Xóa bất động sản khỏi danh sách đã lưu
    $stmt = $pdo->prepare("DELETE FROM saved_properties WHERE user_id = ? AND property_id = ?");
    $result = $stmt->execute([$_SESSION['user_id'], $property_id]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to remove property']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
} 