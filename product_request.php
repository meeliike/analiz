<?php
/**
 * Ürün Talep/Moderasyon Sistemi
 * Kullanıcıların ürün talebi göndermesi ve admin onayı
 */

require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Sadece POST istekleri kabul edilir'], JSON_UNESCAPED_UNICODE);
    exit;
}

// JSON veriyi al
$input = json_decode(file_get_contents('php://input'), true);

$barcode = $input['barcode'] ?? '';
$product_name = $input['product_name'] ?? '';
$brand = $input['brand'] ?? '';
$user_note = $input['user_note'] ?? '';
$ingredients = $input['ingredients'] ?? '';

if (empty($barcode)) {
    echo json_encode(['success' => false, 'message' => 'Barkod alanı zorunludur'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // product_requests tablosunu oluştur (yoksa)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS product_requests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            barcode VARCHAR(50) NOT NULL,
            product_name VARCHAR(255),
            brand VARCHAR(100),
            user_note TEXT,
            ingredients TEXT,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            reviewed_at TIMESTAMP NULL,
            reviewed_by VARCHAR(100) NULL,
            admin_note TEXT NULL,
            INDEX idx_barcode (barcode),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    
    // Aynı barkod için bekleyen istek var mı kontrol et
    $stmt = $pdo->prepare("
        SELECT id FROM product_requests 
        WHERE barcode = ? AND status = 'pending'
        LIMIT 1
    ");
    $stmt->execute([$barcode]);
    $existing_request = $stmt->fetch();
    
    if ($existing_request) {
        echo json_encode([
            'success' => true,
            'message' => 'Bu barkod için zaten bekleyen bir talebiniz bulunmaktadır.',
            'request_id' => $existing_request['id']
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Yeni talep kaydet
    $stmt = $pdo->prepare("
        INSERT INTO product_requests (barcode, product_name, brand, user_note, ingredients) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$barcode, $product_name, $brand, $user_note, $ingredients]);
    $request_id = $pdo->lastInsertId();
    
    echo json_encode([
        'success' => true,
        'message' => 'Ürün talebiniz başarıyla gönderildi. Değerlendirilmek üzere moderator onayına sunuldu.',
        'request_id' => $request_id
    ], JSON_UNESCAPED_UNICODE);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Veritabanı hatası: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
