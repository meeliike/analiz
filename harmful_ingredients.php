<?php
/**
 * Zararlı İçerikler Veritabanı
 * Tüm zararlı maddeler ve detaylı açıklamaları
 */

function getHarmfulIngredientsDictionary() {
    return [
        // E kodları (Katkı maddeleri) - risk_degeri: 1=Düşük, 3=Orta, 5=Yüksek
        'E150d' => ['isim' => 'E150d (Karamel IV - Amonyak Sülfit Prosesi)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Kanserojen risk taşır. Amonyak sülfit prosesi ile üretilen karamel, 4-metilimidazol (4-MEI) içerebilir. Bu madde hayvan çalışmalarında kanser riski oluşturmuştur. Özellikle yüksek dozlarda tüketildiğinde sağlık riski yaratabilir.'],
        'E621' => ['isim' => 'E621 (Monosodyum Glutamat - MSG)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Alerjen tetikleyici, migren ve baş ağrısı yapabilir. Bazı kişilerde "Çin Restoranı Sendromu" adı verilen semptomlara (baş ağrısı, mide bulantısı, terleme) neden olabilir. Nörolojik hassasiyeti olan kişilerde sorun yaratabilir.'],
        'E951' => ['isim' => 'E951 (Aspartam)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Yapay tatlandırıcı, sindirim sorunlarına yol açabilir. Fenilketonüri (PKU) hastaları için tehlikelidir. Bazı çalışmalar migren, baş dönmesi ve nörolojik semptomlarla ilişkilendirilmiştir. Yüksek dozlarda tüketildiğinde baş ağrısı ve mide rahatsızlığı yapabilir.'],
        'E211' => ['isim' => 'E211 (Sodyum Benzoat)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Koruyucu madde, alerji riski taşır. C vitamini ile birleştiğinde benzen oluşturabilir (kanserojen). Astım ve hiperaktivite ile ilişkilendirilmiştir. Hassas bireylerde alerjik reaksiyonlara neden olabilir.'],
        'E250' => ['isim' => 'E250 (Sodyum Nitrit)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrit, yüksek sıcaklıkta nitrozaminlere dönüşerek kanser riski taşır. Özellikle işlenmiş et ürünlerinde kullanılır. Yüksek dozlarda methemoglobinemiye (oksijen taşıma sorunu) neden olabilir. Çocuklar için daha risklidir.'],
        'E251' => ['isim' => 'E251 (Sodyum Nitrat)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrat, vücutta nitrite dönüşerek kanser riski taşır. Özellikle işlenmiş et ürünlerinde kullanılır. Yüksek dozlarda tüketildiğinde sağlık sorunlarına yol açabilir. Hamile kadınlar ve çocuklar için özellikle dikkatli olunmalıdır.'],
        'E102' => ['isim' => 'E102 (Tartrazin)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Sarı renklendirici, hiperaktivite ve alerji riski. Astım ve egzama semptomlarını tetikleyebilir. Özellikle çocuklarda dikkat eksikliği ve hiperaktivite bozukluğu ile ilişkilendirilmiştir.'],
        'E104' => ['isim' => 'E104 (Kinolin Sarısı)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Sarı renklendirici, alerji ve hiperaktivite riski. Hassas bireylerde alerjik reaksiyonlara neden olabilir. Bazı ülkelerde kullanımı kısıtlanmıştır.'],
        'E110' => ['isim' => 'E110 (Sunset Yellow)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Turuncu renklendirici, alerji ve hiperaktivite riski. Astım ve egzama semptomlarını tetikleyebilir. Çocuklarda davranış sorunlarına yol açabilir.'],
        'E122' => ['isim' => 'E122 (Azorubine)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Kırmızı renklendirici, alerji riski. Astım ve hiperaktivite ile ilişkilendirilmiştir. Hassas bireylerde alerjik reaksiyonlara neden olabilir.'],
        'E124' => ['isim' => 'E124 (Ponceau 4R)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Kırmızı renklendirici, alerji ve hiperaktivite riski. Astım semptomlarını tetikleyebilir. Bazı ülkelerde kullanımı yasaklanmıştır.'],
        'E129' => ['isim' => 'E129 (Allura Red AC)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Kırmızı renklendirici, alerji ve hiperaktivite riski. Özellikle çocuklarda dikkat sorunlarına yol açabilir.'],
        'E133' => ['isim' => 'E133 (Brilliant Blue FCF)', 'risk_degeri' => 1, 'zarar_nedeni' => 'Mavi renklendirici, alerji riski. Hassas bireylerde alerjik reaksiyonlara neden olabilir.'],
        'E142' => ['isim' => 'E142 (Yeşil S)', 'risk_degeri' => 1, 'zarar_nedeni' => 'Yeşil renklendirici, alerji riski. Bazı ülkelerde kullanımı kısıtlanmıştır.'],
        'E200' => ['isim' => 'E200 (Sorbik Asit)', 'risk_degeri' => 1, 'zarar_nedeni' => 'Koruyucu madde, genellikle güvenli kabul edilir ancak hassas bireylerde cilt tahrişine neden olabilir.'],
        'E202' => ['isim' => 'E202 (Potasyum Sorbat)', 'risk_degeri' => 1, 'zarar_nedeni' => 'Koruyucu madde, genellikle güvenli ancak yüksek dozlarda cilt ve göz tahrişine neden olabilir.'],
        'E220' => ['isim' => 'E220 (Sülfür Dioksit)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Koruyucu madde, astım ve solunum sorunlarına neden olabilir. Özellikle astım hastaları için tehlikelidir. Bronşit ve nefes darlığına yol açabilir.'],
        'E249' => ['isim' => 'E249 (Potasyum Nitrit)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrit, kanser riski taşır. Yüksek sıcaklıkta nitrozaminlere dönüşebilir. Methemoglobinemiye neden olabilir.'],
        'E252' => ['isim' => 'E252 (Potasyum Nitrat)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrat, vücutta nitrite dönüşerek kanser riski taşır. Yüksek dozlarda sağlık sorunlarına yol açabilir.'],
        'E320' => ['isim' => 'E320 (BHA - Butillenmiş Hidroksianisol)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Antioksidan, kanser riski taşıyabilir. Hayvan çalışmalarında tümör oluşumu ile ilişkilendirilmiştir. Hormon dengesini etkileyebilir.'],
        'E321' => ['isim' => 'E321 (BHT - Butillenmiş Hidroksitoluen)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Antioksidan, kanser riski taşıyabilir. Karaciğer ve böbrek fonksiyonlarını etkileyebilir. Hormon dengesini bozabilir.'],
        'E407' => ['isim' => 'E407 (Karragenan)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Kıvam arttırıcı, sindirim sorunlarına ve bağırsak iltihabına neden olabilir. Hassas bireylerde mide rahatsızlığı yaratabilir.'],
        
        // Diğer zararlı maddeler
        'Trans yağ' => ['isim' => 'Trans Yağ', 'risk_degeri' => 5, 'zarar_nedeni' => 'Kalp hastalıkları riskini artırır. LDL (kötü) kolesterolü yükseltir, HDL (iyi) kolesterolü düşürür. Tip 2 diyabet riskini artırır. İnme ve kalp krizi riskini yükseltir. Özellikle kardiyovasküler sağlık için zararlıdır.'],
        'Trans Yağ' => ['isim' => 'Trans Yağ', 'risk_degeri' => 5, 'zarar_nedeni' => 'Kalp hastalıkları riskini artırır. LDL (kötü) kolesterolü yükseltir, HDL (iyi) kolesterolü düşürür. Tip 2 diyabet riskini artırır. İnme ve kalp krizi riskini yükseltir. Özellikle kardiyovasküler sağlık için zararlıdır.'],
        'Fruktoz şurubu' => ['isim' => 'Fruktoz Şurubu (Yüksek Fruktozlu Mısır Şurubu)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Obezite ve diyabet riski. Karaciğer yağlanmasına neden olur. İnsülin direncini artırır. Metabolik sendrom riskini yükseltir. Aşırı tüketimi karaciğer hastalıklarına yol açabilir.'],
        'Fruktoz Şurubu' => ['isim' => 'Fruktoz Şurubu (Yüksek Fruktozlu Mısır Şurubu)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Obezite ve diyabet riski. Karaciğer yağlanmasına neden olur. İnsülin direncini artırır. Metabolik sendrom riskini yükseltir. Aşırı tüketimi karaciğer hastalıklarına yol açabilir.'],
        'Aspartam' => ['isim' => 'Aspartam', 'risk_degeri' => 3, 'zarar_nedeni' => 'Yapay tatlandırıcı, nörolojik sorunlara yol açabilir. Fenilketonüri (PKU) hastaları için tehlikelidir. Migren, baş dönmesi ve nörolojik semptomlarla ilişkilendirilmiştir. Bazı çalışmalar baş ağrısı ve mide rahatsızlığı ile ilişkilendirmiştir.'],
        'MSG' => ['isim' => 'MSG (Monosodyum Glutamat)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Alerjen tetikleyici, migren yapabilir. Bazı kişilerde "Çin Restoranı Sendromu" adı verilen semptomlara (baş ağrısı, mide bulantısı, terleme) neden olabilir. Nörolojik hassasiyeti olan kişilerde sorun yaratabilir.'],
        'Sakarin' => ['isim' => 'Sakarin', 'risk_degeri' => 3, 'zarar_nedeni' => 'Yapay tatlandırıcı, bazı çalışmalarda mesane kanseri riski ile ilişkilendirilmiştir. Hamile kadınlar için önerilmez.'],
        'Sukraloz' => ['isim' => 'Sukraloz', 'risk_degeri' => 1, 'zarar_nedeni' => 'Yapay tatlandırıcı, bağırsak mikrobiyotasını etkileyebilir. Bazı kişilerde mide rahatsızlığı yaratabilir.'],
        'Acesulfam K' => ['isim' => 'Acesulfam K', 'risk_degeri' => 1, 'zarar_nedeni' => 'Yapay tatlandırıcı, bazı çalışmalarda metabolik etkileri olduğu gösterilmiştir.'],
        'Sodyum Sülfit' => ['isim' => 'Sodyum Sülfit', 'risk_degeri' => 3, 'zarar_nedeni' => 'Koruyucu madde, astım ve solunum sorunlarına neden olabilir. Özellikle astım hastaları için tehlikelidir.'],
        'Hidrojene yağ' => ['isim' => 'Hidrojene Yağ', 'risk_degeri' => 5, 'zarar_nedeni' => 'Trans yağ içerebilir. Kalp hastalıkları riskini artırır. LDL kolesterolü yükseltir.'],
        'Hidrojene bitkisel yağ' => ['isim' => 'Hidrojene Bitkisel Yağ', 'risk_degeri' => 5, 'zarar_nedeni' => 'Trans yağ içerebilir. Kalp hastalıkları riskini artırır. Kardiyovasküler sağlık için zararlıdır.'],
        'Palm yağı' => ['isim' => 'Palm Yağı', 'risk_degeri' => 3, 'zarar_nedeni' => 'Yüksek doymuş yağ içeriği. LDL kolesterolü yükseltebilir. Çevresel etkileri de bulunmaktadır. Aşırı tüketimi kalp sağlığı için risk oluşturabilir.'],
        'Palm Yağı' => ['isim' => 'Palm Yağı', 'risk_degeri' => 3, 'zarar_nedeni' => 'Yüksek doymuş yağ içeriği. LDL kolesterolü yükseltebilir. Çevresel etkileri de bulunmaktadır. Aşırı tüketimi kalp sağlığı için risk oluşturabilir.'],
        'Glutamat' => ['isim' => 'Glutamat', 'risk_degeri' => 3, 'zarar_nedeni' => 'MSG benzeri etkiler. Migren ve baş ağrısı yapabilir. Nörolojik hassasiyeti olan kişilerde sorun yaratabilir.'],
        'Sodyum Glutamat' => ['isim' => 'Sodyum Glutamat', 'risk_degeri' => 3, 'zarar_nedeni' => 'MSG benzeri etkiler. Alerjen tetikleyici, migren yapabilir.'],
        'Nitrit' => ['isim' => 'Nitrit', 'risk_degeri' => 5, 'zarar_nedeni' => 'Kanser riski taşır. Yüksek sıcaklıkta nitrozaminlere dönüşebilir. Özellikle işlenmiş et ürünlerinde risklidir.'],
        'Nitrat' => ['isim' => 'Nitrat', 'risk_degeri' => 5, 'zarar_nedeni' => 'Vücutta nitrite dönüşerek kanser riski taşır. Yüksek dozlarda sağlık sorunlarına yol açabilir.'],
        'Benzoat' => ['isim' => 'Benzoat', 'risk_degeri' => 3, 'zarar_nedeni' => 'Koruyucu madde, C vitamini ile birleştiğinde benzen oluşturabilir (kanserojen). Alerji riski taşır.'],
        'Sülfit' => ['isim' => 'Sülfit', 'risk_degeri' => 3, 'zarar_nedeni' => 'Astım ve solunum sorunlarına neden olabilir. Özellikle astım hastaları için tehlikelidir.'],
        'BHA' => ['isim' => 'BHA (Butillenmiş Hidroksianisol)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Antioksidan, kanser riski taşıyabilir. Hayvan çalışmalarında tümör oluşumu ile ilişkilendirilmiştir. Hormon dengesini etkileyebilir.'],
        'BHT' => ['isim' => 'BHT (Butillenmiş Hidroksitoluen)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Antioksidan, kanser riski taşıyabilir. Karaciğer ve böbrek fonksiyonlarını etkileyebilir. Hormon dengesini bozabilir.'],
        'Karragenan' => ['isim' => 'Karragenan', 'risk_degeri' => 3, 'zarar_nedeni' => 'Kıvam arttırıcı, sindirim sorunlarına ve bağırsak iltihabına neden olabilir. Hassas bireylerde mide rahatsızlığı yaratabilir.'],
        'Sorbat' => ['isim' => 'Sorbat', 'risk_degeri' => 1, 'zarar_nedeni' => 'Koruyucu madde, genellikle güvenli kabul edilir ancak hassas bireylerde cilt tahrişine neden olabilir.'],
        'Tartrazin' => ['isim' => 'Tartrazin (E102)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Sarı renklendirici, hiperaktivite ve alerji riski. Astım ve egzama semptomlarını tetikleyebilir. Özellikle çocuklarda dikkat eksikliği ve hiperaktivite bozukluğu ile ilişkilendirilmiştir.'],
        'Siklamat' => ['isim' => 'Siklamat', 'risk_degeri' => 3, 'zarar_nedeni' => 'Yapay tatlandırıcı, bazı ülkelerde yasaklanmıştır. Mesane kanseri riski ile ilişkilendirilmiştir.'],
        'Neotam' => ['isim' => 'Neotam', 'risk_degeri' => 1, 'zarar_nedeni' => 'Yapay tatlandırıcı, aspartam türevi. Fenilketonüri (PKU) hastaları için dikkatli olunmalıdır.'],
        
        // Şeker ve Şuruplar
        'Şeker' => ['isim' => 'İlave Şeker', 'risk_degeri' => 2, 'zarar_nedeni' => 'Aşırı tüketimi obezite, diyabet ve kalp hastalıkları riskini artırır. Kan şekerinde ani dalgalanmalara neden olur.'],
        'Glikoz şurubu' => ['isim' => 'Glikoz Şurubu', 'risk_degeri' => 4, 'zarar_nedeni' => 'Yüksek glisemik indekse sahiptir. Kan şekerini hızla yükseltir. Obezite ve insülin direnci riskini artırır.'],
        'Glikoz-Fruktoz şurubu' => ['isim' => 'Glikoz-Fruktoz Şurubu', 'risk_degeri' => 5, 'zarar_nedeni' => 'Vücut tarafından şekerden farklı işlenir. Karaciğer yağlanması, obezite ve diyabet riskini önemli ölçüde artırır.'],
        'Mısır şurubu' => ['isim' => 'Mısır Şurubu', 'risk_degeri' => 5, 'zarar_nedeni' => 'Genellikle GDO\'lu mısırdan üretilir. Fruktoz içeriği yüksek olabilir. Metabolik sendrom riskini artırır.'],
        'Maltodekstrin' => ['isim' => 'Maltodekstrin', 'risk_degeri' => 3, 'zarar_nedeni' => 'Çok yüksek glisemik indekse sahiptir (şekerden bile yüksek). Kan şekerini aniden yükseltir. Bağırsak florasını olumsuz etkileyebilir.'],
        'İnvert şeker' => ['isim' => 'İnvert Şeker', 'risk_degeri' => 3, 'zarar_nedeni' => 'Sofra şekerine göre daha tatlıdır ve kan şekerini hızla etkiler. Aşırı kalori alımına neden olabilir.'],
        
        // Diğer Yağlar
        'Margarin' => ['isim' => 'Margarin', 'risk_degeri' => 4, 'zarar_nedeni' => 'İşlenmiş bitkisel yağdır. Trans yağ içerme riski yüksektir. Enflamasyonu artırabilir.'],
        'Kanola yağı' => ['isim' => 'Kanola Yağı', 'risk_degeri' => 2, 'zarar_nedeni' => 'Genellikle rafine edilmiş ve GDO\'lu tohumlardan elde edilir. Yüksek oranda omega-6 içerir, bu da vücutta iltihaplanmayı artırabilir.'],
        'Ayçiçek yağı' => ['isim' => 'Ayçiçek Yağı', 'risk_degeri' => 1, 'zarar_nedeni' => 'Yüksek omega-6 içeriği nedeniyle aşırı tüketimi enflamasyonu tetikleyebilir. Rafine edilmiş versiyonları besin değerini yitirmiştir.'],
        
        // Eş anlamlılar ve Tersine Aramalar (İsim -> E Kodu eşleşmesi için)
        'Monosodyum Glutamat' => ['isim' => 'E621 (Monosodyum Glutamat - MSG)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Alerjen tetikleyici, migren ve baş ağrısı yapabilir. Bazı kişilerde "Çin Restoranı Sendromu" adı verilen semptomlara (baş ağrısı, mide bulantısı, terleme) neden olabilir. Nörolojik hassasiyeti olan kişilerde sorun yaratabilir.'],
        'Sodyum Benzoat' => ['isim' => 'E211 (Sodyum Benzoat)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Koruyucu madde, alerji riski taşır. C vitamini ile birleştiğinde benzen oluşturabilir (kanserojen). Astım ve hiperaktivite ile ilişkilendirilmiştir. Hassas bireylerde alerjik reaksiyonlara neden olabilir.'],
        'Sodyum Nitrit' => ['isim' => 'E250 (Sodyum Nitrit)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrit, yüksek sıcaklıkta nitrozaminlere dönüşerek kanser riski taşır. Özellikle işlenmiş et ürünlerinde kullanılır. Yüksek dozlarda methemoglobinemiye (oksijen taşıma sorunu) neden olabilir. Çocuklar için daha risklidir.'],
        'Sodyum Nitrat' => ['isim' => 'E251 (Sodyum Nitrat)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrat, vücutta nitrite dönüşerek kanser riski taşır. Özellikle işlenmiş et ürünlerinde kullanılır. Yüksek dozlarda tüketildiğinde sağlık sorunlarına yol açabilir. Hamile kadınlar ve çocuklar için özellikle dikkatli olunmalıdır.'],
        'Potasyum Sorbat' => ['isim' => 'E202 (Potasyum Sorbat)', 'risk_degeri' => 1, 'zarar_nedeni' => 'Koruyucu madde, genellikle güvenli ancak yüksek dozlarda cilt ve göz tahrişine neden olabilir.'],
        'Sülfür Dioksit' => ['isim' => 'E220 (Sülfür Dioksit)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Koruyucu madde, astım ve solunum sorunlarına neden olabilir. Özellikle astım hastaları için tehlikelidir. Bronşit ve nefes darlığına yol açabilir.'],
        'Potasyum Nitrit' => ['isim' => 'E249 (Potasyum Nitrit)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrit, kanser riski taşır. Yüksek sıcaklıkta nitrozaminlere dönüşebilir. Methemoglobinemiye neden olabilir.'],
        'Potasyum Nitrat' => ['isim' => 'E252 (Potasyum Nitrat)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Nitrat, vücutta nitrite dönüşerek kanser riski taşır. Yüksek dozlarda sağlık sorunlarına yol açabilir.'],
        'Butillenmiş Hidroksianisol' => ['isim' => 'E320 (BHA - Butillenmiş Hidroksianisol)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Antioksidan, kanser riski taşıyabilir. Hayvan çalışmalarında tümör oluşumu ile ilişkilendirilmiştir. Hormon dengesini etkileyebilir.'],
        'Butillenmiş Hidroksitoluen' => ['isim' => 'E321 (BHT - Butillenmiş Hidroksitoluen)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Antioksidan, kanser riski taşıyabilir. Karaciğer ve böbrek fonksiyonlarını etkileyebilir. Hormon dengesini bozabilir.'],
        'Sunset Yellow' => ['isim' => 'E110 (Sunset Yellow)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Turuncu renklendirici, alerji ve hiperaktivite riski. Astım ve egzama semptomlarını tetikleyebilir. Çocuklarda davranış sorunlarına yol açabilir.'],
        'Tartrazin' => ['isim' => 'E102 (Tartrazin)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Sarı renklendirici, hiperaktivite ve alerji riski. Astım ve egzama semptomlarını tetikleyebilir. Özellikle çocuklarda dikkat eksikliği ve hiperaktivite bozukluğu ile ilişkilendirilmiştir.'],
        'Kinolin Sarısı' => ['isim' => 'E104 (Kinolin Sarısı)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Sarı renklendirici, alerji ve hiperaktivite riski. Hassas bireylerde alerjik reaksiyonlara neden olabilir. Bazı ülkelerde kullanımı kısıtlanmıştır.'],
        'Allura Red' => ['isim' => 'E129 (Allura Red AC)', 'risk_degeri' => 3, 'zarar_nedeni' => 'Kırmızı renklendirici, alerji ve hiperaktivite riski. Özellikle çocuklarda dikkat sorunlarına yol açabilir.'],
        'Brilliant Blue' => ['isim' => 'E133 (Brilliant Blue FCF)', 'risk_degeri' => 1, 'zarar_nedeni' => 'Mavi renklendirici, alerji riski. Hassas bireylerde alerjik reaksiyonlara neden olabilir.'],
        'Amonyak Sülfit' => ['isim' => 'E150d (Karamel IV - Amonyak Sülfit Prosesi)', 'risk_degeri' => 5, 'zarar_nedeni' => 'Kanserojen risk taşır. Amonyak sülfit prosesi ile üretilen karamel, 4-metilimidazol (4-MEI) içerebilir. Bu madde hayvan çalışmalarında kanser riski oluşturmuştur.'],
    ];
}

