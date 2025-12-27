<?php
require_once 'config.php';

// POST veya GET ile ürün ID veya barkod alınabilir
$barkod = $_POST['barcode'] ?? $_GET['barcode'] ?? '';

if (empty($barkod)) {
    echo json_encode(['hata' => 'Barkod parametresi gerekli'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Ürünü veritabanından çek
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
        WHERE u.barkod = ?
    ");
    $stmt->execute([$barkod]);
    $urun = $stmt->fetch();

    if (!$urun) {
        echo json_encode(['hata' => 'Ürün bulunamadı'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // İçerikleri parse et
    $icerikler = [];
    if (!empty($urun['icerik'])) {
        $decoded = json_decode($urun['icerik'], true);
        $icerikler = $decoded ? $decoded : explode(',', $urun['icerik']);
        $icerikler = array_map('trim', $icerikler);
        $icerikler = array_filter($icerikler);
    }

    // Riskli maddeler sözlüğü
    $zarar_sozlugu = [
        'E150d' => 'Kanserojen risk taşır',
        'E621' => 'Alerjen tetikleyici, migren yapabilir',
        'E951' => 'Yapay tatlandırıcı, sindirim sorunlarına yol açabilir',
        'E211' => 'Koruyucu madde, alerji riski',
        'E250' => 'Nitrit, kanser riski taşır',
        'E251' => 'Nitrat, kanser riski taşır',
        'Trans yağ' => 'Kalp hastalıkları riskini artırır',
        'Trans Yağ' => 'Kalp hastalıkları riskini artırır',
        'Fruktoz şurubu' => 'Obezite ve diyabet riski',
        'Fruktoz Şurubu' => 'Obezite ve diyabet riski',
        'Aspartam' => 'Nörolojik sorunlara yol açabilir',
        'MSG' => 'Alerjen tetikleyici, migren yapabilir'
    ];

    // Riskli içerikleri tespit et
    $riskli_icerikler = [];
    foreach ($icerikler as $icerik) {
        if (isset($zarar_sozlugu[$icerik])) {
            $riskli_icerikler[] = [
                'isim' => $icerik,
                'zarar_nedeni' => $zarar_sozlugu[$icerik]
            ];
        } else {
            foreach ($zarar_sozlugu as $riskli_madde => $zarar) {
                if (stripos($icerik, $riskli_madde) !== false) {
                    $riskli_icerikler[] = [
                        'isim' => $icerik,
                        'zarar_nedeni' => $zarar
                    ];
                    break;
                }
            }
        }
    }

    // LLM benzeri skor hesaplama (gelişmiş algoritma)
    // Riskli madde oranına göre skor hesapla
    $toplam_icerik = count($icerikler);
    $riskli_sayisi = count($riskli_icerikler);
    $riskli_oran = $toplam_icerik > 0 ? $riskli_sayisi / $toplam_icerik : 0;
    
    // Skor hesaplama: Riskli oranına göre 0-100 arası puan
    $genel_skor = round((1 - $riskli_oran) * 100);
    
    // Eğer hiç içerik yoksa veya tüm içerikler riskliyse özel durumlar
    if ($toplam_icerik == 0) {
        $genel_skor = 50; // Bilinmeyen durum
    } elseif ($riskli_oran == 1) {
        $genel_skor = 0; // Tüm içerikler riskli
    }

    // Analiz sonucu
    $response = [
        'barkod' => $urun['barkod'],
        'urun_adi' => $urun['isim'],
        'kategori' => $urun['kategori_adi'] ?? '',
        'toplam_icerik_sayisi' => $toplam_icerik,
        'riskli_icerik_sayisi' => $riskli_sayisi,
        'riskli_oran' => round($riskli_oran * 100, 2),
        'genel_skor' => $genel_skor,
        'skor_aciklama' => $genel_skor >= 70 ? 'İyi' : ($genel_skor >= 40 ? 'Orta' : 'Düşük'),
        'riskli_icerikler' => $riskli_icerikler,
        'tarih' => date('Y-m-d H:i:s')
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch(PDOException $e) {
    echo json_encode(['hata' => 'Veritabanı hatası: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>
