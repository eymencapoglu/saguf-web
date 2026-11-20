<?php
require_once __DIR__ . '/admin_auth.php';

$success_message = "";
$error_message = "";

$committees_file = __DIR__ . '/../committees.json';
$committees = [];

if (file_exists($committees_file)) {
    $committees = json_decode(file_get_contents($committees_file), true);
    if (!is_array($committees)) {
        $committees = [];
    }
}

// Düzenleme mi Ekleme mi?
$edit_id = $_GET['id'] ?? null;
$committee = null;

if ($edit_id) {
    foreach ($committees as $c) {
        if ($c['id'] === $edit_id) {
            $committee = $c;
            break;
        }
    }
    // Düzenlenecek kayıt bulunamadıysa listeye yönlendir
    if (!$committee) {
        header("Location: committees.php");
        exit;
    }
}

// Form işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : "";
    $description = isset($_POST['description']) ? trim($_POST['description']) : "";
    $chair_name = isset($_POST['chair_name']) ? trim($_POST['chair_name']) : "";
    $chair_title = isset($_POST['chair_title']) ? trim($_POST['chair_title']) : "";
    $co_chair_name = isset($_POST['co_chair_name']) ? trim($_POST['co_chair_name']) : "";
    $co_chair_title = isset($_POST['co_chair_title']) ? trim($_POST['co_chair_title']) : "";
    $active = isset($_POST['active']) ? true : false;

    if (empty($name) || empty($description)) {
        $error_message = "Lütfen Komite Adı ve Açıklama alanlarını doldurunuz.";
    } else {
        // Dosya Yükleme Hata Çeviri Fonksiyonu
        function getUploadErrorString($err_code) {
            switch ($err_code) {
                case UPLOAD_ERR_INI_SIZE:
                    return "Dosya boyutu sunucu limitini (upload_max_filesize) aşıyor.";
                case UPLOAD_ERR_FORM_SIZE:
                    return "Dosya boyutu form limitini (MAX_FILE_SIZE) aşıyor.";
                case UPLOAD_ERR_PARTIAL:
                    return "Dosya sadece kısmen yüklendi.";
                case UPLOAD_ERR_NO_TMP_DIR:
                    return "Sunucuda geçici klasör bulunamadı.";
                case UPLOAD_ERR_CANT_WRITE:
                    return "Dosya diske yazılamadı. Klasör yazma izinlerini kontrol edin.";
                case UPLOAD_ERR_EXTENSION:
                    return "Bir PHP eklentisi dosya yüklemeyi durdurdu.";
                default:
                    return "Bilinmeyen dosya yükleme hatası (Kod: $err_code).";
            }
        }

        // Dosya Yükleme Yardımcı Fonksiyonu
        $upload_errors = [];
        function handleUpload($file_key, $upload_subfolder, $allowed_types, $current_path = "", &$upload_errors) {
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
                            if (!empty($current_path) && file_exists(dirname(__DIR__) . '/' . $current_path)) {
                                unlink(dirname(__DIR__) . '/' . $current_path);
                            }
                            return 'uploads/' . $upload_subfolder . '/' . $new_name;
                        } else {
                            $upload_errors[] = "$file_key yüklenirken move_uploaded_file başarısız oldu.";
                        }
                    } else {
                        $upload_errors[] = "$file_key için geçersiz dosya uzantısı (İzin verilenler: " . implode(', ', $allowed_types) . ").";
                    }
                } elseif ($err !== UPLOAD_ERR_NO_FILE) {
                    $upload_errors[] = "$file_key yükleme hatası: " . getUploadErrorString($err);
                }
            }
            return $current_path;
        }

        // Dosyaları yükle
        $cover_image = handleUpload('cover_image', 'covers', ['jpg', 'jpeg', 'png', 'webp'], ($committee && isset($committee['cover_image'])) ? $committee['cover_image'] : "", $upload_errors);
        $chair_photo = handleUpload('chair_photo', 'profiles', ['jpg', 'jpeg', 'png', 'webp'], ($committee && isset($committee['chair_photo'])) ? $committee['chair_photo'] : "", $upload_errors);
        $co_chair_photo = handleUpload('co_chair_photo', 'profiles', ['jpg', 'jpeg', 'png', 'webp'], ($committee && isset($committee['co_chair_photo'])) ? $committee['co_chair_photo'] : "", $upload_errors);
        $study_guide = handleUpload('study_guide', 'guides', ['pdf'], ($committee && isset($committee['study_guide'])) ? $committee['study_guide'] : "", $upload_errors);

        if (!empty($upload_errors)) {
            $error_message = implode("<br>✗ ", $upload_errors);
        } else {
            if ($edit_id) {
                // Mevcut olanı güncelle
                foreach ($committees as &$c) {
                    if ($c['id'] === $edit_id) {
                        $c['name'] = $name;
                        $c['description'] = $description;
                        $c['cover_image'] = $cover_image;
                        $c['chair_name'] = $chair_name;
                        $c['chair_title'] = $chair_title;
                        $c['chair_photo'] = $chair_photo;
                        $c['co_chair_name'] = $co_chair_name;
                        $c['co_chair_title'] = $co_chair_title;
                        $c['co_chair_photo'] = $co_chair_photo;
                        $c['study_guide'] = $study_guide;
                        $c['active'] = $active;
                        break;
                    }
                }
            } else {
                // Yeni komite ekle
                $new_committee = [
                    "id" => 'com_' . uniqid(),
                    "name" => $name,
                    "description" => $description,
                    "cover_image" => $cover_image,
                    "chair_name" => $chair_name,
                    "chair_title" => $chair_title,
                    "chair_photo" => $chair_photo,
                    "co_chair_name" => $co_chair_name,
                    "co_chair_title" => $co_chair_title,
                    "co_chair_photo" => $co_chair_photo,
                    "study_guide" => $study_guide,
                    "active" => $active
                ];
                $committees[] = $new_committee;
            }

            // Kaydet
            if (file_put_contents($committees_file, json_encode($committees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                redirect("committees.php?success=saved");
            } else {
                $error_message = "Komite kaydedilirken dosya yazma hatası oluştu.";
            }
        }
    }
}

