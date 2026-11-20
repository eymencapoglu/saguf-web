# SAGUF'26 — Sakarya Gençlik Ulusal Forumu Website & JSON CMS

*[English](#english) | [Türkçe](#türkçe)*

---

<a name="english"></a>
## English

### Overview
**SAGUF'26** is the official web platform and lightweight flat-file (JSON-backed) CMS built for the **Sakarya Gençlik Ulusal Forumu** (Sakarya Youth National Forum). Rather than requiring a SQL database, all dynamic site content — event countdown, committees, application cards, executive board, organization team, navigation bar, and page banners — is stored in structured JSON files managed through a custom admin dashboard (`admin/`) protected by a dedicated security layer (`security.php`).

### Development Timeline & Process
- **Initial Build:** June 20 – July 4, 2026 — Core frontend pages (`index.php`, `committees.php`, `committee.php`, `apply.php`, `executive.php`, `organization.php`, `contact.php`), JSON CMS structure, SEO (`sitemap.xml`, `robots.txt`), and security middleware (`security.php`).
- **Admin CMS & Updates:** August 14 – September 28, 2026 — Full admin editing modules (`edit_committee.php`, `edit_apply_card.php`, `edit_member.php`, `edit_organization.php`, `edit_page_banner.php`) and content updates for SAGUF'26.
- **Security & Cleanup:** The hardcoded admin password in `admin/login.php` has been replaced with `getenv('ADMIN_PASSWORD')` (see `.env.example`). Runtime rate-limit files, Google Search Console verification files, and a redundant nested backup directory were removed.

### Running Locally
```bash
export ADMIN_PASSWORD="your_secure_password"
php -S localhost:8000
```
Open `http://localhost:8000` (Admin panel: `http://localhost:8000/admin/login.php`).

### Acknowledgments & Open-Source Credits
- **[Google Fonts](https://fonts.google.com/)** (Cinzel & Montserrat) and **[Font Awesome](https://fontawesome.com/)**.

---

<a name="türkçe"></a>
## Türkçe

### Genel Bakış
**SAGUF'26 (Sakarya Gençlik Ulusal Forumu)** için geliştirilmiş, SQL veritabanı gerektirmeyen JSON tabanlı hafif içerik yönetim sistemli (CMS) web sitesidir. Etkinlik geri sayımı, komiteler, başvuru kartları, yürütme/organizasyon ekibi, menü ve sayfa afişleri JSON dosyaları üzerinden yönetilir; `security.php` güvenlik katmanı ve `admin/` paneli ile kolayca güncellenebilir.

### Geliştirme Süreci ve Tarihçesi
- **İlk Geliştirme:** 20 Haziran – 4 Temmuz 2026 — Ana sayfa, komiteler, başvuru, organizasyon ve güvenlik/SEO katmanı oluşturuldu.
- **Yönetim Paneli ve Güncellemeler:** 14 Ağustos – 28 Eylül 2026 — Tüm içerik düzenleme panelleri (`admin/`) ve ana sayfa güncellemeleri tamamlandı.
- **Güvenlik Temizliği:** `admin/login.php` içindeki sabit şifre kaldırılıp `ADMIN_PASSWORD` ortam değişkenine taşındı; geçici `rate_limit` dosyaları, arama motoru doğrulama dosyası ve mükerrer yedek klasörü temizlendi.

### Yerel Çalıştırma
```bash
export ADMIN_PASSWORD="guvenli_yonetici_sifresi"
php -S localhost:8000
```