<?php
/**
 * product.php - Ürün Detay ve Gelişmiş Analiz Dosyası
 */
require_once 'config.php';
require_once 'harmful_ingredients.php';

// JSON çıktı ayarı
header('Content-Type: application/json; charset=utf-8');

// Gelen parametreleri al
$barcode = $_GET['barcode'] ?? '';
$name = $_GET['name'] ?? '';

if (empty($barcode) && empty($name)) {
    echo json_encode(['hata' => 'Barkod veya ürün adı parametresi gerekli'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // 1. Ürünü veritabanından ara
    $sql = "SELECT u.*, k.isim as kategori_adi 
            FROM urunler u 
            LEFT JOIN kategoriler k ON u.kategori_id = k.id 
            WHERE ";
    
    $params = [];
    
    if (!empty($barcode)) {
        $sql .= "TRIM(u.barkod) = ?";
        $params[] = trim($barcode);
    } else {
        // İsim araması - LIKE ile kısmi eşleşme
        $sql .= "TRIM(u.isim) LIKE ?";
        $params[] = '%' . trim($name) . '%';
    }
    
    $sql .= " LIMIT 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
   
    $urun = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$urun) {
        echo json_encode(['hata' => 'Ürün bulunamadı'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2. İçindekileri parse et (virgülle ayrılmış)
   // ... (Veritabanı sorgusundan hemen sonrası)

// 2. İçindekileri parse et
// product.php içinde ilgili bölüm:

// 2. İçindekileri parse et
$icerikler = [];
if (!empty($urun['icerik'])) {
    // harmful_ingredients.php içindeki, parantezleri KORUYAN fonksiyonu çağırıyoruz
    $icerikler = parseIngredients($urun['icerik']);
}

// 3. Zararlı içerikleri tespit et
$riskli_verisi = detectHarmfulIngredients($icerikler);

// 4. UI için riskli içerikleri metne dönüştür
$riskli_isimler_ve_nedenler = [];
foreach ($riskli_verisi as $risk) {
    $riskli_isimler_ve_nedenler[] = $risk['isim'] . " (" . $risk['zarar_nedeni'] . ")";
}

// 5. Sağlık Skorunu hesapla
$genel_skor = calculateWeightedHealthScore($riskli_verisi);

// 6. Özel Sağlık Uyarıları (Çocuk ve Hamile)
$saglik_uyarilari = getHealthWarnings($riskli_verisi);

// 7. Yanıtı hazırla
$response = [
    'urun_adi' => $urun['isim'],
    'kategori' => $urun['kategori_adi'] ?? 'Genel',
    'gorsel_url' => $urun['gorsel_url'] ?? '',
    'genel_skor' => $genel_skor,
    'skor_aciklama' => $genel_skor >= 70 ? 'İyi' : ($genel_skor >= 40 ? 'Orta' : 'Düşük'),
    'icerikler' => $icerikler, // BURASI: parseIngredients sayesinde tam liste gelecek
    'riskli_icerikler' => $riskli_isimler_ve_nedenler,
    'saglik_uyarilari' => $saglik_uyarilari, // Yeni eklenen alan
    'alerjen' => $urun['alerjen'] ?? '',
    'barkod' => $urun['barkod']
];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo json_encode(['hata' => 'Veritabanı hatası: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>