// Redirect if invalid ID
if ($edit_id && !$committee) {
    redirect("committees.php");
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-main">
    <div class="admin-page-header">
        <h2><?php echo $edit_id ? 'Komite Düzenle' : 'Yeni Komite Ekle'; ?></h2>
        <a href="committees.php" class="admin-btn admin-btn-secondary">Geri Dön</a>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="admin-alert admin-alert-danger">
            ✗ <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="admin-form-container" style="max-width: 900px;">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <h3 style="margin-bottom: 20px; font-family: var(--font-title); font-size: 1.25rem; border-bottom: 1px solid #eee; padding-bottom: 5px; color: var(--primary-color);">COMMITTEE DETAILS</h3>
            
            <div class="admin-form-group">
                <label for="name">Committee Name</label>
                <input type="text" id="name" name="name" class="admin-form-control" placeholder="Örn: UNEP, NATO" value="<?php echo htmlspecialchars($committee ? ($committee['name'] ?? '') : ''); ?>" required>
            </div>

            <div class="admin-form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="admin-form-control" rows="4" placeholder="Komite konusunu veya açıklamasını giriniz..." required><?php echo htmlspecialchars($committee ? ($committee['description'] ?? '') : ''); ?></textarea>
            </div>

            <div class="admin-form-group">
                <label for="cover_image">Cover Image (Komite Logosu / Görseli)</label>
                <input type="file" id="cover_image" name="cover_image" class="admin-form-control" accept="image/*">
                <?php if ($committee && !empty($committee['cover_image'])): ?>
                    <img src="../<?php echo htmlspecialchars($committee['cover_image']); ?>" class="img-preview-lg" alt="Kapak Önizleme">
                <?php endif; ?>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;" class="form-row-mobile">
                
                <!-- CHAIR -->
                <div>
                    <h3 style="margin-bottom: 20px; font-family: var(--font-title); font-size: 1.1rem; color: var(--primary-color);">👤 CHAIR</h3>
                    
                    <div class="admin-form-group">
                        <label for="chair_name">Name</label>
                        <input type="text" id="chair_name" name="chair_name" class="admin-form-control" value="<?php echo htmlspecialchars($committee ? ($committee['chair_name'] ?? '') : ''); ?>">
                    </div>

                    <div class="admin-form-group">
                        <label for="chair_title">Title (Optional)</label>
                        <input type="text" id="chair_title" name="chair_title" class="admin-form-control" placeholder="Örn: Komite Başkanı" value="<?php echo htmlspecialchars($committee ? ($committee['chair_title'] ?? 'Komite Başkanı') : 'Komite Başkanı'); ?>">
                    </div>

                    <div class="admin-form-group">
                        <label for="chair_photo">Photo</label>
                        <input type="file" id="chair_photo" name="chair_photo" class="admin-form-control" accept="image/*">
                        <?php if ($committee && !empty($committee['chair_photo'])): ?>
                            <img src="../<?php echo htmlspecialchars($committee['chair_photo']); ?>" class="img-preview-lg" alt="Başkan Fotoğraf">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CO-CHAIR -->
                <div>
                    <h3 style="margin-bottom: 20px; font-family: var(--font-title); font-size: 1.1rem; color: var(--primary-color);">📋 CO-CHAIR</h3>
                    
                    <div class="admin-form-group">
                        <label for="co_chair_name">Name</label>
                        <input type="text" id="co_chair_name" name="co_chair_name" class="admin-form-control" value="<?php echo htmlspecialchars($committee ? ($committee['co_chair_name'] ?? '') : ''); ?>">
                    </div>

                    <div class="admin-form-group">
                        <label for="co_chair_title">Title (Optional)</label>
                        <input type="text" id="co_chair_title" name="co_chair_title" class="admin-form-control" placeholder="Örn: Co-Chair" value="<?php echo htmlspecialchars($committee ? ($committee['co_chair_title'] ?? 'Co-Chair') : 'Co-Chair'); ?>">
                    </div>

                    <div class="admin-form-group">
                        <label for="co_chair_photo">Photo</label>
                        <input type="file" id="co_chair_photo" name="co_chair_photo" class="admin-form-control" accept="image/*">
                        <?php if ($committee && !empty($committee['co_chair_photo'])): ?>
                            <img src="../<?php echo htmlspecialchars($committee['co_chair_photo']); ?>" class="img-preview-lg" alt="Eş Başkan Fotoğraf">
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                <h3 style="margin-bottom: 20px; font-family: var(--font-title); font-size: 1.1rem; color: var(--primary-color);">DOCUMENTS &amp; SETTINGS</h3>
                
                <div class="admin-form-group">
                    <label for="study_guide">Study Guide (PDF)</label>
                    <input type="file" id="study_guide" name="study_guide" class="admin-form-control" accept=".pdf">
                    <?php if ($committee && !empty($committee['study_guide'])): ?>
                        <div style="margin-top: 10px; font-size: 13px;">
                            <span style="color: #28a745; font-weight: 600;">✓ Mevcut Dosya:</span> 
                            <a href="../<?php echo htmlspecialchars($committee['study_guide']); ?>" target="_blank" style="color: var(--primary-color); font-weight: 600; text-decoration: underline;">Kılavuzu İndir / İncele</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="admin-form-group" style="display: flex; align-items: center; gap: 15px; margin-top: 20px;">
                    <label class="switch">
                        <input type="checkbox" name="active" <?php echo (!isset($committee) || ($committee['active'] ?? false)) ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>
                    <div>
                        <strong style="font-size: 14px; display: block;">Bu komite aktif olarak gösterilsin</strong>
                        <span style="font-size: 12px; color: #6c757d;">Seçili olduğunda web sitesinde listelenecektir.</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary" style="margin-top: 20px; width: 100%; justify-content: center; font-size: 16px; padding: 12px;">Kaydet</button>

        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
