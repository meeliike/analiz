Proje Adı: Paketli Gıda Analiz Sistemi

**İş Tanımı:**
Kullanıcıların bir buton ile kamera izni vererek barkod tarattığı, ürün içeriğindeki riskli maddelerin üzerine tıklandığında sağlık üzerindeki etkilerini gösteren interaktif bir web arayüzü ve PHP API projesi oluşturulacaktır. Skor, ürünün içerdiği riskli maddelerin oranına göre LLM (yapay zeka) tarafından hesaplanacaktır.

Backend (PHP + MySQL) Gereksinimleri

API Yapısı: config.php, /product.php ve /analyze.php dosyalarından oluşmalıdır.

Veritabanı Yapısı (MySQL / phpMyAdmin):

Alan Adı	Tipi	Açıklama
id	INT AUTO_INCREMENT PRIMARY KEY	Ürün ID
barkod	VARCHAR(50)	Ürün barkodu
isim	VARCHAR(255)	Ürün adı
icerik	TEXT	Ürünün içerikleri (virgül veya JSON dizisi şeklinde)
gorsel_url	VARCHAR(255)	Ürünün görsel URL’si
kategori	VARCHAR(100)	Ürün kategorisi

Veri Çıktısı (JSON): /product.php?barcode=:barcode endpoint’i şu yapıda cevap dönecektir:

{
  "urun_adi": "Ürün Adı",
  "marka": "Marka",
  "kategori": "Atıştırmalık",
  "gorsel_url": "https://example.com/urun.jpg",
  "genel_skor": 85,
  "icerikler": ["Şeker", "E150d", "Tuz"],
  "riskli_icerikler": [
    {
      "isim": "E150d",
      "zarar_nedeni": "Kanserojen risk taşır"
    }
  ]
}


**Skor Hesaplama:**

Skor veritabanında saklanmayacak, her API çağrısında yapay zeka (LLM) tarafından ürünün riskli içerik oranına göre hesaplanacak.

Örneğin: riskli_madde_sayisi / toplam_madde_sayisi veya LLM’in belirlediği kriterlerle puanlama yapılacak.

Güvenlik: SQL Injection’a karşı parametreli sorgular (prepared statements) kullanılmalı. JSON çıktısı frontend’de XSS korumalı render edilmeli.

Dummy Zarar Sözlüğü: Riskli maddelerin sağlık üzerindeki etkilerini açıklayan örnek bir dizi oluşturulmalı (örn. E150d: “Kanserojen risk taşır”, E621: “Alerjen tetikleyici”).

Frontend (HTML5 + JS + Bootstrap 5) Gereksinimleri

Kamera Kontrolü: "Barkod Tara" butonuna basılmadan kamera açılmamalı; önce tarayıcı üzerinden izin istenmelidir.

Dinamik Arayüz: Tarama sonrası ürün bilgileri ekrana gelmelidir.

İçindekiler Listesi: Riskli maddeler görsel olarak (örn. sarı/turuncu altı çizili veya badge ile) belirtilmelidir.

Interaktif Etki: Kullanıcı riskli maddelerden birine tıkladığında, hemen altında (accordion veya toggle mantığıyla) o maddenin neden zararlı olduğu ve insan sağlığı üzerindeki olası etkileri açıklanmalıdır.

Yapay Zeka (LLM) Talimatları

LLM, ürünün içerik listesi ve zarar sözlüğüne bakarak riskli içeriklerin sayısını ve oranını hesaplamalı, buna göre 0-100 puan olarak skor üretmeli.

Skor, API çağrısı sırasında JSON içinde yer almalı; veritabanına kaydedilmemeli.

Örnek: Eğer 3 içerikten 1’i riskliyse skor 66/100 gibi bir değere düşebilir.

Riskli içerikler JSON’da ayrıca belirtilmeli ve zarar nedenleri gösterilmeli.