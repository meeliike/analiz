-- Ürün Talep/Moderasyon Sistemi SQL Dosyası
-- product_requests tablosu için SQL komutları

-- Tablo oluşturma (eğer yoksa)
CREATE TABLE IF NOT EXISTS product_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barcode VARCHAR(50) NOT NULL,
    product_name VARCHAR(255),
    brand VARCHAR(100),
    user_note TEXT,
    ingredients TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reviewed_at TIMESTAMP NULL,
    reviewed_by VARCHAR(100) NULL,
    admin_note TEXT NULL,
    
    -- İndeksler için performans optimizasyonu
    INDEX idx_barcode (barcode),
    INDEX idx_status (status),
    INDEX idx_requested_at (requested_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Örnek veriler (isteğe bağlı)
INSERT INTO product_requests (barcode, product_name, brand, ingredients, user_note) VALUES
('1234567890123', 'Örnek Çikolata', 'Örnek Marka', 'Şeker, kakao yağı, süt tozu', 'Bu bir test talebidir'),
('9876543210987', 'Test Ürünü', 'Test Markası', 'Su, şeker, aroma vericiler', 'Kullanıcı notu');

-- Admin paneli için kullanışlı view (isteğe bağlı)
CREATE OR REPLACE VIEW product_requests_summary AS
SELECT 
    id,
    barcode,
    product_name,
    brand,
    status,
    requested_at,
    reviewed_at,
    CASE 
        WHEN status = 'pending' THEN 'Beklemede'
        WHEN status = 'approved' THEN 'Onaylandı'
        WHEN status = 'rejected' THEN 'Reddedildi'
        ELSE status
    END as status_text,
    DATEDIFF(NOW(), requested_at) as days_pending
FROM product_requests
ORDER BY requested_at DESC;

-- Talep sayısı raporu (isteğe bağlı)
CREATE OR REPLACE VIEW request_stats AS
SELECT 
    brand,
    COUNT(*) as total_requests,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_count,
    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_count
FROM product_requests
GROUP BY brand
ORDER BY total_requests DESC;
