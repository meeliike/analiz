<?php
require_once 'config.php';

header('Content-Type: application/json; charset=utf-8');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$barcode = $data['barcode'] ?? '';
$name = $data['name'] ?? '';
$category = $data['category'] ?? '';
$note = $data['note'] ?? '';

if (empty($barcode) || empty($name) || empty($category)) {
    echo json_encode(['success' => false, 'message' => 'Lütfen zorunlu alanları doldurun (Barkod, İsim, Kategori).']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO product_requests (barkod, isim, kategori, notlar) VALUES (?, ?, ?, ?)");
    $stmt->execute([$barcode, $name, $category, $note]);
    
    echo json_encode(['success' => true, 'message' => 'Talebiniz başarıyla alındı.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Veritabanı hatası: ' . $e->getMessage()]);
}
?>