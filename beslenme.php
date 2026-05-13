<?php
// --- MANTIK BÖLÜMÜ (BACKEND) ---
$toplam_su = isset($_POST['mevcut_su']) ? (int)$_POST['mevcut_su'] : 0;
$eklenen = isset($_POST['ekle']) ? (int)$_POST['ekle'] : 0;
$secilen_ogunler = isset($_POST['ogun']) ? $_POST['ogun'] : [];

// Sıfırlama Kontrolü
if (isset($_POST['islem']) && $_POST['islem'] == "0") {
    $toplam_su = 0;
    $secilen_ogunler = [];
} else {
    $toplam_su += $eklenen;
}

$hedef_su = 3000;
$yuzde_su = ($toplam_su / $hedef_su) * 100;
if ($yuzde_su > 100) $yuzde_su = 100;

// 1. SU BİLDİRİM MANTIĞI
$su_durum = "Su içmeye başla!";
if ($toplam_su >= 3000) $su_durum = "Hidrasyon zirvede! 🌊";
elseif ($toplam_su >= 1500) $su_durum = "Yarıyı geçtin! 🥤";
elseif ($toplam_su > 0) $su_durum = "Devam et! 💧";

// 2. BESLENME BİLDİRİM MANTIĞI
$ogun_sayisi = count($secilen_ogunler);
$beslenme_durum = "Henüz öğün girmedin.";
if ($ogun_sayisi >= 3) $beslenme_durum = "Düzenli beslenme! 🥗";
elseif ($ogun_sayisi >= 1) $beslenme_durum = "Enerji doluyorsun! 🍎";
?>

<!DOCTYPE html>
<html class="light" lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daily Wellness - Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Manrope:wght@600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9ff; }
        .meal-checkbox:checked + div { border-color: #6cf8bb; background-color: #eff4ff; }
        .meal-checkbox:checked + div .check-icon { opacity: 1; }
    </style>
</head>
<body class="text-[#0b1c30] min-h-screen pb-12">

<header class="fixed top-0 w-full z-50 flex justify-between items-center px-6 h-16 bg-white/70 backdrop-blur-xl shadow-sm">
    <a class="p-2 rounded-full hover:bg-slate-100 transition-all" href="index.php">
        <span class="material-symbols-outlined text-[#0058be]">arrow_back</span>
    </a>
    <h1 class="font-bold text-xl">Daily Wellness</h1>
    <div class="w-10"></div> </header>

<main class="pt-24 px-4 max-w-2xl mx-auto space-y-6">

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <span class="text-xs font-bold text-slate-400 uppercase">Su Durumu</span>
            <p class="text-lg font-bold text-[#0b1c30]"><?php echo $su_durum; ?></p>
        </div>
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <span class="text-xs font-bold text-slate-400 uppercase">Beslenme</span>
            <p class="text-lg font-bold text-[#0b1c30]"><?php echo $beslenme_durum; ?></p>
        </div>
    </div>

    <form method="POST" class="space-y-6">
        <input name="mevcut_su" type="hidden" value="<?php echo $toplam_su; ?>"/>

        <section class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-6">
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="text-xl font-bold">Su Tüketimi</h2>
                    <p class="text-sm text-slate-400">Hedef: 3000 ml</p>
                </div>
                <div class="text-right">
                    <span class="text-2xl font-bold text-[#0058be]"><?php echo $toplam_su; ?></span>
                    <span class="text-sm text-slate-400">/ 3000 ml</span>
                </div>
            </div>

            <div class="h-4 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[#0058be] to-[#006c49] transition-all duration-500" 
                     style="width: <?php echo $yuzde_su; ?>%;"></div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button class="bg-slate-50 border border-blue-100 text-[#0058be] font-bold py-4 rounded-2xl active:scale-95 transition-all" name="ekle" type="submit" value="250">+ 250 ml</button>
                <button class="bg-[#0058be] text-white font-bold py-4 rounded-2xl shadow-md active:scale-95 transition-all" name="ekle" type="submit" value="500">+ 500 ml</button>
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-xl font-bold px-2">Öğün Takibi</h2>
            <div class="grid grid-cols-2 gap-4">
                <?php 
                $og_list = ["Kahvaltı", "Öğle Yemeği", "Akşam Yemeği", "Ara Öğün"];
                foreach($og_list as $og): 
                    $checked = in_array($og, $secilen_ogunler) ? "checked" : "";
                ?>
                <label class="relative cursor-pointer group">
                    <input class="sr-only meal-checkbox" name="ogun[]" type="checkbox" value="<?php echo $og; ?>" <?php echo $checked; ?> onchange="this.form.submit()">
                    <div class="bg-white rounded-3xl p-5 border-2 border-slate-100 text-center transition-all h-full flex flex-col items-center gap-2">
                        <span class="font-bold text-sm"><?php echo $og; ?></span>
                        <div class="check-icon opacity-0 transition-opacity text-green-500">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="flex justify-center pt-4">
            <button class="px-8 py-3 rounded-full border border-slate-200 text-slate-400 text-sm hover:bg-red-50 hover:text-red-500 transition-all" name="islem" type="submit" value="0">
                Günü Sıfırla
            </button>
        </div>
    </form>
</main>

</body>
</html>