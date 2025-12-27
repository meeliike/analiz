<?php
require_once 'config.php';

try {
    // Tabloları temizle
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("DROP TABLE IF EXISTS urunler;");
    $pdo->exec("DROP TABLE IF EXISTS kategoriler;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    // Tabloları oluştur
    $pdo->exec("CREATE TABLE kategoriler (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        isim VARCHAR(100) NOT NULL UNIQUE
    ) ENGINE=InnoDB;");

    $pdo->exec("CREATE TABLE urunler (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        barkod VARCHAR(50) NOT NULL UNIQUE, 
        isim VARCHAR(255) NOT NULL, 
        icerik TEXT, 
        alerjen TEXT, 
        gorsel_url VARCHAR(255), 
        kategori_id INT, 
        FOREIGN KEY (kategori_id) REFERENCES kategoriler(id) ON DELETE SET NULL
    ) ENGINE=InnoDB;");

    // Tüm Ürün Verileri
    $veriler = [
        // Çikolata
        ['8683508143831', 'Ülker Çikolata İstanbul Fındıklı & Çıtır Kadayıflı 93 G', 'Şeker, Tam Yağlı Sütozü Fındık (%10,3), Kakao Yağı, Kakao Kitlesi, Bitkisel Yağlar, Çıtır Kadayıf ve Baklava Parçacıkları, Peyniraltı Suyu Tozu, Yağsız Süttozu, Maltodekstrin, Emülgatör (Soya Lesitini), Tuz, Aroma Vericiler.', 'Süt, fındık, Buğday, Yumurta, Gluten, Soya içerir.', 'https://images.migrosone.com/sanalmarket/product/07031385/07031385_1-739cf1-1650x1650.jpg', 'çikolata'],
        ['8690526076379', 'Eti Browni Intense Çikolatalı Kek 50 G', 'Kek %52, Sütlü Çikolata %29, Çikolatalı Krema %17, Bitter Çikolata %2.', 'Gluten, süt ürünü içerir. Eser miktarda yemiş içerebilir.', 'https://images.migrosone.com/sanalmarket/product/05098209/eti-browni-intense-50-gr-bb8473-1650x1650.jpg', 'çikolata'],
        ['7622201519544', 'Milka Çikolata Rüyası 100 G', 'Şeker, palm yağı, peynir altı suyu tozu, kakao yağı, fındık ezmesi.', 'Süt, soya, fındık.', 'https://images.migrosone.com/sanalmarket/product/07040550/7040550_1-8985e1-1650x1650.jpg', 'çikolata'],
        ['8690526016573', 'Eti Sütlü Çikolata Kaplı Fındık Kremalı Gofret 34 G', 'Fındıklı Krema %46,9, Sütlü Çikolata %33, Gofret Yaprağı %20,1.', 'Fındık Püresi, Süt Ürünü, Buğday Unu.', 'https://images.migrosone.com/sanalmarket/product/07167761/07167761-c603a5-1650x1650.jpg', 'çikolata'],
        ['8699270017638', 'Kahve Dünyası Tambol Antep Fıstıklı Sütlü Çikolata 77 G', 'Sütlü çikolata, Antep fıstığı (%25).', 'Süt ürünü, Antep fıstığı.', 'https://images.migrosone.com/sanalmarket/product/07030583/7030583_1-ef40bb-1650x1650.jpg', 'çikolata'],
        ['8683417000270','Tadelle Fındık Dolgulu Sütlü Çikolata King Size 52 G' ,'Fındık Dolgulu Sütlü Çikolata (%75), Şeker, Fındık (%26), Kakao.', 'Fındık, Süt Tozu, Peynir Altı Suyu.', 'https://images.migrosone.com/sanalmarket/product/07163345/tadelle-sutlu-cikolata-52-gr-f4034e-1650x1650.jpg','çikolata'],
        ['8681630410258', 'Züber %100 Fıstık Ezmeli Noutos 55 G', 'Nohut Unu (%37), Yer Fıstığı (%31), Pirinç İrmiği, Bal.', 'Yer Fıstığı içerir. Süt içerebilir.', 'https://images.migrosone.com/sanalmarket/product/08077438/08077438_1-2f0f9e-1650x1650.jpg', 'çikolata'],

        // Sakız
        ['8690840228362', 'Ülker Oneo Bubble Çilek & Muz Milkshake Aromalı Sakız', 'Şeker, sakız mayası, glukoz şurubu, aroma vericiler.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07126236/07126236-d684d8-1650x1650.jpg', 'sakız'],
        ['8693323006419', 'Nazar Damla Sakızı Aromalı Şekersiz Sakız 3\'lü', 'Sakız mayası, aroma verici (damla sakızı), BHT.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07120377/7120377-88257a-1650x1650.jpg', 'sakız'],
        ['80770848', 'Vivident 45Dk Cüzdan Çilek Aromalı Sakız 26 G', 'Tatlandırıcılar, Sakız Mayası, Aroma Vericiler.', 'Soya Lesitini içerir.', 'https://images.migrosone.com/sanalmarket/product/03500005/3500005-90eae1-1650x1650.jpg', 'sakız'],
        ['8690840229093', 'Ülker Pembo Karışık Meyve Aromalı Balonlu Sakız 22.5 G', 'Şeker, Sakız Mayası, Glukoz Şurubu.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07120381/07120381-9d530c-1650x1650.jpg', 'sakız'],
        ['622210753236', 'Tipitip Karışık Meyve Ve Mentol Aromalı Sakız 27 G', 'Tatlandırıcılar, Sakız Mayası, Nem Verici.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/07120409/07120409-80c1fc-1650x1650.jpg', 'sakız'],

        // Yağ
        ['8699300272259', 'Komili Ayçiçek Yağı 5 L', 'Rafine ayçiçek yağı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04110062/4110062-5f2b02-1650x1650.jpg', 'yağ'],
        ['8684059741040', 'Aivalos Cızart Riviera Zeytinyağı 750 Ml', 'Rafine zeytinyağı ve sızma zeytinyağı karışımı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04130283/04130283_1-8ba35e-1650x1650.jpg', 'yağ'],
        ['8693275002217', 'Çotanak Kare Pet Kanola Yağı 5 L', 'Kanola Yağı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04171016/04171016_1-7484a7-1650x1650.jpg', 'yağ'],
        ['8690876105583', 'Yudum Airfry\'a Özel Sprey Ayçiçek Yağı Cam 250 Ml', 'Ayçiçek Yağı.', 'Alerjen içermez.', 'https://images.migrosone.com/sanalmarket/product/04110128/04110128-199be0-1650x1650.jpg', 'yağ'],
        ['8690565020814', 'Pınar Tereyağı 125 G', 'Pastörize inek sütü kreması, tereyağ kültürü.', 'Süt ve Süt ürünü içerir.', 'https://images.migrosone.com/sanalmarket/product/12010015/pinar-tereyagi-125-gr-f0ccfb-1650x1650.jpg', 'yağ'],

        // Bisküvi
        ['7622202312502','Oreo Classic 228 G','BUĞDAY unu, şeker, bitkisel yağ (palm), yağı azaltılmış kakao tozu (%3,5).','GLUTEN VE SOYA İÇERİR. SÜT İÇEREBİLİR','https://images.migrosone.com/sanalmarket/product/07028859/07028859_1-8717d5-1650x1650.jpg','bisküvi'],
        ['8690526063508','Eti Burçak Sütlü Çikolatalı Bisküvi 114 G','Buğday Unu, Tam Buğday Unu %24, Sütlü Çikolata %29.','Gluten içerir. Eser miktarda yemiş içerebilir.','https://images.migrosone.com/sanalmarket/product/7019931/7019931-041230-1650x1650.jpg','bisküvi'],
        ['8690526793184','Eti Nero Kakaolu Bisküvi 110 G','Buğday Unu, Kakaolu Krema %20, Tam Yağlı Süt Tozu.','Gluten ve Süt ürünü içerir.','https://images.migrosone.com/sanalmarket/product/05041071/eti-nero-kakaolu-biskuvi-110-gr-0f3b43-1650x1650.jpg','bisküvi'],
        ['68690504083483','Ülker Saklıköy Çikolata Kremalı Bisküvi 87 G','Şeker, palm yağı, buğday unu, tam buğday unu (%11).','Gluten, süt, soya içerir.','https://images.migrosone.com/sanalmarket/product/07019731/07019731-d642e7-1650x1650.jpg','bisküvi'],
        ['8690766050078','Ülker Coco Star Atıştırmalık 154 G','Buğday unu, Hindistan cevizi (%4), Sütlü Çikolata.','Gluten, süt, sülfit içerir.','https://images.migrosone.com/sanalmarket/product/07013747/07013747-cc8696-1650x1650.jpg','bisküvi'],

        // Tuz
        ['8690771130925','BİLLUR TUZ 3 KG DENİZ TUZU','Rafine Tuz (sodyum klorür), topaklanmayı önleyici.','Alerjen içermez.','https://barkodist.com//assets/img/barkod/billur-tuz-rafine-iyotlu-sofra-tuzu-karton-tuzluk-125-g-barkodu.jpeg','tuz'],
        ['8681856394141','Mayi Tuz Öğütülmüş Sofra Tuzu (İyot İlaveli) 2000 gr','%100 doğal Kaynak Tuzu, Potasyum İyodat.','Alerjen içermez.','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgUXdaDr_EaSD2JhDcZBemNcsxPvl9lG3qIw&s','tuz']
        //meyvesuyu
        ['8690558005026','DIMES CAM MEYVE SUYU 1 LT SEFATLI DİMES','Portakal Suyu, antioksidan (askorbik asit). ','alerjen degil','https://iet-cdn-003.akinsofteticaret.net/ebeymar.com/Resim/Minik/500x500_thumb_8690558005026.jpg','meyve suyu']
        ['8690575871918','TAMEK %100 MEYVE SUYU 1 LT ELMA TAMEK','Su, Meyve suyu ve püre konsantreleri (Elma, Üzüm, Portakal, Kayısı, Ananas, Şeftali, Mango), Vitaminler (C,E,A), Asitlik Düzenleyici (Sitrik Asit), Meyve oranı %100dür.','alerjen degıl','https://images.migrosone.com/sanalmarket/product/08059120/08059120-ace5be-1650x1650.jpg','meyve suyu']
        ['5449000070944','CAPPY MEYVE SUYU 1 LT ATOM CAPPY','Konsantre ve pürelerden üretilmiş karışık meyve suyu en az %50 (elma, portakal, kivi, muz, ananas, nar), su, şeker veya fruktoz-glikoz şurubu, asitliği düzenleyici (sitrik asit), aroma vericiler, bal (%0,1), A vitamini.','https://images.migrosone.com/sanalmarket/product/08055172/08055172_1-2dceb4-1650x1650.jpg','enerji içeceği']
        // enerji içeceği
        ['90162602','Red Bull Enerji İçeceği 250 Ml','Su Sakkaroz,Glikoz,Asit(Sitrik Asit),Karbodioksit,Asitlik Düzenleyici(Sodyum Bikarbonat),Taurin(800 mg/l),Kafein Aroma vericiler,Renklendiriciler(Sade Karamel Riboflavin).','Alerjen İçermemektedir.','https://images.migrosone.com/sanalmarket/product/08110030/08110030-a4b666-1650x1650.png']
        ['8683789551158','black bruin enerji içeceği 500 ml','Su, şeker(S)* veya fruktoz - glikoz şurubu (mısır) (F)*, karbondioksit, asitlik düzenleyiciler (sitrik asit, tri sodyum sitrat), taurin (maks.800 mg/L), aroma vericiler, kafein (maks.150 mg/L), inositol (maks. 100mg/L), glukoronolakton (maks.20 mg/L), renklendirici (amonyum sülfit karamel), vitaminler (niasin, pantotenik asit, B6, B2 ve B12). * Kullanılan şeker veya fruktoz-glikoz şurubu kutu altına kodlanmıştır.','alerjen degıl.','https://images.migrosone.com/sanalmarket/product/08110213/08110213-3487d2-1650x1650.jpg','enerji içeceği']
    ['5060896624464','Monster Enerji İçeceği (355 ml)','su, şeker, glukoz şurubu, karbondioksit, aroma vericiler, asit (sitrik asit), asitlik düzenleyici (sodyum sitrat), panaks ginseng özütü(%0,08), taurin (800 mg/l), l-karnitin l-tartarat (400 mg/l), koruyucular (sorbik asit, benzoik asit), kafein (en fazla 150 mg/l guarana dahil), niasin (nikotinamid), tatlandırıcı (sukraloz) renklendirici (antosiyaninler), sodyum klorür, d-glukoronolakton(20 mg/l), guarana tohumu özütü (%0,002), inositol(20 mg/l), vitamin b6 (iridoksin hidroklorür), vitamin b2 (riboflavin), maltodekstrin,vitamin b12(siyanokobalamin)','alerjen degıl','https://images.migrosone.com/sanalmarket/product/08113143/08113143_1-3f91e2-1650x1650.jpg','enerji içeceği']
    ];

    // 1. Kategorileri Topla ve Veritabanına Ekle
    $kategoriler = array_unique(array_column($veriler, 5));
    $katMapping = [];
    $stmtKat = $pdo->prepare("INSERT IGNORE INTO kategoriler (isim) VALUES (?)");
    
    foreach ($kategoriler as $kIsim) {
        $kIsim = trim($kIsim);
        $stmtKat->execute([$kIsim]);
        // Eklenen veya var olan kategorinin ID'sini al
        $stmtId = $pdo->prepare("SELECT id FROM kategoriler WHERE isim = ?");
        $stmtId->execute([$kIsim]);
        $katMapping[$kIsim] = $stmtId->fetchColumn();
    }

    // 2. Ürünleri Veritabanına Ekle
    $stmtUrun = $pdo->prepare("INSERT INTO urunler (barkod, isim, icerik, alerjen, gorsel_url, kategori_id) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($veriler as $v) {
        $stmtUrun->execute([
            $v[0], // Barkod
            $v[1], // Isim
            $v[2], // Icerik
            $v[3], // Alerjen
            $v[4], // Görsel URL
            $katMapping[trim($v[5])] // Kategori ID
        ]);
    }

    echo "<h1>Başarılı!</h1>";
    echo "<p>Toplam " . count($veriler) . " ürün ve " . count($kategoriler) . " kategori başarıyla yüklendi.</p>";

} catch (PDOException $e) { 
    die("Hata oluştu: " . $e->getMessage()); 
}
?>