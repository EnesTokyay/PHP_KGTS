<?php
// Hata ayıklamayı aç (Beyaz ekranı engellemek için)
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kişisel Gelişim Takip Sistemi</title>
    <style>
        body { font-family: sans-serif; text-align: center; background-color: #f4f4f4; }
        .container { margin-top: 50px; }
        .card { 
            display: inline-block; width: 250px; padding: 20px; margin: 20px;
            background: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-decoration: none; color: #333; transition: 0.3s;
        }
        .card:hover { transform: translateY(-5px); }
        .beslenme { border-top: 5px solid #27ae60; }
        .uyku { border-top: 5px solid #2980b9; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kişisel Gelişim Takip Sistemi</h1>
        <p>Gelişimini takip etmek istediğin modülü seç:</p>

        <!-- Senin Modülün -->
        <a href="beslenme.php" class="card beslenme">
            <h2>🍎 Beslenme & Su</h2>
            <p>Günlük hidrasyon ve öğün takibi yapın.</p>
        </a>

        <!-- Arkadaşının Modülü (Boş sayfaya açılacak) -->
        <a href="uyku.php" class="card uyku">
            <h2>😴 Uyku Düzeni</h2>
            <p>Günlük gerekli uyku takibinizi yapın...</p>
        </a>
    </div>
</body>
</html>