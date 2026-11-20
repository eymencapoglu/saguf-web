<?php
require_once __DIR__ . '/admin_auth.php';

$success_message = "";
$error_message = "";

$banners_file = __DIR__ . '/../page_banners.json';
$banners = [];

if (file_exists($banners_file)) {
    $banners = json_decode(file_get_contents($banners_file), true);
    if (!is_array($banners)) {
        $banners = [];
    }
}

// Düzenleme modu kontrolü
$is_edit = false;
$edit_page_id = "";
$edit_banner = null;

if (isset($_GET['page_id'])) {
    $edit_page_id = $_GET['page_id'];
    foreach ($banners as $b) {
        if ($b['page_id'] === $edit_page_id) {
            $edit_banner = $b;
            $is_edit = true;
            break;
        }
    }
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page_id = isset($_POST['page_id']) ? trim($_POST['page_id']) : "";
    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
    $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : "";

    if (empty($page_id) || empty($title) || empty($subtitle)) {
        $error_message = "Lütfen tüm zorunlu alanları doldurunuz.";
    } else {
        // Dosya adı kontrolü (Güvenlik için sadece .php ile bitebilir ve dizin geçişi içeremez)
        if (!preg_match('/^[a-zA-Z0-9_\-]+\.php$/', $page_id)) {
            $error_message = "Sayfa Dosya Adı sadece harf, rakam, alt tire, tire içermeli ve '.php' ile bitmelidir (örn: hakkimizda.php).";
        } else {
            // Görsel yükleme
            $image_path = $is_edit ? $edit_banner['image'] : "";
            
            if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['banner_image']['tmp_name'];
                $file_name = $_FILES['banner_image']['name'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($file_ext, $allowed_extensions)) {
                    $error_message = "Yalnızca JPG, JPEG, PNG ve WEBP formatları desteklenmektedir.";
                } else {
                    $upload_dir = __DIR__ . '/../uploads/banners/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    // Eski görseli sil (Eğer custom yüklenmişse)
                    if ($is_edit && strpos($edit_banner['image'], 'uploads/banners/') === 0 && file_exists(__DIR__ . '/../' . $edit_banner['image'])) {
                        unlink(__DIR__ . '/../' . $edit_banner['image']);
                    }
                    
                    // WebP Destek Kontrolü
                    $use_webp = function_exists('imagewebp');
                    $new_file_ext = $use_webp ? 'webp' : $file_ext;
                    $new_file_name = uniqid('banner_', true) . '.' . $new_file_ext;
                    $dest_path = $upload_dir . $new_file_name;
                    
                    $upload_success = false;
                    if ($use_webp) {
                        $info = getimagesize($file_tmp);
                        $mime = $info['mime'] ?? '';
                        $image = null;
                        
                        switch ($mime) {
                            case 'image/jpeg':
                                $image = imagecreatefromjpeg($file_tmp);
                                break;
                            case 'image/png':
                                $image = imagecreatefrompng($file_tmp);
                                break;
                            case 'image/webp':
                                $image = imagecreatefromwebp($file_tmp);
                                break;
                            case 'image/gif':
                                $image = imagecreatefromgif($file_tmp);
                                break;
                        }
                        
                        if ($image && imagewebp($image, $dest_path, 80)) {
                            imagedestroy($image);
                            $upload_success = true;
                        }
                    }
                    
                    if (!$upload_success) {
                        // WebP desteklenmiyorsa veya dönüştürme başarısız olduysa orijinal haliyle taşı
                        $new_file_name = uniqid('banner_', true) . '.' . $file_ext;
                        $dest_path = $upload_dir . $new_file_name;
                        if (move_uploaded_file($file_tmp, $dest_path)) {
                            $upload_success = true;
                        }
                    }
                    
                    if ($upload_success) {
                        $image_path = 'uploads/banners/' . $new_file_name;
                    } else {
                        $error_message = "Görsel yüklenirken veya dönüştürülürken bir hata oluştu.";
                    }
                }
            }
            
            if (empty($error_message)) {
                if (!$is_edit && empty($image_path)) {
                    $error_message = "Yeni bir sayfa başlığı eklerken arka plan görseli yüklemek zorunludur.";
                } else {
                    // Kayıt verisi oluştur
                    $new_banner = [
                        "page_id" => $page_id,
                        "title" => $title,
                        "subtitle" => $subtitle,
                        "image" => $image_path
                    ];
                    
                    if ($is_edit) {
                        // Güncelle
                        foreach ($banners as &$b) {
                            if ($b['page_id'] === $edit_page_id) {
                                $b = $new_banner;
                                break;
                            }
                        }
                    } else {
                        // Ekle
                        // Aynı page_id zaten var mı kontrol et
                        $exists = false;
                        foreach ($banners as $b) {
                            if ($b['page_id'] === $page_id) {
                                $exists = true;
                                break;
                            }
                        }
                        
                        if ($exists) {
                            $error_message = "'{$page_id}' dosyası için zaten bir afiş/başlık tanımlanmış. Lütfen onu düzenleyin.";
                        } else {
                            $banners[] = $new_banner;
                        }
                    }
                    
                    if (empty($error_message)) {
                        if (file_put_contents($banners_file, json_encode($banners, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                            redirect("page_banners.php?success=saved");
                        } else {
                            $error_message = "Veri kaydedilirken hata oluştu.";
                        }
                    }
                }
            }
        }
    }
}

$title_val = $is_edit ? $edit_banner['title'] : "";
$subtitle_val = $is_edit ? $edit_banner['subtitle'] : "";
$page_id_val = $is_edit ? $edit_banner['page_id'] : "";

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-main">
    <div class="admin-page-header">
        <h2><?php echo $is_edit ? 'Sayfa Başlığını Düzenle' : 'Yeni Sayfa Başlığı Ekle'; ?></h2>
        <a href="page_banners.php" class="admin-btn admin-btn-secondary">Geri Dön</a>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="admin-alert admin-alert-danger">
            ✗ <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="admin-form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <!-- Sayfa Dosyası (.php) -->
            <div class="admin-form-group">
                <label for="page_id">Sayfa Dosya Adı (.php) <span style="color: #ff4d5b;">*</span></label>
                <input type="text" id="page_id" name="page_id" class="admin-form-control" placeholder="örn: hakkimizda.php" value="<?php echo htmlspecialchars($page_id_val, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $is_edit ? 'readonly style="background-color: rgba(255,255,255,0.05); color: rgba(255,255,255,0.5);"' : ''; ?> required>
                <span style="font-size: 11px; color: #6c757d; display: block; margin-top: 5px;">Afişin hangi PHP sayfasında gösterileceğini belirler. (Örn: `committees.php`)</span>
            </div>

            <!-- Başlık -->
            <div class="admin-form-group">
                <label for="title">Sayfa Başlığı (Title) <span style="color: #ff4d5b;">*</span></label>
                <input type="text" id="title" name="title" class="admin-form-control" placeholder="örn: KOMİTELERİMİZ" value="<?php echo htmlspecialchars($title_val, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <!-- Alt Başlık -->
            <div class="admin-form-group">
                <label for="subtitle">Sayfa Alt Başlığı (Subtitle) <span style="color: #ff4d5b;">*</span></label>
                <textarea id="subtitle" name="subtitle" class="admin-form-control" rows="3" placeholder="örn: Forum kapsamında çalışılacak tüm alanlar..." required><?php echo htmlspecialchars($subtitle_val, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <!-- Arka Plan Görseli -->
            <div class="admin-form-group">
                <label for="banner_image">Arka Plan Afiş Görseli <?php echo !$is_edit ? '<span style="color: #ff4d5b;">*</span>' : ''; ?></label>
                <input type="file" id="banner_image" name="banner_image" class="admin-form-control" <?php echo !$is_edit ? 'required' : ''; ?>>
                <span style="font-size: 11px; color: #6c757d; display: block; margin-top: 5px;">Önerilen boyut: 16:9 geniş ekran (örn: 1920x1080 piksel). Desteklenen formatlar: JPG, JPEG, PNG, WEBP</span>
                
                <?php if ($is_edit && !empty($edit_banner['image'])): ?>
                    <div style="margin-top: 15px;">
                        <span style="font-size: 12px; display: block; margin-bottom: 5px; color: var(--accent-color);">Mevcut Görsel:</span>
                        <img src="../<?php echo htmlspecialchars($edit_banner['image']); ?>" alt="Mevcut Banner" style="max-width: 300px; height: auto; border-radius: 8px; border: 1px solid var(--border-color);">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary" style="margin-top: 20px; width: 100%; justify-content: center;">
                <?php echo $is_edit ? 'Değişiklikleri Kaydet' : 'Sayfa Başlığı Ekle'; ?>
            </button>

        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
