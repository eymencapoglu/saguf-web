<?php
require_once __DIR__ . '/admin_auth.php';

$success_message = "";
$error_message = "";

// Form gönderildiğinde ayarları kaydet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_title = isset($_POST['event_title']) ? trim($_POST['event_title']) : "";
    $event_subtitle = isset($_POST['event_subtitle']) ? trim($_POST['event_subtitle']) : "";
    $countdown_target = isset($_POST['countdown_target']) ? trim($_POST['countdown_target']) : "";
    $apply_status = isset($_POST['apply_status']) ? 'open' : 'closed';
    $social_instagram = isset($_POST['social_instagram']) ? trim($_POST['social_instagram']) : "";
    $contact_email = isset($_POST['contact_email']) ? trim($_POST['contact_email']) : "";

    $highlights_active = isset($_POST['highlights_active']) ? '1' : '0';
    $highlights_title = isset($_POST['highlights_title']) ? trim($_POST['highlights_title']) : "";
    $hl_date_active = isset($_POST['hl_date_active']) ? '1' : '0';
    $hl_date_text = isset($_POST['hl_date_text']) ? trim($_POST['hl_date_text']) : "";
    $hl_location_active = isset($_POST['hl_location_active']) ? '1' : '0';
    $hl_location_text = isset($_POST['hl_location_text']) ? trim($_POST['hl_location_text']) : "";
    $hl_participants_active = isset($_POST['hl_participants_active']) ? '1' : '0';
    $hl_participants_text = isset($_POST['hl_participants_text']) ? trim($_POST['hl_participants_text']) : "";
    $hl_language_active = isset($_POST['hl_language_active']) ? '1' : '0';
    $hl_language_text = isset($_POST['hl_language_text']) ? trim($_POST['hl_language_text']) : "";

    if (empty($event_title) || empty($event_subtitle) || empty($countdown_target) || empty($contact_email)) {
        $error_message = "Lütfen zorunlu alanları eksiksiz doldurunuz.";
    } else {
        $new_settings = [
            "event_title" => $event_title,
            "event_subtitle" => $event_subtitle,
            "countdown_target" => $countdown_target,
            "apply_status" => $apply_status,
            "apply_url" => "apply.php",
            "social_instagram" => $social_instagram,
            "contact_email" => $contact_email,
            "highlights_active" => $highlights_active,
            "highlights_title" => $highlights_title,
            "hl_date_active" => $hl_date_active,
            "hl_date_text" => $hl_date_text,
            "hl_location_active" => $hl_location_active,
            "hl_location_text" => $hl_location_text,
            "hl_participants_active" => $hl_participants_active,
            "hl_participants_text" => $hl_participants_text,
            "hl_language_active" => $hl_language_active,
            "hl_language_text" => $hl_language_text
        ];

        $settings_file = __DIR__ . '/../settings.json';
        if (file_put_contents($settings_file, json_encode($new_settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            redirect("settings.php?success=saved");
        } else {
            $error_message = "Ayarlar kaydedilirken bir hata oluştu.";
        }
    }
}

// Başarı mesajı kontrolü
if (isset($_GET['success']) && $_GET['success'] === 'saved') {
    $success_message = "Site ayarları başarıyla güncellendi! Değişiklikler anında kamu sayfalarına yansıtıldı.";
}

// Güncel verileri yükle
$settings_path = __DIR__ . '/../settings.json';
$settings = [];
if (file_exists($settings_path)) {
    $settings = json_decode(file_get_contents($settings_path), true);
}

$title_val = $settings['event_title'] ?? "SAGUF'26";
$subtitle_val = $settings['event_subtitle'] ?? "SAKARYA GENÇLİK ULUSAL FORUMU";
$countdown_val = $settings['countdown_target'] ?? "2026-11-27T09:00:00";
$apply_val = ($settings['apply_status'] ?? 'open') === 'open';
$instagram_val = $settings['social_instagram'] ?? "";
$email_val = $settings['contact_email'] ?? "";

$hl_active_val = ($settings['highlights_active'] ?? '1') === '1';
$hl_title_val = $settings['highlights_title'] ?? "Konferans Bilgileri";
$hl_date_active_val = ($settings['hl_date_active'] ?? '1') === '1';
$hl_date_text_val = $settings['hl_date_text'] ?? "";
$hl_location_active_val = ($settings['hl_location_active'] ?? '1') === '1';
$hl_location_text_val = $settings['hl_location_text'] ?? "";
$hl_participants_active_val = ($settings['hl_participants_active'] ?? '1') === '1';
$hl_participants_text_val = $settings['hl_participants_text'] ?? "";
$hl_language_active_val = ($settings['hl_language_active'] ?? '1') === '1';
$hl_language_text_val = $settings['hl_language_text'] ?? "";

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-page-header">
    <h2>Site Ayarları</h2>
</div>

<?php if (!empty($success_message)): ?>
    <div class="admin-alert admin-alert-success">
        ✓ <?php echo $success_message; ?>
    </div>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <div class="admin-alert admin-alert-danger">
        ✗ <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<div class="admin-form-container">
    <form action="settings.php" method="POST">
        
        <!-- Etkinlik Adı -->
        <div class="admin-form-group">
            <label for="event_title">Etkinlik Adı (Başlık)</label>
            <input type="text" id="event_title" name="event_title" class="admin-form-control" value="<?php echo htmlspecialchars($title_val, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <!-- Etkinlik Alt Başlığı -->
        <div class="admin-form-group">
            <label for="event_subtitle">Etkinlik Alt Başlığı</label>
            <input type="text" id="event_subtitle" name="event_subtitle" class="admin-form-control" value="<?php echo htmlspecialchars($subtitle_val, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <!-- Geri Sayım Hedef Zamanı -->
        <div class="admin-form-group">
            <label for="countdown_target">Geri Sayım Hedef Zamanı (Etkinlik Zamanı)</label>
            <input type="datetime-local" id="countdown_target" name="countdown_target" class="admin-form-control" value="<?php echo htmlspecialchars($countdown_val, ENT_QUOTES, 'UTF-8'); ?>" required>
            <span style="font-size: 11px; color: #6c757d; display: block; margin-top: 5px;">Geri sayım sayacının hedef alacağı tarih ve saat. (Format: YYYY-MM-DDTHH:MM)</span>
        </div>

        <!-- İletişim E-postası -->
        <div class="admin-form-group">
            <label for="contact_email">İletişim E-posta Adresi</label>
            <input type="email" id="contact_email" name="contact_email" class="admin-form-control" value="<?php echo htmlspecialchars($email_val, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <!-- Instagram Linki -->
        <div class="admin-form-group">
            <label for="social_instagram">Instagram Hesap Bağlantısı (URL)</label>
            <input type="url" id="social_instagram" name="social_instagram" class="admin-form-control" value="<?php echo htmlspecialchars($instagram_val, ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <!-- Başvurular Aktif mi? -->
        <div class="admin-form-group" style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
            <label class="switch">
                <input type="checkbox" name="apply_status" <?php echo $apply_val ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>
            <div>
                <strong style="font-size: 14px; display: block;">Genel Başvuru Sistemini Aktifleştir</strong>
                <span style="font-size: 12px; color: #6c757d;">Kapalı olduğunda tüm başvuru kartları pasife alınır ve başvuru yapılamaz.</span>
            </div>
        </div>

        <!-- Konferans Bilgileri Detay Kartı Ayarları -->
        <div style="margin: 40px 0 20px 0; border-top: 1px solid rgba(0,0,0,0.08); padding-top: 30px;">
            <h3 style="margin-bottom: 20px; color: #3d0814; font-family: 'Cinzel', serif; font-size: 1.3rem;">Konferans Detay Kartı Ayarları</h3>
        </div>

        <div class="admin-form-group" style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px; background: rgba(185, 143, 66, 0.05); padding: 15px; border-radius: 8px; border: 1px solid rgba(185,143,66,0.15);">
            <label class="switch">
                <input type="checkbox" name="highlights_active" <?php echo $hl_active_val ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>
            <div>
                <strong style="font-size: 14px; display: block;">Detay Kartını Sitede Göster (Aktif Et)</strong>
                <span style="font-size: 12px; color: #6c757d;">Sekreterya mektubunun yanındaki konferans detay kartını aktifleştirir veya gizler.</span>
            </div>
        </div>

        <!-- Kart Başlığı -->
        <div class="admin-form-group">
            <label for="highlights_title">Detay Kartı Başlığı</label>
            <input type="text" id="highlights_title" name="highlights_title" class="admin-form-control" value="<?php echo htmlspecialchars($hl_title_val, ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <!-- 1. Tarih Detayı -->
        <div style="background: #fdfdfd; padding: 15px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <label class="switch" style="transform: scale(0.85);">
                    <input type="checkbox" name="hl_date_active" <?php echo $hl_date_active_val ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
                <strong style="font-size: 13px;">Tarih Bilgisi Aktif</strong>
            </div>
            <div class="admin-form-group" style="margin-bottom: 0;">
                <input type="text" name="hl_date_text" class="admin-form-control" placeholder="Örn: 27-28-29 Kasım 2026" value="<?php echo htmlspecialchars($hl_date_text_val, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>

        <!-- 2. Konum Detayı -->
        <div style="background: #fdfdfd; padding: 15px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <label class="switch" style="transform: scale(0.85);">
                    <input type="checkbox" name="hl_location_active" <?php echo $hl_location_active_val ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
                <strong style="font-size: 13px;">Konum Bilgisi Aktif</strong>
            </div>
            <div class="admin-form-group" style="margin-bottom: 0;">
                <input type="text" name="hl_location_text" class="admin-form-control" placeholder="Örn: Sakarya Üniversitesi Kampüsü" value="<?php echo htmlspecialchars($hl_location_text_val, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>

        <!-- 3. Katılımcılar Detayı -->
        <div style="background: #fdfdfd; padding: 15px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <label class="switch" style="transform: scale(0.85);">
                    <input type="checkbox" name="hl_participants_active" <?php echo $hl_participants_active_val ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
                <strong style="font-size: 13px;">Katılımcı Bilgisi Aktif</strong>
            </div>
            <div class="admin-form-group" style="margin-bottom: 0;">
                <input type="text" name="hl_participants_text" class="admin-form-control" placeholder="Örn: Lise ve Üniversite Öğrencileri" value="<?php echo htmlspecialchars($hl_participants_text_val, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>

        <!-- 4. Dil Detayı -->
        <div style="background: #fdfdfd; padding: 15px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <label class="switch" style="transform: scale(0.85);">
                    <input type="checkbox" name="hl_language_active" <?php echo $hl_language_active_val ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
                <strong style="font-size: 13px;">Etkinlik Dili Aktif</strong>
            </div>
            <div class="admin-form-group" style="margin-bottom: 0;">
                <input type="text" name="hl_language_text" class="admin-form-control" placeholder="Örn: Türkçe & İngilizce" value="<?php echo htmlspecialchars($hl_language_text_val, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>

        <button type="submit" class="admin-btn admin-btn-primary" style="margin-top: 10px; width: 100%; justify-content: center;">Ayarları Kaydet</button>

    </form>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
