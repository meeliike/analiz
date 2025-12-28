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

    // Ürün İstekleri Tablosu
    $pdo->exec("DROP TABLE IF EXISTS product_requests;");
    $pdo->exec("CREATE TABLE product_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        barkod VARCHAR(50) NOT NULL,
        isim VARCHAR(255) NOT NULL,
        kategori VARCHAR(100) NOT NULL,
        notlar TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
        ['8681856394141','Mayi Tuz Öğütülmüş Sofra Tuzu (İyot İlaveli) 2000 gr','%100 doğal Kaynak Tuzu, Potasyum İyodat.','Alerjen içermez.','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgUXdaDr_EaSD2JhDcZBemNcsxPvl9lG3qIw&s','tuz'],

        // Meyve Suyu
        ['8690558005026','DIMES CAM MEYVE SUYU 1 LT SEFATLI DİMES','Portakal Suyu, antioksidan (askorbik asit). ','alerjen degil','https://iet-cdn-003.akinsofteticaret.net/ebeymar.com/Resim/Minik/500x500_thumb_8690558005026.jpg','meyve suyu'],
        ['8690575871918','TAMEK %100 MEYVE SUYU 1 LT ELMA TAMEK','Su, Meyve suyu ve püre konsantreleri (Elma, Üzüm, Portakal, Kayısı, Ananas, Şeftali, Mango), Vitaminler (C,E,A), Asitlik Düzenleyici (Sitrik Asit), Meyve oranı %100dür.','alerjen degıl','https://images.migrosone.com/sanalmarket/product/08059120/08059120-ace5be-1650x1650.jpg','meyve suyu'],
        ['5449000070944','CAPPY MEYVE SUYU 1 LT ATOM CAPPY','Konsantre ve pürelerden üretilmiş karışık meyve suyu en az %50 (elma, portakal, kivi, muz, ananas, nar), su, şeker veya fruktoz-glikoz şurubu, asitliği düzenleyici (sitrik asit), aroma vericiler, bal (%0,1), A vitamini.','https://images.migrosone.com/sanalmarket/product/08055172/08055172_1-2dceb4-1650x1650.jpg','enerji içeceği'],

        // Enerji İçeceği
        ['90162602','Red Bull Enerji İçeceği 250 Ml','Su Sakkaroz,Glikoz,Asit(Sitrik Asit),Karbodioksit,Asitlik Düzenleyici(Sodyum Bikarbonat),Taurin(800 mg/l),Kafein Aroma vericiler,Renklendiriciler(Sade Karamel Riboflavin).','Alerjen İçermemektedir.','https://images.migrosone.com/sanalmarket/product/08110030/08110030-a4b666-1650x1650.png','enerji içeceği'],
        ['8683789551158','black bruin enerji içeceği 500 ml','Su, şeker(S)* veya fruktoz - glikoz şurubu (mısır) (F)*, karbondioksit, asitlik düzenleyiciler (sitrik asit, tri sodyum sitrat), taurin (maks.800 mg/L), aroma vericiler, kafein (maks.150 mg/L), inositol (maks. 100mg/L), glukoronolakton (maks.20 mg/L), renklendirici (amonyum sülfit karamel), vitaminler (niasin, pantotenik asit, B6, B2 ve B12). * Kullanılan şeker veya fruktoz-glikoz şurubu kutu altına kodlanmıştır.','alerjen degıl.','https://images.migrosone.com/sanalmarket/product/08110213/08110213-3487d2-1650x1650.jpg','enerji içeceği'],
        ['5060896624464','Monster Enerji İçeceği (355 ml)','su, şeker, glukoz şurubu, karbondioksit, aroma vericiler, asit (sitrik asit), asitlik düzenleyici (sodyum sitrat), panaks ginseng özütü(%0,08), taurin (800 mg/l), l-karnitin l-tartarat (400 mg/l), koruyucular (sorbik asit, benzoik asit), kafein (en fazla 150 mg/l guarana dahil), niasin (nikotinamid), tatlandırıcı (sukraloz) renklendirici (antosiyaninler), sodyum klorür, d-glukoronolakton(20 mg/l), guarana tohumu özütü (%0,002), inositol(20 mg/l), vitamin b6 (iridoksin hidroklorür), vitamin b2 (riboflavin), maltodekstrin,vitamin b12(siyanokobalamin)','alerjen degıl','https://images.migrosone.com/sanalmarket/product/08113143/08113143_1-3f91e2-1650x1650.jpg','enerji içeceği'],
    
        //kahve
    ['8690627021209','Kurukahveci Mehmet Efendi Türk Kahvesi 100 G','Öğütülmüş Kahve.','Alerjen İçermemektedir.','https://images.migrosone.com/sanalmarket/product/03211601/03211601-a57e01-1650x1650.jpg','kahve'],
    ['8711000532607','Jacobs Monarch Filtre Kahve 250 G','KAVRULMUŞ VE ÖĞÜTÜLMÜŞ KAHVE','Alerjen İçermemektedir.','https://images.migrosone.com/sanalmarket/product/03271405/3271405_1-02372f-1650x1650.jpg','kahve'],
    ['8690632062907','Nescafé Gold Ekonomik Paket 180 G','Çözünebilir kahve , ince öğütülmüş kahve (%3)','Alerjen içermemektedir','https://images.migrosone.com/sanalmarket/product/3231605/3231605-a9d177-1650x1650.jpg','kahve'],
    ['1150551','Tchibo Gold Selection Filtre Kahve 250 G','Öğütülmüş filtre kahve','alerjen degıl','https://images.migrosone.com/sanalmarket/product/03271968/3271968_1-65a371-1650x1650.jpg','kahve'],
    ['8690632060781','Starbucks Vanilla Latte Premium Kahve Karışımı 21.5 G','Şeker, Yarım yağlı süttozu (%38,4), çözünebilir kahve (7,1%), glukoz şurubu, yağsız süttozu (3,5%), laktoz (süt ürünü), stabilizörler (dipotasyum fosfat, trisodyum sitrat), süt yağı, ince öğütülmüş kahve, doğal aroma verici (vanilin)','Buğday (gluten) içerebilir','https://images.migrosone.com/sanalmarket/product/03252559/3252559_1-bc177e-1650x1650.jpg','kahve'],

    //cips
    ['8681506021069','Patos Rolls Acı Kırmızı Biber Aromalı Mısır Cipsi 185 G','Mısır, bitkisel yağ (palm olein yağı), acı kırmızı biber aromalı çeşni [şeker, tuz, aroma arttırıcılar (monosodyum glutamat, disodyum 5?-ribonükleotitler), peynir altı suyu tozu (süt içerir), soğan tozu, acı biber tozu, kırmızı biber tozu, asitlik düzenleyiciler (sitrik asit, sodyum diasetat), domates tozu, öğütülmüş karabiber tozu, topaklanmayı önleyici (silikon dioksit), renklendirici (paprika ekstraktı), baharat ekstraktı, maltodekstrin, bitkisel yağlar (kanola, hindistan cevizi, palm), aroma verici, öğütülmüş kimyon tozu, limon suyu tozu, antioksidan (biberiye ekstraktı)]','SÜT İÇERİR. ESER MİKTARDA GLUTEN, SOYA VE YER FISTIĞI İÇEREBİLİR.','https://images.migrosone.com/sanalmarket/product/05080180/05080180_1-5a0405-1650x1650.jpg','cips'],
    ['8682190854339','Master Potato Soğanlı & Ekşi Kremalı Cips 160 G','Kurutulmuş patates, bitkisel yağ (palm yağı), mısır nişastası,buğday nişastası,ekşi krema çeşnisi [süt tozu,tuz,tatlandırıcılar, sebze çeşnisi,aroma arttırıcılar (E-621,E-635), Maltodekstrin, şeker,topaklanma önleyici (E-551), tuz,şeker,aroma arttırıcılar (E-621),emülgatör (E471).','alarjen','https://images.migrosone.com/sanalmarket/product/05089579/05089579_1-beb9b5-1650x1650.jpg','cips'],
    [' 8690624105704','Lays Klasik Süper Boy 125 G','Patates, bitkisel yağlar (değişen miktarlarda mısır, yüksek oleik asitli ayçiçek, kanola), tuz.','alerjen degıl','https://images.migrosone.com/sanalmarket/product/05080145/05080145_1-6b2aff-1650x1650.jpg','cips'],
    ['8683717472609','Master Nut Fıstık Ezmeli Ballı Mısır Cipsi 150 G','Mısır irmiği, fıstık ezmesi(%40),fıstık yağı,toz bal (%7),fıstık unu(%13),kırmızı tatlı toz biber, deniz tuzu (%1,5)','Fıstık içerir. Eser miktarda sert kabuklu meyveler ve gluten içerebilir.','https://images.migrosone.com/sanalmarket/product/05080060/05080060-9d785f-1650x1650.jpeg','cips'],
    ['8681506021182','Cipso Tırtıklı Ketçap Aromalı Patates Cipsi 160 G','Patates, bitkisel yağ (palm olein yağı), ketçap aromalı çeşni [şeker, tuz, aroma arttırıcılar (monosodyum glutamat, disodyum 5ribonükleotitler), maltodekstrin, asitlik düzenleyiciler (sodyum diasetat, sitrik asit, kalsiyum laktat), maya ekstraktı, domates tozu, aroma verici (domates), soğan tozu, topaklanmayı önleyiciler (trikalsiyum fosfat, silikon dioksit), sarımsak tozu, renklendiriciler (paprika ekstraktı, pancar kökü kırmızısı), antioksidan (biberiye ekstraktı)].','ESER MİKTARDA SÜT, SOYA, GLUTEN VE YER FISTIĞI İÇEREBİLİR.','https://images.migrosone.com/sanalmarket/product/05080187/05080187_1-62e181-1650x1650.jpg','cips'],

    //cerez
    ['8690787251010','Tadım Kavrulmuş Siyah Ayçekirdeği 180 G','ay çekirdeği, tuz','Eser miktarda antep fıstığı, yer fıstığı, badem, ceviz, pikan cevizi, fındık, kaju fıstığı ve buğday gluteni içerebilir.','https://images.migrosone.com/sanalmarket/product/08089819/8089819-5f54d6-1650x1650.jpg','kuruyemıs'],
    ['8682190850645','Master Nut Kavrulmuş Tuzlu Kaju Fıstığı 140gr','Kaju fıstığı,stabilizör (gum arabikE414),tuz','Eser miktarda yer fıstığı,badem,fındık,Antep fıstığı ve buğday gluteni içerebilir.','https://images.migrosone.com/sanalmarket/product/08079756/8079756_1-afb84b-1650x1650.jpg','kuruyemıs'],
    ['8683717471008','Kara Sevda Yerli Tuzsuz Siyah Ayçekirdeği 125 G','Ayçekirdeği','Eser miktarda yer fıstığı,fındık,badem,Antep fıstığı ve buğday gluteni içerebilir','https://images.migrosone.com/sanalmarket/product/08079619/8079619-e26e5d-1650x1650.jpg','kuruyemıs'],
    ['8695876206384 ','Peyman Çitliyo Kara Şimşek Bol Tuzlu 120 G','SİYAH AY ÇEKİRDEĞİ, TUZ (%7,5)','Eser miktarda yer fıstığı, badem, fındık, kaju fıstığı, soya, süt proteini (laktoz dahil) ve hardal içerebilir.','https://images.migrosone.com/sanalmarket/product/08079632/8079632-7c13a2-1650x1650.jpg','kuruyemıs'],
    ['8695876200061','Peyman Bahçeden Ortaya Karışık Asorti 140 G','Kavrulmuş fındık, kavrulmuş tuzlu kaju fıstığı, kavrulmuş tuzlu iç badem, kavrulmuş tuzlu iç antep fıstığı.','fındık, kaju fıstığı, badem, Antep fıstığı içerir.Eser miktarda yer fıstığı, ceviz, soya, süt proteini (laktoz dahil), hardal, pikan cevizi , bakla ve kükürtdioksit içerebilir.','https://images.migrosone.com/sanalmarket/product/08090858/08090858-76a369-1650x1650.jpg','kuruyemıs'],
    //süt
    ['8692095341773','Sek Süt 1 L','UHT Yağlı süt (%3 Yağlı)','Laktoz içerir.','https://images.migrosone.com/sanalmarket/product/11012000/11012000_1-ad06f1-1650x1650.jpg','süt'],
    ['8690504410911','İçim Rahat Laktozsuz Süt 1 L','Yarım yağlı inek sütü , laktaz enzimi ','Alerjen uyarısı yoktur.','https://images.migrosone.com/sanalmarket/product/11010066/11010066-90d964-1650x1650.jpg','süt'],
    ['8690565005538','Pınar Denge Laktozsuz Süt 1 L','%1,5 Yarım yağlı inek sütü, laktaz enzim','süt ürünü içerir','https://images.migrosone.com/sanalmarket/product/11010089/11010089-74fc9a-1650x1650.jpg','süt'],
    ['8680181001090','Torku Uht Süt 1 L','% 3,3 yağlı inek sütü (hayvansal)','Süt içerir.','https://images.migrosone.com/sanalmarket/product/11019904/11019904_1-f55980-1650x1650.jpg','süt'],
    ['8683816650014','Baltalı % 100 Pastörize Keçi Sütü 1L','PASTÖRİZE KEÇİ SÜTÜ','Laktoz içerir', 'https://images.migrosone.com/sanalmarket/product/11017080/11017080-144923-1650x1650.JPG','süt'],

    //baharat
    ['8690560019370','Bağdat Cajun Baharatı 80 G','Tuz, değişen miktarlarda baharatlar (tatlı toz biber, kekik, zahter, yenibahar, kişniş, kimyon, karabiber, Kereviz, soğan, sarımsak, zerdeçal)','Kereviz içerir. İz miktarda Gluten, Hardal, Soya, Susam, Antep fıstığı, Çam fıstığı ve süt ürünü içerebilir.','https://images.migrosone.com/sanalmarket/product/06010056/06010056-29e3f8-1650x1650.jpg','baharat'],
    ['8690178033409','Hayfene 5. Element Baharatı 140 G','   ','ESER MİKTARDA KEREVİZ HARDAL SUSAM SERT KABUKLU MEYVE İÇEREBİLİR','https://images.migrosone.com/sanalmarket/product/06013041/06013041-937011-1650x1650.jpg','baharat'],
    ['8698811522617','Si&Ha Zeytin Baharatı 100 G','KIRMIZI BİBER KEKİK KİŞNİŞ KAYA TUZU','alerjen değil','https://images.migrosone.com/sanalmarket/product/28510194/28510194_1-4fcd01-1650x1650.jpg','baharat'],
    ['8690637998539','Knorr Baharat Serisi Tarçın 40 G','Tarçın','  ','https://images.migrosone.com/sanalmarket/product/06010077/6010077-3a8199-1650x1650.jpg','baharat'],


    // yoğurt
    ['8690767160127','Sütaş Kaymaksız Yoğurt 1000 G','Sadece inek sütü ve yoğurt mayasıyla üretilmiştir.','Süt ve süt ürünleri (laktoz dahil)','https://images.migrosone.com/sanalmarket/product/12500380/12500380-e81483-1650x1650.jpg','yoğurt'] ,
     ['8683771982014','Migros Tam Yağlı Homojenize Yoğurt 3000 G','Pastörize inek sütü (laktoz içerir), yoğurt kültürü.','Laktoz içerir','https://images.migrosone.com/sanalmarket/product/12501957/12501957-e57f90-1650x1650.jpg','yoğurt'],
     [' 8691316520973','Eker Süzme Yoğurt 900 G','Pastörize ve homojenize inek sütü , yoğurt kültürü.','Pastörize ve homojenize inek sütü','https://images.migrosone.com/sanalmarket/product/12509940/12509940_1-c93aac-1650x1650.png','yoğurt'],
     ['8699197160844','Tire Süt Kooperatifi Kaymaklı Yoğurt 1500 G','YAGLI PASTÖRIZE INEK SÜTÜ, YOGURT MAYASI','LAKTOZ IÇERIR','https://images.migrosone.com/sanalmarket/product/12502008/12502008-ac7fae-1650x1650.jpg','yoğurt'],
        ['8692095345801','Sek Laktozsuz Yarım Yağlı Yoğurt 750 G','Yarım yağlı pastörize süt, yoğurt kültürü ve laktaz enzimi.','SÜT ALERJENDİR','https://images.migrosone.com/sanalmarket/product/12500421/12500421-9c29e2-1650x1650.jpg','yoğurt'],
       
       
        // peynir
        ['8690843095602','Bahçıvan Çeçil Peyniri 200 G','Pastörize inek sütü, tuz, peynir kültürü, kalsiyum klorür, peynir mayası, koruyucu (potasyum sorbat)','Laktoz içerir','https://images.migrosone.com/sanalmarket/product/10406815/10406815-031bb9-1650x1650.jpg','peynir'],
        ['8692971436005','President Cheddar Marble Peyniri 220 G','Pastörize inek sütü, peynir mayası, peynir kültürü, stabilizör (kalsiyum klorür), renklendirici (beta-karoten), tuz.','Pastörize inek sütü','https://images.migrosone.com/sanalmarket/product/10400207/10400207_1-634e91-1650x1650.jpg','peynir'],
        ['8680181125222','Torku Tam Yağlı Taze Kaşar Peyniri 600 G','Pastörize İnek Sütü, Tuz, Stabilizör ( Kalsiyum klorür ), Peynir Mayası, Peynir kültürü, Koruyucu ( Potasyum sorbat ) Kuru maddede en az % 45 süt yağ içerir.','SÜT İÇERİR.','https://images.migrosone.com/sanalmarket/product/10101938/10101938_1-855445-1650x1650.jpg','peynir'],
        ['8695543006163','Muratbey Burgu Peyniri 200 G','İçindekiler: Pastörize inek sütü, stabilizör (kalsiyum klorür), peynir mayası, tuz, kültür.','Pastörize inek sütü.','https://images.migrosone.com/sanalmarket/product/10403370/10403370_1-eca25e-1650x1650.jpg','peynir'],
        ['8006207000098','Trakya Çiftliği Parmesanlı Hazır Yemek Ürünü 80 G','Parmesan peyniri,inek sütü telemesi,palm yağı,hindisatn cevizi yağı, stabilizatör (E1422,E407),Tuz','Süt ve süt ürünleri içerir','https://images.migrosone.com/sanalmarket/product/10401600/10401600-7e0e04-1650x1650.jpg','peynir']
            
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