/**
 * İçerikleri parse et - Parantez içindeki virgülleri korur
 */
function parseIngredients($icerik_metni) {
    if (empty($icerik_metni)) {
        return [];
    }
    
    // JSON ise decode et
    $decoded = json_decode($icerik_metni, true);
    if ($decoded && is_array($decoded)) {
        return array_filter(array_map('trim', $decoded), function($item) {
            return !empty($item) && strlen(trim($item)) > 0;
        });
    }
    
    // Parantez içindeki virgülleri koruyarak ayır
    $icerikler = [];
    $current = '';
    $depth = 0;
    
    for ($i = 0; $i < strlen($icerik_metni); $i++) {
        $char = $icerik_metni[$i];
        
        if ($char === '(' || $char === '[' || $char === '{') {
            $depth++;
            $current .= $char;
        } elseif ($char === ')' || $char === ']' || $char === '}') {
            $depth--;
            $current .= $char;
        } elseif ($char === ',' && $depth === 0) {
            // Sadece en üst seviyedeki virgüllerde ayır
            $trimmed = trim($current);
            if (!empty($trimmed)) {
                $icerikler[] = $trimmed;
            }
            $current = '';
        } else {
            $current .= $char;
        }
    }
    
    // Son parçayı ekle
    $trimmed = trim($current);
    if (!empty($trimmed)) {
        $icerikler[] = $trimmed;
    }
    
    return array_filter(array_map('trim', $icerikler), function($item) {
        return !empty($item) && strlen(trim($item)) > 0;
    });
}

