<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Örnek haberler (gerçek uygulamada veritabanından çekilebilir)
$haberler = [
    [
        'baslik' => 'Gıda Güvenliği Yönetmeliği Güncellendi',
        'icerik' => 'Türkiye\'de gıda güvenliği yönetmeliği yeni kurallarla güncellendi. Üreticiler artık daha sıkı kontrollere tabi tutulacak.',
        'tarih' => '2025-01-15'
    ],
    [
        'baslik' => 'Organik Gıda Talebi Artıyor',
        'icerik' => 'Son dönemde tüketicilerin organik gıda ürünlerine olan ilgisi %30 arttı. Uzmanlar bu trendin devam edeceğini söylüyor.',
        'tarih' => '2025-01-12'
    ],
    [
        'baslik' => 'Gıda Etiketleme Kuralları Değişti',
        'icerik' => 'Yeni düzenlemelerle birlikte ürün etiketlerinde daha detaylı bilgi bulunması zorunlu hale geldi.',
        'tarih' => '2025-01-10'
    ],
    [
        'baslik' => 'Yapay Zeka ile Gıda Analizi',
        'icerik' => 'Teknoloji şirketleri, yapay zeka destekli gıda analiz sistemleri geliştiriyor. Bu sistemler tüketicilere daha hızlı bilgi sağlıyor.',
        'tarih' => '2025-01-08'
    ],
    [
        'baslik' => 'Beslenme Uzmanları Uyarıyor',
        'icerik' => 'Uzmanlar, paketli gıdalardaki katkı maddelerinin dikkatli tüketilmesi gerektiğini vurguluyor.',
        'tarih' => '2025-01-05'
    ],
    [
        'baslik' => 'Gıda İsrafını Önleme Kampanyası',
        'icerik' => 'Yeni kampanya ile gıda israfının azaltılması hedefleniyor. Tüketiciler bilinçlendirilecek.',
        'tarih' => '2025-01-03'
    ]
];

// Rastgele bir haber seç
$rastgele_haber = $haberler[array_rand($haberler)];

echo json_encode([
    'basari' => true,
    'haber' => $rastgele_haber
], JSON_UNESCAPED_UNICODE);
?>

