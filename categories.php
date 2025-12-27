<?php

require_once 'config.php';

header('Content-Type: application/json; charset=utf-8');



try {

    // LEFT JOIN sayesinde boş olsa bile tüm kategoriler listelenir

    $stmt = $pdo->prepare("

        SELECT

            k.id,

            k.isim,

            COUNT(u.id) as urun_sayisi

        FROM kategoriler k

        LEFT JOIN urunler u ON k.id = u.kategori_id

        GROUP BY k.id, k.isim

        ORDER BY k.isim ASC

    ");

    $stmt->execute();

    $kategoriler = $stmt->fetchAll(PDO::FETCH_ASSOC);



    echo json_encode([

        'basari' => true,

        'kategoriler' => $kategoriler

    ], JSON_UNESCAPED_UNICODE);



} catch(PDOException $e) {

    echo json_encode(['basari' => false, 'hata' => $e->getMessage()], JSON_UNESCAPED_UNICODE);

}

?>