/**
 * Riskli içerikleri tespit et
 */
function detectHarmfulIngredients($icerikler) {
    $zarar_sozlugu = getHarmfulIngredientsDictionary();
    $riskli_icerikler = [];
    
    foreach ($icerikler as $icerik) {
        $icerik_lower = mb_strtolower(trim($icerik), 'UTF-8');
        $bulundu = false;
        
        // Önce tam eşleşme veya içerik içinde geçme kontrolü (Anahtar kelimeler)
        foreach ($zarar_sozlugu as $riskli_madde => $zarar_info) {
            $riskli_madde_lower = mb_strtolower(trim($riskli_madde), 'UTF-8');
            
            // 1. Durum: Sözlükteki anahtar içerik metninin içinde geçiyor mu?
            // Örnek: İçerik="Koruyucu (E250)", Anahtar="E250" -> EŞLEŞİR
            // 2. Durum: İçerik metni sözlükteki anahtarın içinde geçiyor mu?
            // Örnek: İçerik="Sodyum Nitrit", Anahtar="Sodyum Nitrit" -> EŞLEŞİR
            // 3. Durum: E kodu içeren uzun açıklama durumu
            // Örnek: İçerik="E250: Sodyum Nitrit", Anahtar="E250" -> EŞLEŞİR
            
            if (stripos($icerik_lower, $riskli_madde_lower) !== false || 
                stripos($icerik, $riskli_madde) !== false) {
                
                $zarar_nedeni = is_array($zarar_info) ? $zarar_info['zarar_nedeni'] : $zarar_info;
                $risk_isim = is_array($zarar_info) ? $zarar_info['isim'] : $riskli_madde;
                $risk_degeri = is_array($zarar_info) && isset($zarar_info['risk_degeri']) ? $zarar_info['risk_degeri'] : 1;
                
                // Tekrar kontrolü - aynı isimde madde eklenmiş mi?
                $eklenmis = false;
                foreach ($riskli_icerikler as $ekli) {
                    if ($ekli['isim'] === $risk_isim) {
                        $eklenmis = true;
                        break;
                    }
                }
                
                if (!$eklenmis) {
                    $riskli_icerikler[] = [
                        'isim' => $risk_isim,
                        'risk_degeri' => $risk_degeri,
                        'zarar_nedeni' => $zarar_nedeni
                    ];
                    $bulundu = true;
                    // Bir içerik için bir risk bulduysak diğerlerini aramaya devam edelim mi? 
                    // Genellikle evet, çünkü birden fazla riskli madde aynı satırda olabilir.
                    // Ancak aynı riskin farklı varyasyonlarını eklememek için yukarıdaki "eklenmis" kontrolü önemli.
                }
            }
        }
        
        // E kodlarını otomatik tespit et (Eğer sözlükte yoksa bile genel uyarı ver)
        if (preg_match_all('/\bE-?\d{3,4}[a-z]?\b/i', $icerik, $matches)) {
            foreach ($matches[0] as $match) {
                $e_kodu = strtoupper($match);
                $e_kodu_clean = str_replace('-', '', $e_kodu);
                
                // Zaten eklenmiş mi kontrol et (İsim veya kod olarak)
                $zaten_var = false;
                foreach ($riskli_icerikler as $r) {
                    if (strpos($r['isim'], $e_kodu_clean) !== false) {
                        $zaten_var = true;
                        break;
                    }
                }
                
                if (!$zaten_var && !isset($zarar_sozlugu[$e_kodu_clean])) {
                    // Zararlı E kodları listesi (Sözlükte olmayan ama potansiyel riskli olanlar)
                    $zararli_e_kodlari = ['E102', 'E104', 'E110', 'E122', 'E124', 'E129', 'E133', 'E142', 
                                         'E150d', 'E211', 'E220', 'E249', 'E250', 'E251', 'E252', 
                                         'E320', 'E321', 'E407', 'E621', 'E951', 'E950', 'E952', 'E954'];
                    
                    if (in_array($e_kodu_clean, $zararli_e_kodlari)) {
                         $riskli_icerikler[] = [
                            'isim' => $e_kodu . ' (Riskli Katkı Maddesi)',
                            'risk_degeri' => 3,
                            'zarar_nedeni' => 'Bu katkı maddesi potansiyel sağlık riski taşıyabilir. Alerji veya hassasiyet yaratabilir.'
                        ];
                    }
                }
            }
        }
    }
    
    return $riskli_icerikler;
}

