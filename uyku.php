<?php
// 1. Oturumu Başlat (Sayfa yenilense de sonucun kalması için)
session_start();

// Temizleme işlemi (Eğer kullanıcı sıfırlamak isterse)
if(isset($_GET['temizle'])){
    session_destroy();
    header("Location: index.php");
    exit();
}

// 2. Hesaplama Mantığı
if(isset($_POST['analiz'])){
    $y_saat = new DateTime($_POST['yatis']);
    $u_saat = new DateTime($_POST['uyanis']);
    
    // Gece yatıp sabah kalkma durumunu kontrol et (+1 gün ekle)
    if ($u_saat < $y_saat) { 
        $u_saat->modify('+1 day'); 
    }
    
    $fark = $y_saat->diff($u_saat);
    $toplam_saat = $fark->h;
    $dakika = $fark->i;
    
    // Uyku süresine göre onay/red ve renk belirleme
    if($toplam_saat < 7) {
        $sonuc = [
            'renk' => '#fbbf24', // Turuncu (Az)
            'durum' => 'Yetersiz Uyku ⚠️',
            'mesaj' => 'Bugün biraz bitkin hissedebilirsin. İdeal uykun için 7-8 saati hedeflemelisin. ☕',
            'sure' => $toplam_saat . ' Saat ' . $dakika . ' Dakika'
        ];
    } elseif($toplam_saat >= 7 && $toplam_saat <= 9) {
        $sonuc = [
            'renk' => '#22c55e', // Yeşil (İdeal)
            'durum' => 'Mükemmel Uyku ✅',
            'mesaj' => 'Harika bir iş çıkardın! Tam ihtiyacın olan uykuyu aldın, bugün senin günün! ✨',
            'sure' => $toplam_saat . ' Saat ' . $dakika . ' Dakika'
        ];
    } else {
        $sonuc = [
            'renk' => '#38bdf8', // Mavi (Fazla)
            'durum' => 'Fazla Uyku 💤',
            'mesaj' => 'Görünüşe göre bugün biraz fazla dinlenmişsin. Kalkıp enerjini atma vakti! 🚀',
            'sure' => $toplam_saat . ' Saat ' . $dakika . ' Dakika'
        ];
    }
    
    // Sonucu oturuma kaydet (Hafıza)
    $_SESSION['son_analiz'] = $sonuc;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kişisel Uyku Takip Sistemi | Erkut Yıldırım</title>
    
    <!-- Modern Tasarım Kütüphaneleri -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a; /* Gece mavisi arka plan */
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin: 0;
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 480px;
            margin: auto;
            position: relative;
        }
        .form-control {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
            color: white !important;
            text-align: center;
            border-radius: 12px;
            padding: 12px;
        }
        .btn-hesapla {
            background: linear-gradient(135deg, #38bdf8 0%, #1d4ed8 100%);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            color: white;
            padding: 14px;
            transition: transform 0.2s;
        }
        .btn-hesapla:hover {
            transform: scale(1.02);
            color: white;
        }
        .result-box {
            margin-top: 25px;
            padding: 20px;
            background: rgba(15, 23, 42, 0.6);
            border-radius: 16px;
            text-align: left;
            border-left: 5px solid;
        }
        /* AI Asistan Stili */
        .ai-assistant {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 300px;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 20px;
            padding: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
            z-index: 1000;
        }
        .ai-icon {
            width: 45px;
            height: 45px;
            background: #38bdf8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 22px;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.5);
        }
        .ai-text {
            font-size: 0.9rem;
            color: #e2e8f0;
            font-weight: 400;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="glass-card text-center">
        <h2 class="fw-bold mb-4">Kişisel Uyku Takip Sistemi</h2>
        
        <form action="" method="POST">
            <div class="row g-3 mb-4">
                <div class="col-6 text-start">
                    <label class="small text-secondary mb-2">Yatış Saati</label>
                    <input type="time" name="yatis" class="form-control" required>
                </div>
                <div class="col-6 text-start">
                    <label class="small text-secondary mb-2">Uyanış Saati</label>
                    <input type="time" name="uyanis" class="form-control" required>
                </div>
            </div>
            <button type="submit" name="analiz" class="btn btn-hesapla w-100">ANALİZ ET</button>
        </form>

        <?php
        // Oturumda veri varsa her zaman göster
        if(isset($_SESSION['son_analiz'])){
            $res = $_SESSION['son_analiz'];
            echo '<div class="result-box" style="border-left-color: '.$res['renk'].'">';
            echo '<div class="d-flex justify-content-between align-items-center mb-1">';
            echo '<span class="small text-secondary" style="color:'.$res['renk'].' !important">'.$res['durum'].'</span>';
            echo '<a href="?temizle=1" class="text-secondary" style="font-size:10px; text-decoration:none;">Sıfırla ✖</a>';
            echo '</div>';
            echo '<h3 class="fw-bold text-white mb-2">'.$res['sure'].'</h3>';
            echo '<p class="small mb-0 opacity-75">'.$res['mesaj'].'</p>';
            echo '</div>';
        }
        ?>

        <div class="mt-4 pt-3 border-top border-secondary opacity-25">
            <small style="font-size: 12px;"><b>Erkut Yıldırım</b></small>
        </div>
    </div>
</div>

<!-- Yapay Zeka Asistan Modülü -->
<div class="ai-assistant">
    <div class="ai-icon">🤖</div>
    <div class="ai-text" id="ai-quote">Mesaj yükleniyor...</div>
</div>

<script>
    window.onload = function() {
        const sozler = [
            "Günaydın! ☀️ Bugün harika işler başaracaksın! 🚀",
            "Biliyor muydun? 🧠 Uyku, hafızanı güçlendirir. ✨",
            "Zihnini tazeleme vakti! 💡",
            "Sağlık her şeydir! 💪",
            "Erken kalkan yol alır, uykusunu alan dünyayı fetheder! 🌍",
            "Biliyor muydun? 🧠 Kaliteli bir uyku, odaklanma gücünü %20 artırır! ✨",
            "Küçük bir tavsiye: ☕ Kahveden önce su içmek seni hızla uyandırır! 💧",
            "Bugün harika görünüyorsun! ✨ Enerjini yüksek tut. 🎯",
            "Derin bir nefes al ve gülümse... 😊 Günün tadını çıkar! 🌈",
            "Uyku, beyninin 'şarj olma' süresidir. 🔋 Bataryanı doldur! 🔌",
            "Stresle savaşmanın en tatlı yolu: Yumuşacık bir yastık ve huzur... 😴🌙"
        ];

        const aiTextElement = document.getElementById('ai-quote');
        if (aiTextElement) {
            const rastgeleSoz = sozler[Math.floor(Math.random() * sozler.length)];
            aiTextElement.innerText = rastgeleSoz;
        }
    };
</script>

</body>
</html>