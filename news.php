<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Örnek haberler (gerçek uygulamada veritabanından çekilebilir)
$haberler = [
    [
        'gorsel' => 'https://productimages.hepsiburada.net/s/777/375-375/110000814802596.jpg',
        'baslik' => 'Marketlerde Satılan Bazı Cipsler Toplatılıyor',
        'icerik' => 'Tarım ve Orman Bakanlığı, yapılan analizler sonucunda bazı cips markalarında sağlığa zararlı katkı maddeleri tespit edildiğini açıkladı. Ürünler raflardan toplatılmaya başlandı.',
        'tarih' => '2025-02-03'
    ],
    [
        'gorsel' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSE6vtWSdnxpzFODOMrDvCplOHQPa3Hih_5sA&s',
        'baslik' => 'Enerji İçeceklerine Yeni Yaş Sınırı Geliyor',
        'icerik' => 'Uzmanların uyarıları sonrası enerji içeceklerinin 18 yaş altına satışının sınırlandırılması için yeni bir düzenleme hazırlandı.',
        'tarih' => '2025-02-10'
    ],
    [
        'gorsel' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTzlxge6fx7SEC7QQ1yXStOgbqaRWUv6sz9Mg&s',
        'baslik' => 'Paketli Süt Ürünlerinde Etiket Denetimi Artırıldı',
        'icerik' => 'Tüketiciyi yanıltıcı etiketlere karşı başlatılan denetimlerde, bazı süt ürünlerinin içeriği ile etiket bilgilerinin uyuşmadığı tespit edildi.',
        'tarih' => '2025-02-15'
    ],
    [
        'gorsel' => 'https://www.paktuz.com/wp-content/uploads/2019/11/tuz-2-2560x1280.jpeg',
        'baslik' => 'Hazır Gıdalarda Tuz Oranı Alarm Veriyor',
        'icerik' => 'Yapılan araştırmalara göre hazır çorbalar ve paketli soslarda önerilen günlük tuz miktarının çok üzerinde değerler bulunuyor.',
        'tarih' => '2025-02-22'
    ],
    
    [
        'gorsel'=> 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtn3g6G_Q-tCG4jT901NZTZIXDNwCte2SKOA&s',
        'baslik' => 'Meşhur Tantuni Dükkanı Kapatıldı: Nedeni Şok Etti!',
        'icerik' => 'Müşterilerin yoğun şikayetleri sonrası yapılan denetimde hijyen kurallarının ihlal edildiği tespit edilen Tantuni King, cezalar sonrası kapılarını kapatmak zorunda kaldı.',
        'tarih' => '2025-01-20'
    ],
    [
        'gorsel' => 'https://www.acarsut.com.tr/idea/ev/01/myassets/blogs/gercek-bal.png?revision=1678361686',
        'baslik' => 'Sahte Bal Skandalı: Ünlü Marka Raflardan Çekildi!',
        'icerik' => 'Gıda kontrol ekipleri, bilinen bir markanın ballarında glikoz şurubu tespit etti. Ürünler piyasadan toplatılırken firma büyük itibar kaybetti.',
        'tarih' => '2025-01-18'
    ],
    [
        'gorsel' => 'https://www.adalet.tv/resimler/arsiv/2021/06/yargi-sistemimizde-kanunlar-kac-kez-degisti.webp',
        'baslik' => 'Gıda Güvenliği Yönetmeliği Güncellendi',
        'icerik' => 'Türkiye\'de gıda güvenliği yönetmeliği yeni kurallarla güncellendi. Üreticiler artık daha sıkı kontrollere tabi tutulacak.',
        'tarih' => '2025-01-15'
    ],
    [
        'gorsel' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCjcRqL4Ujmvcr6k-G75X_XwvkQBlIrTaw_A&s',
        'baslik' => 'Organik Gıda Talebi Artıyor',
        'icerik' => 'Son dönemde tüketicilerin organik gıda ürünlerine olan ilgisi %30 arttı. Uzmanlar bu trendin devam edeceğini söylüyor.',
        'tarih' => '2025-01-12'
    ],
    [
        'gorsel' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGbgcsk6cPUTI3eIOMopuGzvHd5naoOSdxvg&s',
        'baslik' => '80 Yıllık Pastane Kapanıyor: Mahalleli Tepkili!',
        'icerik' => 'Şehrin simgesi haline gelen ünlü pastane, artan enerji maliyetleri nedeniyle kapatma kararı aldı. Mahalle sakinleri kampanya başlattı.',
        'tarih' => '2025-01-09'
    ],
    [
        'gorsel' => 'https://tekce.net/files/upload/images/marketicgorsel1.jpg',
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