/**
 * Ağırlıklı Sağlık Skoru Hesaplama
 * Başlangıç puanı: 100
 * Her zararlı madde için risk_degeri kadar puan düşülür
 * Puan asla 0'ın altına düşmez
 * 
 * @param array $riskli_icerikler Tespit edilen zararlı içerikler dizisi
 * @return int 0-100 arası sağlık skoru
 */
function calculateWeightedHealthScore($riskli_icerikler) {
    // Başlangıç puanı
    $puan = 100;
    $risk_5_var = false;
    
    // Her zararlı madde için risk değerine göre agresif puan düşüşü
    foreach ($riskli_icerikler as $riskli) {
        $risk_degeri = isset($riskli['risk_degeri']) ? (int)$riskli['risk_degeri'] : 1;
        
        // Puan kırma mantığı (Daha gerçekçi sonuçlar için artırıldı)
        // Risk 5 (Yüksek): 30 puan düş (Kanserojen, Trans Yağ vb.)
        // Risk 3 (Orta): 15 puan düş (Alerjen, Şüpheli vb.)
        // Risk 1 (Düşük): 5 puan düş
        if ($risk_degeri >= 5) {
            $dusulecek_puan = 30;
            $risk_5_var = true;
        } elseif ($risk_degeri >= 3) {
            $dusulecek_puan = 15;
        } else {
            $dusulecek_puan = 5;
        }
        
        $puan -= $dusulecek_puan;
    }
    
    // Eğer 3'ten fazla riskli madde varsa ekstra ceza (-15 puan)
    if (count($riskli_icerikler) > 3) {
        $puan -= 15;
    }

    // Eğer Yüksek Riskli (Risk 5) madde varsa, puan en fazla 45 olabilir.
    if ($risk_5_var && $puan > 45) {
        $puan = 45;
    }

    // Puan asla 0'ın altına düşmemeli
    return max(0, $puan);
}

