<?php
/**
 * product.php - Ürün Detay ve Gelişmiş Analiz Dosyası
 */
require_once 'config.php';
require_once 'harmful_ingredients.php';

// JSON çıktı ayarı
header('Content-Type: application/json; charset=utf-8');

// Barkod veya ürün adı parametresini al
$arama = $_GET['barcode'] ?? $_GET['search'] ?? '';

if (empty($arama)) {
    echo json_encode(['hata' => 'Barkod veya ürün adı parametresi gerekli'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // 1. Ürünü veritabanından çek (Barkod tam eşleşme veya isim benzerliği)
    $stmt = $pdo->prepare("
        SELECT 
            u.id,
            u.barkod,
            u.isim,
            u.icerik,
            u.gorsel_url,
            k.isim as kategori_adi
        FROM urunler u
        LEFT JOIN kategoriler k ON u.kategori_id = k.id
        WHERE u.barkod = ? OR u.isim LIKE ?
        ORDER BY CASE WHEN u.barkod = ? THEN 1 ELSE 2 END
        LIMIT 1
    ");
    $stmt->execute([$arama, '%' . $arama . '%', $arama]);
    $urun = $stmt->fetch();

    if (!$urun) {
        echo json_encode(['hata' => 'Ürün bulunamadı'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2. İçerikleri merkezi fonksiyona göndererek parçala
    // Bu fonksiyon parantez içindeki özel durumları (virgülleri) yönetir
    $icerikler = parseIngredients($urun['icerik']);

    // 3. Riskli içerikleri merkezi kütüphaneden (harmful_ingredients.php) tara
    // Bu işlem hem tam eşleşmeleri hem de E-kodlarını otomatik tespit eder
    $riskli_icerikler = detectHarmfulIngredients($icerikler);

    // 4. Sağlık Skoru Hesaplama (LLM algoritması benzeri mantık)
    $toplam_icerik = count($icerikler);
    $riskli_sayisi = count($riskli_icerikler);
    $riskli_oran = $toplam_icerik > 0 ? $riskli_sayisi / $toplam_icerik : 0;
    
    // Skor: 0 (en riskli) ile 100 (en sağlıklı) arası
    $genel_skor = round((1 - $riskli_oran) * 100);
    
    // Eğer içerik hiç yoksa orta puan ver, eğer her şey riskliyse 0 ver
    if ($toplam_icerik == 0) $genel_skor = 50;

    // 5. Arayüzün (index.html) beklediği formatta JSON döndür
    $response = [
        'urun_adi' => $urun['isim'],
        'marka' => '', // Tabloda marka sütunu eklenirse buraya bağlanabilir
        'kategori' => $urun['kategori_adi'] ?? 'Genel',
        'gorsel_url' => $urun['gorsel_url'] ?? '',
        'genel_skor' => $genel_skor,
        'skor_aciklama' => $genel_skor >= 70 ? 'İyi' : ($genel_skor >= 40 ? 'Orta' : 'Düşük'),
        'icerikler' => array_values($icerikler),
        'riskli_icerikler' => $riskli_icerikler
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch(PDOException $e) {
    echo json_encode(['hata' => 'Veritabanı hatası: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>