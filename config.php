<?php
// config.php - Veritabanı bağlantı ayarları

// Hata raporlama (geliştirme ortamı için)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bilgileri
define('DB_HOST', 'localhost');
define('DB_NAME', 'paketli_gida_db');
define('DB_USER', 'root');
define('DB_PASS', 'mysql');

// Veritabanı bağlantısı
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die(json_encode(['hata' => 'Veritabanı bağlantı hatası: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE));
}

// JSON header (API için)
header('Content-Type: application/json; charset=utf-8');
?>