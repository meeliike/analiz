<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Örnek haberler (gerçek uygulamada veritabanından çekilebilir)
$haberler = [
    [
        'gorsel' => 'https://img.freepik.com/free-photo/cafe-interior-design_1232-1232.jpg',
        'baslik' => 'Popüler Kahve Zinciri Şubelerini Kapattı!',
        'icerik' => 'Ünlü kahve zinciri, artan maliyetler ve azalan müşteri sayısı nedeniyle Türkiye genelinde 12 şubesini kapatma kararı aldı. Çalışanlar ani karar karşısında şaşkın.',
        'tarih' => '2025-01-25'
    ],
    [
        'gorsel' => 'https://img.freepik.com/free-photo/shawarma-wrap-cutting-board-with-spices_787273-34.jpg',
        'baslik' => 'Meşhur Tantuni Dükkanı Kapatıldı: Nedeni Şok Etti!',
        'icerik' => 'Müşterilerin yoğun şikayetleri sonrası yapılan denetimde hijyen kurallarının ihlal edildiği tespit edilen Tantuni King, cezalar sonrası kapılarını kapatmak zorunda kaldı.',
        'tarih' => '2025-01-20'
    ],
    [
        'gorsel' => 'https://img.freepik.com/free-photo/sweet-honey-jar-burlap-background_1232-2273.jpg',
        'baslik' => 'Sahte Bal Skandalı: Ünlü Marka Raflardan Çekildi!',
        'icerik' => 'Gıda kontrol ekipleri, bilinen bir markanın ballarında glikoz şurubu tespit etti. Ürünler piyasadan toplatılırken firma büyük itibar kaybetti.',
        'tarih' => '2025-01-18'
    ],
    [
        'gorsel' => 'https://img.freepik.com/free-photo/factory-interior-with-machines_1232-34.jpg',
        'baslik' => 'Gıda Güvenliği Yönetmeliği Güncellendi',
        'icerik' => 'Türkiye\'de gıda güvenliği yönetmeliği yeni kurallarla güncellendi. Üreticiler artık daha sıkı kontrollere tabi tutulacak.',
        'tarih' => '2025-01-15'
    ],
    [
        'gorsel' => 'https://img.freepik.com/free-photo/organic-products-market_1232-5678.jpg',
        'baslik' => 'Organik Gıda Talebi Artıyor',
        'icerik' => 'Son dönemde tüketicilerin organik gıda ürünlerine olan ilgisi %30 arttı. Uzmanlar bu trendin devam edeceğini söylüyor.',
        'tarih' => '2025-01-12'
    ],
    [
        'gorsel' => 'https://img.freepik.com/free-photo/slice-cake-with-coffee-beans-background_1232-999.jpg',
        'baslik' => '80 Yıllık Pastane Kapanıyor: Mahalleli Tepkili!',
        'icerik' => 'Şehrin simgesi haline gelen ünlü pastane, artan enerji maliyetleri nedeniyle kapatma kararı aldı. Mahalle sakinleri kampanya başlattı.',
        'tarih' => '2025-01-09'
    ],
    [
        'gorsel' => 'https://img.freepik.com/free-photo/supermarket-products-cart_1232-888.jpg',
        'baslik' => 'Rekabet Kurulu İncelemesi: Market Zinciri Mercek Altında',
        'icerik' => 'Uygun Marketler zincirinin fiyat oyunları yaptığı iddiası gündeme bomba gibi düştü. Raf fiyatlarının değişim hızına vatandaşlar tepki gösterdi.',
        'tarih' => '2025-01-06'
    ]
];

// Rastgele bir haber seç
$rastgele_haber = $haberler[array_rand($haberler)];

echo json_encode([
    'basari' => true,
    'haber' => $rastgele_haber
], JSON_UNESCAPED_UNICODE);
?>
