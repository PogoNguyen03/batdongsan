<?php
require_once __DIR__ . '/db.php';

function get_seo_settings($page_type, $address = '') {
    global $conn;
    
    if (!$conn) {
        // Trả về giá trị mặc định nếu không có kết nối database
        return [
            'title' => 'Bất Động Sản',
            'keywords' => 'Bất Động Sản, nhà đất, môi giới bất động sản',
            'description' => 'Bất Động Sản'
        ];
    }
    
    $sql = "SELECT * FROM seo_settings WHERE page_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $page_type);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Thay thế {address} bằng địa chỉ thực tế nếu có
        if (!empty($address)) {
            $row['title'] = str_replace('{address}', $address, $row['title']);
            $row['keywords'] = str_replace('{address}', $address, $row['keywords']);
            $row['description'] = str_replace('{address}', $address, $row['description']);
        }
        return $row;
    }
    
    // Trả về giá trị mặc định nếu không tìm thấy
    return [
        'title' => 'Bất Động Sản',
        'keywords' => 'Bất Động Sản, nhà đất, môi giới bất động sản',
        'description' => 'Bất Động Sản'
    ];
} 