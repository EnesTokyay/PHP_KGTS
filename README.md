# 🌿 Health Dashboard: Hidrasyon & Uyku Takip Sistemi

Bu proje, kullanıcıların günlük su tüketimi ve uyku düzenlerini takip etmelerini sağlayan, PHP tabanlı modern bir sağlık yönetim dashboard'udur. Veritabanı gerektirmeyen yapısı sayesinde kolayca taşınabilir ve her PHP sunucusunda (XAMPP vb.) çalıştırılabilir.

## 🚀 Öne Çıkan Özellikler

- **Çift Modüllü Takip:** Su tüketimi ve uyku verilerini (saat/kalite) aynı panel üzerinden yönetme.
- **Dinamik Geri Bildirim:** PHP algoritmaları ile kullanıcı verilerine göre anlık motivasyonel mesajlar.
- **Canlı İlerleme Çubukları:** PHP ile hesaplanan hedeflere göre (Su: 3000ml, Uyku: 8 saat) görsel ilerleme takibi.
- **UX Odaklı Arayüz:** Tailwind CSS ile tasarlanmış, mobil uyumlu ve modern "Health-App" estetiği.
- **Durum Yönetimi:** `$_POST` metodolojisi ve `hidden input` kullanımı ile sayfa yenilense bile veri kaybını önleyen mimari.

## 🛠️ Teknik Altyapı

- **Backend:** PHP 8.x
- **Frontend:** HTML5, Tailwind CSS
- **İkon Seti:** Google Material Symbols
- **Tipografi:** Manrope & Inter Fonts

## 📂 Dosya Yapısı

- `beslenme.php`: Su ve Uyku modüllerinin bir arada bulunduğu ana uygulama dosyası.
- `index.php`: Uygulamanın giriş sayfası (Geri butonu buraya yönlendirir).
- `README.md`: Proje dokümantasyonu.

## 🔧 Kurulum ve Çalıştırma

1. Bilgisayarınızda **XAMPP** veya benzeri bir PHP sunucusu kurulu olduğundan emin olun.
2. Proje dosyalarını sunucunuzun root dizinine (genellikle `htdocs`) bir klasör içinde kopyalayın.
3. Tarayıcınızın adres çubuğuna `http://localhost/klasor_adiniz/beslenme.php` yazarak uygulamayı başlatın.

## 💡 Teknik Detaylar

### Veri Taşıma Mantığı (State Management)
Bu projede veriler veritabanı yerine PHP'nin form işleme yetenekleri ile taşınır. Özellikle mevcut su verisi şu şekilde korunur:
```php
<input name="mevcut_su" type="hidden" value="<?php echo $toplam_su; ?>"/>
