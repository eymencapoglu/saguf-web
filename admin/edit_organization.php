<?php
require_once __DIR__ . '/admin_auth.php';

$success_message = "";
$error_message = "";

$org_file = __DIR__ . '/../organization.json';
$cards = [];

if (file_exists($org_file)) {
    $cards = json_decode(file_get_contents($org_file), true);
    if (!is_array($cards)) {
        $cards = [];
    }
}

// Düzenleme mi Ekleme mi?
$edit_id = $_GET['id'] ?? null;
$card = null;

if ($edit_id) {
    foreach ($cards as $c) {
        if ($c['id'] === $edit_id) {
            $card = $c;
            break;
        }
    }
    if (!$card) {
        header("Location: organization.php");
        exit;
    }
}

// Form işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : "";
    $slogan = isset($_POST['slogan']) ? trim($_POST['slogan']) : "";
    $leaders = isset($_POST['leaders']) ? trim($_POST['leaders']) : "";
    $active = isset($_POST['active']) ? true : false;

    if (empty($name)) {
        $error_message = "Lütfen Departman / Kart Adı alanını doldurunuz.";
    } else {
        // Dosya Yükleme Hata Çeviri
        function getUploadErrorString($err_code) {
            switch ($err_code) {
                case UPLOAD_ERR_INI_SIZE: return "Dosya boyutu sunucu limitini aşıyor.";
                case UPLOAD_ERR_FORM_SIZE: return "Dosya boyutu form limitini aşıyor.";
                case UPLOAD_ERR_PARTIAL: return "Dosya sadece kısmen yüklendi.";
                case UPLOAD_ERR_NO_TMP_DIR: return "Sunucuda geçici klasör bulunamadı.";
                case UPLOAD_ERR_CANT_WRITE: return "Dosya diske yazılamadı.";
                case UPLOAD_ERR_EXTENSION: return "Bir PHP eklentisi dosya yüklemeyi durdurdu.";
                default: return "Bilinmeyen dosya yükleme hatası (Kod: $err_code).";
            }
        }

        $upload_errors = [];
        // Dosya Yükleme Yardımcısı
        function handleUpload($file_key, $upload_subfolder, $allowed_types, $current_path, &$upload_errors) {
            if (isset($_FILES[$file_key])) {
                $err = $_FILES[$file_key]['error'];
                if ($err === UPLOAD_ERR_OK) {
                    $file = $_FILES[$file_key];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    
                    if (in_array($ext, $allowed_types)) {
                        $new_name = uniqid() . '.' . $ext;
                        $dest_dir = dirname(__DIR__) . '/uploads/' . $upload_subfolder . '/';
                        
                        if (!file_exists($dest_dir)) {
                            mkdir($dest_dir, 0755, true);
                        }
                        
                        $dest_path = $dest_dir . $new_name;
                        
                        if (move_uploaded_file($file['tmp_name'], $dest_path)) {
                            // Eski özel resmi sil (eğer default resimlerden değilse)
                            if (!empty($current_path) && file_exists(dirname(__DIR__) . '/' . $current_path)) {
                                if ($current_path !== 'assets/images/sagufanasayfa.jpeg' && $current_path !== 'assets/images/sagufyonetim.jpeg') {
                                    unlink(dirname(__DIR__) . '/' . $current_path);
                                }
                            }
                            return 'uploads/' . $upload_subfolder . '/' . $new_name;
                        } else {
                            $upload_errors[] = "$file_key yüklenirken move_uploaded_file başarısız oldu.";
                        }
                    } else {
                        $upload_errors[] = "$file_key için geçersiz dosya uzantısı.";
                    }
                } elseif ($err !== UPLOAD_ERR_NO_FILE) {
                    $upload_errors[] = "$file_key yükleme hatası: " . getUploadErrorString($err);
                }
            }
            return $current_path;
        }

        // Kapak görselini yükle
        $image = handleUpload('image', 'org_covers', ['jpg', 'jpeg', 'png', 'webp'], ($card && isset($card['image'])) ? $card['image'] : "", $upload_errors);

        if (!empty($upload_errors)) {
            $error_message = implode("<br>✗ ", $upload_errors);
        } else {
            if ($edit_id) {
                // Güncelle
                foreach ($cards as &$c) {
                    if ($c['id'] === $edit_id) {
                        $c['name'] = $name;
                        $c['slogan'] = $slogan;
                        $c['leaders'] = $leaders;
                        $c['image'] = $image;
                        $c['active'] = $active;
                        break;
                    }
                }
            } else {
                // Yeni Ekle
                $new_card = [
                    "id" => 'org_' . uniqid(),
                    "name" => $name,
                    "slogan" => $slogan,
                    "leaders" => $leaders,
                    "image" => $image,
                    "active" => $active
                ];
                $cards[] = $new_card;
            }

            if (file_put_contents($org_file, json_encode($cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                redirect("organization.php?success=saved");
            } else {
                $error_message = "Dosya kaydedilirken bir hata oluştu.";
            }
        }
    }
}

$name_val = $card['name'] ?? "";
$slogan_val = $card['slogan'] ?? "";
$leaders_val = $card['leaders'] ?? "";
$image_val = $card['image'] ?? "";
$active_val = $card ? ($card['active'] ?? false) : true;

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-page-header">
    <h2><?php echo $edit_id ? 'Organizasyon Kartını Düzenle' : 'Yeni Organizasyon Kartı Ekle'; ?></h2>
    <a href="organization.php" class="admin-btn admin-btn-secondary">Geri Dön</a>
</div>

<?php if (!empty($error_message)): ?>
    <div class="admin-alert admin-alert-danger">
        ✗ <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<div class="admin-form-container">
    <form action="edit_organization.php<?php echo $edit_id ? '?id='.urlencode($edit_id) : ''; ?>" method="POST" enctype="multipart/form-data">
        
        <!-- Departman / Kart Adı -->
        <div class="admin-form-group">
            <label for="name">Departman / Kart Adı *</label>
            <input type="text" id="name" name="name" class="admin-form-control" value="<?php echo htmlspecialchars($name_val, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <!-- Slogan -->
        <div class="admin-form-group">
            <label for="slogan">Slogan / Açıklama</label>
            <input type="text" id="slogan" name="slogan" class="admin-form-control" value="<?php echo htmlspecialchars($slogan_val, ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <!-- Başkanlar / Yöneticiler -->
        <div class="admin-form-group">
            <label for="leaders">Başkanlar / Yöneticiler (Virgülle Ayırabilirsiniz)</label>
            <input type="text" id="leaders" name="leaders" class="admin-form-control" value="<?php echo htmlspecialchars($leaders_val, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Örn: Eymen Can (Başkan), Bilal Mazlum (Başkan Yardımcısı)">
        </div>

        <!-- Kapak Görseli -->
        <div class="admin-form-group">
            <label for="image">Departman / Kart Görseli (Dosya Seçin)</label>
            <?php if (!empty($image_val) && file_exists(__DIR__ . '/../' . $image_val)): ?>
                <div style="margin-bottom: 10px;">
                    <img src="../<?php echo htmlspecialchars($image_val); ?>" style="width: 150px; height: 90px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(185, 143, 66, 0.3);" alt="Mevcut Görsel">
                    <span style="font-size: 12px; color: #aaa; display:block; margin-top: 5px;">Mevcut görsel korunacaktır. Yeni dosya seçerseniz değiştirilir.</span>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" class="admin-form-control" accept="image/*">
        </div>

        <!-- Aktif / Pasif -->
        <div class="admin-form-group" style="display: flex; align-items: center; gap: 10px; margin-top: 15px;">
            <input type="checkbox" id="active" name="active" value="1" <?php echo $active_val ? 'checked' : ''; ?> style="width: 18px; height: 18px; cursor: pointer;">
            <label for="active" style="margin-bottom: 0; cursor: pointer;">Bu kart web sitesinde aktif/görünür olsun</label>
        </div>

        <div style="margin-top: 30px; text-align: right; display: flex; gap: 15px; justify-content: flex-end;">
            <a href="organization.php" class="admin-btn admin-btn-secondary">İptal</a>
            <button type="submit" class="admin-btn admin-btn-primary">✓ Değişiklikleri Kaydet</button>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
