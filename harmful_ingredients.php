<?php
/**
 * Zararlı İçerikler Veritabanı
 * Tüm zararlı maddeler ve detaylı açıklamaları
 */

function getHarmfulIngredientsDictionary() {
    return [
        // E kodları (Katkı maddeleri)
        'E150d' => ['isim' => 'E150d (Karamel IV - Amonyak Sülfit Prosesi)', 'zarar_nedeni' => 'Kanserojen risk taşır. Amonyak sülfit prosesi ile üretilen karamel, 4-metilimidazol (4-MEI) içerebilir.'],
        'E621' => ['isim' => 'E621 (Monosodyum Glutamat - MSG)', 'zarar_nedeni' => 'Alerjen tetikleyici, migren ve baş ağrısı yapabilir.'],
        'E951' => ['isim' => 'E951 (Aspartam)', 'zarar_nedeni' => 'Yapay tatlandırıcı, sindirim sorunlarına yol açabilir. Fenilketonüri (PKU) hastaları için tehlikelidir.'],
        'E211' => ['isim' => 'E211 (Sodyum Benzoat)', 'zarar_nedeni' => 'Koruyucu madde, alerji riski taşır. C vitamini ile birleştiğinde benzen oluşturabilir.'],
        'E250' => ['isim' => 'E250 (Sodyum Nitrit)', 'zarar_nedeni' => 'Nitrit, yüksek sıcaklıkta nitrozaminlere dönüşerek kanser riski taşır.'],
        'E102' => ['isim' => 'E102 (Tartrazin)', 'zarar_nedeni' => 'Sarı renklendirici, hiperaktivite ve alerji riski.'],
        // Diğer zararlı maddeler
        'Trans yağ' => ['isim' => 'Trans Yağ', 'zarar_nedeni' => 'Kalp hastalıkları riskini artırır. LDL kolesterolü yükseltir.'],
        'Fruktoz şurubu' => ['isim' => 'Fruktoz Şurubu', 'zarar_nedeni' => 'Obezite ve diyabet riski. Karaciğer yağlanmasına neden olur.'],
        'Palm yağı' => ['isim' => 'Palm Yağı', 'zarar_nedeni' => 'Yüksek doymuş yağ içeriği. LDL kolesterolü yükseltebilir.'],
        // Liste devam ediyor...
    ];
}

/**
 * İçerikleri parse et - Parantez içindeki virgülleri korur
 */
function parseIngredients($icerik_metni) {
    if (empty($icerik_metni)) return [];
    
    $icerikler = [];
    $current = '';
    $depth = 0;
    
    for ($i = 0; $i < strlen($icerik_metni); $i++) {
        $char = $icerik_metni[$i];
        if ($char === '(') $depth++;
        elseif ($char === ')') $depth--;
        elseif ($char === ',' && $depth === 0) {
            $icerikler[] = trim($current);
            $current = '';
            continue;
        }
        $current .= $char;
    }
    if (!empty(trim($current))) $icerikler[] = trim($current);
    return array_filter($icerikler);
}

/**
 * Riskli içerikleri tespit et
 */
function detectHarmfulIngredients($icerikler) {
    $zarar_sozlugu = getHarmfulIngredientsDictionary();
    $riskli_icerikler = [];
    
    foreach ($icerikler as $icerik) {
        $icerik_lower = mb_strtolower($icerik, 'UTF-8');
        
        foreach ($zarar_sozlugu as $anahtar => $bilgi) {
            if (stripos($icerik_lower, mb_strtolower($anahtar, 'UTF-8')) !== false) {
                $riskli_icerikler[] = [
                    'isim' => $bilgi['isim'],
                    'zarar_nedeni' => $bilgi['zarar_nedeni']
                ];
                break;
            }
        }
    }
    return $riskli_icerikler;
}
?>