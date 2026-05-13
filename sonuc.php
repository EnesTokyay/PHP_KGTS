<?php
// 1. Formdan gelen verileri "POST" yöntemiyle alıyoruz
$yatis = new DateTime($_POST['yatis_zamani']);
$uyanis = new DateTime($_POST['uyanis_zamani']);

// 2. PHP'nin "diff" (fark) özelliğini kullanarak aradaki süreyi buluyoruz
$fark = $yatis->diff($uyanis);

// Toplam kaç saat uyuduğunu sayıya çevirelim
$uyunan_saat = $fark->h + ($fark->days * 24); 

echo "<h2>Analiz Sonucu</h2>";
echo "Dün gece toplam <b>$uyunan_saat saat</b> uyudunuz.<br>";
echo "İdeal uyku süresi: <b>8 saat</b>.<br><br>";

// 3. İdeal süreyle karşılaştırma yapalım
if ($uyunan_saat < 8) {
    $eksik = 8 - $uyunan_saat;
    echo "İdeal uykunuzdan $eksik saat daha az uyumuşsunuz.";
} elseif ($uyunan_saat == 8) {
    echo "Tebrikler! Tam olarak ideal sürede uyudunuz.";
} else {
    $fazla = $uyunan_saat - 8;
    echo "İdeal süreden $fazla saat daha fazla uyumuşsunuz.";
}

echo "<br><br><a href='index.php'>Geri Dön</a>";
?>