/**
 * Sağlık Uyarılarını Getir
 * Özellikle çocuklar ve hamileler için
 */
function getHealthWarnings($riskli_icerikler) {
    $uyarilar = [];
    $hamile_riski = false;
    $cocuk_riski = false;
    
    // Riskli içerikleri tara
    foreach ($riskli_icerikler as $riskli) {
        $neden = mb_strtolower($riskli['zarar_nedeni'] ?? '', 'UTF-8');
        $isim = mb_strtolower($riskli['isim'] ?? '', 'UTF-8');
        
        // Hamilelik riski anahtar kelimeleri
        if (strpos($neden, 'hamile') !== false || 
            strpos($isim, 'sakar') !== false || // Sakarin
            strpos($isim, 'kafein') !== false ||
            strpos($isim, 'çin tuzu') !== false ||
            strpos($neden, 'nörolojik') !== false) {
            $hamile_riski = true;
        }
        
        // Çocuk riski anahtar kelimeleri
        if (strpos($neden, 'hiperaktivite') !== false || 
            strpos($neden, 'dikkat eksikliği') !== false || 
            strpos($neden, 'çocuk') !== false ||
            strpos($isim, 'e102') !== false || 
            strpos($isim, 'e104') !== false || 
            strpos($isim, 'e110') !== false || 
            strpos($isim, 'e122') !== false || 
            strpos($isim, 'e124') !== false || 
            strpos($isim, 'e129') !== false || // Renklendiriciler
            strpos($isim, 'msg') !== false ||
            strpos($isim, 'nitrit') !== false) {
            $cocuk_riski = true;
        }
    }
    
    if ($cocuk_riski) {
        $uyarilar[] = "Dikkat: Bu ürün, çocuklarda hiperaktivite ve dikkat eksikliğine yol açabilecek veya gelişimlerini olumsuz etkileyebilecek bileşenler içermektedir. Çocukların tüketmesi önerilmemektedir.";
    }
    
    if ($hamile_riski) {
        $uyarilar[] = "Dikkat: Bu ürün, hamile kadınlar ve gelişmekte olan fetüs için risk oluşturabilecek bileşenler içermektedir. Tüketilmesi önerilmemektedir.";
    }
    
    return $uyarilar;
}

?>