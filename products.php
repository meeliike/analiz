<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Kategori ID parametresini al
$kategori_id = $_GET['category_id'] ?? '';

if (empty($kategori_id)) {
    echo json_encode(['basari' => false, 'hata' => 'Kategori ID parametresi gerekli'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Seçili kategorideki ürünleri çek
    $stmt = $pdo->prepare("
        SELECT 
            u.id,
            u.barkod,
            u.isim,
            u.gorsel_url,
            k.isim as kategori_adi
        FROM urunler u
        LEFT JOIN kategoriler k ON u.kategori_id = k.id
        WHERE u.kategori_id = ?
        ORDER BY u.isim ASC
    ");
    $stmt->execute([$kategori_id]);
    $urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'basari' => true,
        'urunler' => $urunler
    ], JSON_UNESCAPED_UNICODE);

} catch(PDOException $e) {
    echo json_encode(['basari' => false, 'hata' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>

