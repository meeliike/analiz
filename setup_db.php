<?php
require_once 'config.php';

try {
    // Veritabanı bağlantı ayarları ve UTF-8 zorlaması
    $pdo->exec("SET NAMES utf8mb4");
    
    // Tabloları temizle
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("DROP TABLE IF EXISTS urunler;");
    $pdo->exec("DROP TABLE IF EXISTS kategoriler;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    // Tabloları oluştur
    $pdo->exec("CREATE TABLE kategoriler (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        isim VARCHAR(100) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    $pdo->exec("CREATE TABLE urunler (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        barkod VARCHAR(50) NOT NULL UNIQUE, 
        isim VARCHAR(255) NOT NULL, 
        icerik TEXT, 
        alerjen TEXT, 
        gorsel_url VARCHAR(255), 
        kategori_id INT, 
        FOREIGN KEY (kategori_id) REFERENCES kategoriler(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // Tüm Ürün Verileri (Optimize Edilmiş İçeriklerle)
    $veriler = [
        // Çikolata
        ['8683508143831', 'Ülker Çikolata İstanbul Fındıklı & Çıtır Kadayıflı 93 G', 'Şeker, Tam Yağlı Süttozu, Fındık (%10.3), Kakao Yağı, Kakao Kitlesi, Bitkisel Yağlar (Palm, Shea), Çıtır Kadayıf ve Baklava Parçacıkları, Peyniraltı Suyu Tozu (Süt), Yağsız Süttozu, Maltodekstrin, Emülgatör (Soya Lesitini), Tuz, Aroma Vericiler, Süt, fındık, Buğday, Yumurta, Gluten, Soya içerir.', 'https://images.migrosone.com/sanalmarket/product/07031385/07031385_1-739cf1-1650x1650.jpg', 'çikolata'],
        ['8690526076379', 'Eti Browni Intense Çikolatalı Kek 50 G', 'Kek (%52), Sütlü Çikolata (%29), Çikolatalı Krema (%17), Bitter Çikolata (%2) , Emülgatör (Soya Lesitini) , Aroma Vericiler (Vanilin) , Gluten , süt ürünü içerir . Eser miktarda yemiş içerebilir .', 'https://images.migrosone.com/sanalmarket/product/05098209/eti-browni-intense-50-gr-bb8473-1650x1650.jpg', 'çikolata'],
        ['7622201519544', 'Milka Çikolata Rüyası 100 G', 'Şeker, palm yağı, peynir altı suyu tozu, kakao yağı, fındık ezmesi, emülgatör (Soya Lesitini, E476), aroma vericiler.', 'Süt, soya, fındık.', 'https://images.migrosone.com/sanalmarket/product/07040550/7040550_1-8985e1-1650x1650.jpg', 'çikolata'],
        ['8690526016573', 'Eti Sütlü Çikolata Kaplı Fındık Kremalı Gofret 34 G', 'Fındıklı Krema (%46.9), Sütlü Çikolata (%33), Gofret Yaprağı (%20.1), Emülgatör (Soya Lesitini), Tuz.', 'Fındık Püresi, Süt Ürünü, Buğday Unu.', 'https://images.migrosone.com/sanalmarket/product/07167761/07167761-c603a5-1650x1650.jpg', 'çikolata'],
        ['8699270017638', 'Kahve Dünyası Tambol Antep Fıstıklı Sütlü Çikolata 77 G', 'Sütlü çikolata, Antep fıstığı (%25), emülgatör (Soya Lesitini), vanilya aroması.', 'Süt ürünü, Antep fıstığı.', 'https://images.migrosone.com/sanalmarket/product/07030583/7030583_1-ef40bb-1650x1650.jpg', 'çikolata'],
        ['8683417000270','Tadelle Fındık Dolgulu Sütlü Çikolata King Size 52 G' ,'Fındık Dolgulu Sütlü Çikolata (%75), Şeker, Fındık (%26), Kakao Yağı, Kakao Kitlesi, Süt Tozu.', 'Fındık, Süt Tozu, Peynir Altı Suyu.', 'https://images.migrosone.com/sanalmarket/product/07163345/tadelle-sutlu-cikolata-52-gr-f4034e-1650x1650.jpg','çikolata'],
        ['8681630410258', 'Züber %100 Fıstık Ezmeli Noutos 55 G', 'Nohut Unu (%37), Yer Fıstığı (%31), Pirinç İrmiği, Bal, Deniz Tuzu.', 'Yer Fıstığı içerir. Süt içerebilir.', 'https://images.migrosone.com/sanalmarket/product/08077438/08077438_1-2f0f9e-1650x1650.jpg', 'çikolata'],

        // Sakız
        ['8690840228362', 'Ülker Oneo Bubble Çilek & Muz Milkshake Aromalı Sakız', 'Şeker, sakız mayası, glukoz şurubu, aroma vericiler, renklendirici (E162), nem verici (Gliserol).', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07126236/07126236-d684d8-1650x1650.jpg', 'sakız'],
        ['8693323006419', 'Nazar Damla Sakızı Aromalı Şekersiz Sakız 3\'lü', 'Sakız mayası, aroma verici (damla sakızı), Antioksidan (BHT - E321), Tatlandırıcılar.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07120377/7120377-88257a-1650x1650.jpg', 'sakız'],
        ['080770848', 'Vivident 45Dk Cüzdan Çilek Aromalı Sakız 26 G', 'Tatlandırıcılar (Sorbitol, Maltitol, Aspartam E951, Asesülfam K), Sakız Mayası, Aroma Vericiler, Emülgatör (Soya Lesitini).', 'Soya Lesitini, Fenilalanin kaynağı içerir.', 'https://images.migrosone.com/sanalmarket/product/03500005/3500005-90eae1-1650x1650.jpg', 'sakız'],
        ['8690840229093', 'Ülker Pembo Karışık Meyve Aromalı Balonlu Sakız 22.5 G', 'Şeker, Sakız Mayası, Glukoz Şurubu, Nem Verici (Gliserol), Aroma Vericiler.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07120381/07120381-9d530c-1650x1650.jpg', 'sakız'],
        ['0622210753236', 'Tipitip Karışık Meyve Ve Mentol Aromalı Sakız 27 G', 'Tatlandırıcılar, Sakız Mayası, Nem Verici, Aroma Vericiler.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07120409/07120409-80c1fc-1650x1650.jpg', 'sakız'],

        // Yağ
        ['8699300272259', 'Komili Ayçiçek Yağı 5 L', 'Rafine ayçiçek yağı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04110062/4110062-5f2b02-1650x1650.jpg', 'yağ'],
        ['8684059741040', 'Aivalos Cızart Riviera Zeytinyağı 750 Ml', 'Rafine zeytinyağı, sızma zeytinyağı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04130283/04130283_1-8ba35e-1650x1650.jpg', 'yağ'],
        ['8693275002217', 'Çotanak Kare Pet Kanola Yağı 5 L', 'Kanola Yağı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04171016/04171016_1-7484a7-1650x1650.jpg', 'yağ'],
        ['8690876105583', 'Yudum Airfry\'a Özel Sprey Ayçiçek Yağı Cam 250 Ml', 'Ayçiçek Yağı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04110128/04110128-199be0-1650x1650.jpg', 'yağ'],
        ['8690565020814', 'Pınar Tereyağı 125 G', 'Pastörize inek sütü kreması, tereyağ kültürü.', 'Süt ve Süt ürünü içerir.', 'https://images.migrosone.com/sanalmarket/product/12010015/pinar-tereyagi-125-gr-f0ccfb-1650x1650.jpg', 'yağ'],

        // Bisküvi
        ['7622202312502','Oreo Classic 228 G','Buğday unu, şeker, bitkisel yağ (palm), yağı azaltılmış kakao tozu (%3.5), buğday nişastası, glukoz-fruktoz şurubu, emülgatör (Soya Lesitini).','Gluten ve Soya içerir. Süt içerebilir.','https://images.migrosone.com/sanalmarket/product/07028859/07028859_1-8717d5-1650x1650.jpg','bisküvi'],
        ['8690526063508','Eti Burçak Sütlü Çikolatalı Bisküvi 114 G','Buğday Unu, Tam Buğday Unu (%24), Sütlü Çikolata (%29), Bitkisel Yağ (Palm), Glukoz-Fruktoz Şurubu, Kabartıcılar.', 'Gluten içerir. Eser miktarda yemiş içerebilir.','https://images.migrosone.com/sanalmarket/product/7019931/7019931-041230-1650x1650.jpg','bisküvi'],
        ['8690526793184','Eti Nero Kakaolu Bisküvi 110 G','Buğday Unu, Kakaolu Krema (%20), Bitkisel Yağ (Palm), Şeker, Tam Yağlı Süt Tozu, Yağı Azaltılmış Kakao Tozu.', 'Gluten ve Süt ürünü içerir.','https://images.migrosone.com/sanalmarket/product/05041071/eti-nero-kakaolu-biskuvi-110-gr-0f3b43-1650x1650.jpg','bisküvi'],
        ['8690504083483','Ülker Saklıköy Çikolata Kremalı Bisküvi 87 G','Şeker, palm yağı, buğday unu, tam buğday unu (%11), yağı azaltılmış kakao tozu, süt tozu, kabartıcılar.', 'Gluten, süt, soya içerir.','https://images.migrosone.com/sanalmarket/product/07019731/07019731-d642e7-1650x1650.jpg','bisküvi'],
        ['8690766050078','Ülker Coco Star Atıştırmalık 154 G','Buğday unu, Hindistan cevizi (%4), Sütlü Çikolata, Şeker, Palm Yağı, Nem Verici (Sorbitol), Emülgatör.', 'Gluten, süt, sülfit içerir.','https://images.migrosone.com/sanalmarket/product/07013747/07013747-cc8696-1650x1650.jpg','bisküvi'],

        // Tuz
        ['8690771130925','BİLLUR TUZ 3 KG DENİZ TUZU','Rafine Deniz Tuzu (sodyum klorür), Topaklanmayı Önleyici (E536).','Alerjen içermez.','https://barkodist.com//assets/img/barkod/billur-tuz-rafine-iyotlu-sofra-tuzu-karton-tuzluk-125-g-barkodu.jpeg','tuz'],
        ['8681856394141','Mayi Tuz Öğütülmüş Sofra Tuzu 2 KG','%100 Doğal Kaynak Tuzu, Potasyum İyodat.', 'Alerjen içermez.','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgUXdaDr_EaSD2JhDcZBemNcsxPvl9lG3qIw&s','tuz'],

        // Meyve Suyu
        ['8690558005026','Dimes Cam Meyve Suyu 1 L Şeftali','Portakal Suyu, antioksidan (askorbik asit - E300). ','Alerjen içermez.','https://iet-cdn-003.akinsofteticaret.net/ebeymar.com/Resim/Minik/500x500_thumb_8690558005026.jpg','meyve suyu'],
        ['8690575871918','Tamek %100 Meyve Suyu 1 L Karışık','Su, Meyve suyu ve püre konsantreleri (Elma, Üzüm, Portakal, Kayısı, Ananas, Şeftali, Mango), Vitaminler (C, E, A), Asitlik Düzenleyici (Sitrik Asit).','Alerjen içermez.','https://images.migrosone.com/sanalmarket/product/08059120/08059120-ace5be-1650x1650.jpg','meyve suyu'],
        ['5449000070944','Cappy Meyve Suyu 1 L Atom','Karışık meyve suyu (%50) (elma, portakal, kivi, muz, ananas, nar), su, şeker veya fruktoz-glikoz şurubu, asitliği düzenleyici (sitrik asit), bal (%0.1), A vitamini.', 'Alerjen içermez.','https://images.migrosone.com/sanalmarket/product/08055172/08055172_1-2dceb4-1650x1650.jpg','meyve suyu'],

        // Enerji İçeceği
        ['090162602','Red Bull Enerji İçeceği 250 Ml','Su, Sakkaroz, Glikoz, Asit (Sitrik Asit), Karbondioksit, Asitlik Düzenleyici (Sodyum Bikarbonat), Taurin (800 mg/l), Kafein (32 mg/100ml), Vitaminler, Renklendiriciler (E150a Karamel, E101 Riboflavin).','Alerjen içermez.','https://images.migrosone.com/sanalmarket/product/08110030/08110030-a4b666-1650x1650.png','enerji içeceği'],
        ['8683789551158','Black Bruin Enerji İçeceği 500 Ml','Su, Şeker veya Fruktoz-Glikoz Şurubu, Karbondioksit, Asitlik Düzenleyiciler (Sitrik Asit, Sodyum Sitrat), Taurin (800 mg/l), Aroma Vericiler, Kafein (150 mg/l), Renklendirici (Amonyak Sülfit Karamel E150d), Vitaminler.','Alerjen içermez.','https://images.migrosone.com/sanalmarket/product/08110213/08110213-3487d2-1650x1650.jpg','enerji içeceği'],
        ['5060896624464','Monster Enerji İçeceği 355 Ml','Su, şeker, glukoz şurubu, karbondioksit, aroma vericiler, asit (sitrik asit), taurin (800 mg/l), koruyucular (sorbik asit E200, benzoik asit E210), kafein (150 mg/l), tatlandırıcı (sukraloz), renklendirici (E163), Vitaminler.','Alerjen içermez.','https://images.migrosone.com/sanalmarket/product/08113143/08113143_1-3f91e2-1650x1650.jpg','enerji içeceği']
    ];

    // 1. Kategorileri Ekle
    $kategoriler = array_unique(array_column($veriler, 5));
    $katMapping = [];
    $stmtKat = $pdo->prepare("INSERT IGNORE INTO kategoriler (isim) VALUES (?)");
    
    foreach ($kategoriler as $kIsim) {
        $kIsim = trim($kIsim);
        $stmtKat->execute([$kIsim]);
        $stmtId = $pdo->prepare("SELECT id FROM kategoriler WHERE isim = ?");
        $stmtId->execute([$kIsim]);
        $katMapping[$kIsim] = $stmtId->fetchColumn();
    }

    // 2. Ürünleri Ekle
    $stmtUrun = $pdo->prepare("INSERT INTO urunler (barkod, isim, icerik, alerjen, gorsel_url, kategori_id) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($veriler as $v) {
        $stmtUrun->execute([
            $v[0], // Barkod
            $v[1], // Isim
            $v[2], // Icerik (Noktalı ondalıklar ve E-kodları eklendi)
            $v[3], // Alerjen (Düzeltildi)
            $v[4], // Görsel URL
            $katMapping[trim($v[5])] // Kategori ID
        ]);
    }

    echo "<h1>Başarılı!</h1>";
    echo "<p>Veritabanı optimize edildi ve " . count($veriler) . " ürün yüklendi.</p>";
    echo "<p><strong>Düzeltmeler:</strong> Virgüllü ondalıklar noktaya çevrildi, E-kodları eklendi ve barkod hataları giderildi.</p>";

} catch (PDOException $e) { 
    die("Hata oluştu: " . $e->getMessage()); 
}
?>