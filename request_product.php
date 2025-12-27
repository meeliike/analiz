<?php
/**
 * Ürün Kayıt İsteği Endpoint
 * Kullanıcıların veritabanında olmayan ürünler için kayıt isteği göndermesi
 */

require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['basari' => false, 'hata' => 'Sadece POST istekleri kabul edilir'], JSON_UNESCAPED_UNICODE);
    exit;
}

// JSON veya form data'dan veri al
$input = json_decode(file_get_contents('php://input'), true);
$barkod = $input['barcode'] ?? $_POST['barcode'] ?? '';
$urun_adi = $input['product_name'] ?? $_POST['product_name'] ?? '';
$kullanici_notu = $input['note'] ?? $_POST['note'] ?? '';

if (empty($barkod)) {
    echo json_encode(['basari' => false, 'hata' => 'Barkod parametresi gerekli'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Veritabanında ürün kayıt istekleri tablosu oluştur (yoksa)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS urun_kayit_istekleri (
            id INT AUTO_INCREMENT PRIMARY KEY,
            barkod VARCHAR(50) NOT NULL,
            urun_adi VARCHAR(255),
            kullanici_notu TEXT,
            durum ENUM('beklemede', 'işleniyor', 'tamamlandı', 'reddedildi') DEFAULT 'beklemede',
            olusturma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_barkod (barkod),
            INDEX idx_durum (durum)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    
    // Aynı barkod için bekleyen istek var mı kontrol et
    $stmt = $pdo->prepare("
        SELECT id FROM urun_kayit_istekleri 
        WHERE barkod = ? AND durum = 'beklemede'
        LIMIT 1
    ");
    $stmt->execute([$barkod]);
    $mevcut_istek = $stmt->fetch();
    
    if ($mevcut_istek) {
        echo json_encode([
            'basari' => true,
            'mesaj' => 'Bu barkod için zaten bekleyen bir kayıt isteği bulunmaktadır.',
            'istek_id' => $mevcut_istek['id']
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Yeni istek kaydet
    $stmt = $pdo->prepare("
        INSERT INTO urun_kayit_istekleri (barkod, urun_adi, kullanici_notu) 
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$barkod, $urun_adi, $kullanici_notu]);
    $istek_id = $pdo->lastInsertId();
    
    echo json_encode([
        'basari' => true,
        'mesaj' => 'Ürün kayıt isteği başarıyla gönderildi. En kısa sürede veritabanına eklenecektir.',
        'istek_id' => $istek_id
    ], JSON_UNESCAPED_UNICODE);
    
} catch(PDOException $e) {
    echo json_encode([
        'basari' => false,
        'hata' => 'Veritabanı hatası: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>

