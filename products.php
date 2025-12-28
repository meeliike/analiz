<?php
require_once 'config.php';

header('Content-Type: application/json; charset=utf-8');

$category_id = $_GET['category_id'] ?? '';

if (empty($category_id)) {
    echo json_encode(['hata' => 'Kategori ID gerekli'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Kategori ID sayısal mı kontrol et
    if (is_numeric($category_id)) {
        $sql = "
            SELECT 
                u.barkod,
                u.isim,
                u.gorsel_url,
                k.isim as kategori_adi
            FROM urunler u
            LEFT JOIN kategoriler k ON u.kategori_id = k.id
            WHERE u.kategori_id = ?
            ORDER BY u.isim ASC
        ";
    } else {
        // Sayısal değilse isme göre ara (örn: "Çikolata")
        $sql = "
            SELECT 
                u.barkod,
                u.isim,
                u.gorsel_url,
                k.isim as kategori_adi
            FROM urunler u
            LEFT JOIN kategoriler k ON u.kategori_id = k.id
            WHERE k.isim = ?
            ORDER BY u.isim ASC
        ";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id]);
    $urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'basari' => true,
        'urunler' => $urunler
    ], JSON_UNESCAPED_UNICODE);

} catch(PDOException $e) {
    echo json_encode([
        'basari' => false,
        'hata' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
