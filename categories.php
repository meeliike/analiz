<?php

require_once 'config.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Debug: Veritabanı bağlantısını kontrol et
    if (!$pdo) {
        throw new Exception('Veritabanı bağlantısı yok');
    }

    // LEFT JOIN sayesinde boş olsa bile tüm kategoriler listelenir
    $stmt = $pdo->prepare("
        SELECT
            k.id,
            k.isim,
            COUNT(u.id) as urun_sayisi
        FROM kategoriler k
        LEFT JOIN urunler u ON k.id = u.kategori_id
        GROUP BY k.id, k.isim
        ORDER BY k.isim ASC
    ");

    $stmt->execute();
    $kategoriler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Sonuçları logla
    error_log('Kategoriler: ' . print_r($kategoriler, true));

    echo json_encode([
        'basari' => true,
        'kategoriler' => $kategoriler,
        'debug' => 'Toplam kategori: ' . count($kategoriler)
    ], JSON_UNESCAPED_UNICODE);

} catch(PDOException $e) {
    error_log('Categories PHP Hata: ' . $e->getMessage());
    echo json_encode([
        'basari' => false, 
        'hata' => $e->getMessage(),
        'debug' => 'PDO Exception'
    ], JSON_UNESCAPED_UNICODE);
} catch(Exception $e) {
    error_log('Categories Geniş Hata: ' . $e->getMessage());
    echo json_encode([
        'basari' => false, 
        'hata' => $e->getMessage(),
        'debug' => 'General Exception'
    ], JSON_UNESCAPED_UNICODE);
}
?>