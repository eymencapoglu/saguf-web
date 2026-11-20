<?php
require_once __DIR__ . '/admin_auth.php';

$success_message = "";
$error_message = "";

$team_file = __DIR__ . '/../team.json';
$team = [];

if (file_exists($team_file)) {
    $team = json_decode(file_get_contents($team_file), true);
    if (!is_array($team)) {
        $team = [];
    }
}

$edit_id = $_GET['id'] ?? null;
$member = null;

if ($edit_id) {
    foreach ($team as $m) {
        if ($m['id'] === $edit_id) {
            $member = $m;
            break;
        }
    }
    if (!$member) {
        redirect("team.php");
    }
}

// Form işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : "";
    $role = isset($_POST['role']) ? trim($_POST['role']) : "";
    $active = isset($_POST['active']) ? true : false;

    if (empty($name) || empty($role)) {
        $error_message = "Lütfen tüm alanları doldurunuz.";
    } else {
        // Fotoğraf yükleme işleme
        $photo = ($member && isset($member['photo'])) ? $member['photo'] : "";
        $upload_error = "";
        
        if (isset($_FILES['photo'])) {
            $err = $_FILES['photo']['error'];
            if ($err === UPLOAD_ERR_OK) {
                $file = $_FILES['photo'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
                
                if (in_array($ext, $allowed_types)) {
                    $new_name = uniqid() . '.' . $ext;
                    $dest_dir = dirname(__DIR__) . '/uploads/profiles/';
                    
                    if (!file_exists($dest_dir)) {
                        mkdir($dest_dir, 0755, true);
                    }
                    
                    if (move_uploaded_file($file['tmp_name'], $dest_dir . $new_name)) {
                        // Eski dosyayı sil
                        if (!empty($photo) && file_exists(dirname(__DIR__) . '/' . $photo)) {
                            unlink(dirname(__DIR__) . '/' . $photo);
                        }
                        $photo = 'uploads/profiles/' . $new_name;
                    } else {
                        $upload_error = "Profil fotoğrafı sunucu klasörüne taşınamadı.";
                    }
                } else {
                    $upload_error = "Geçersiz dosya uzantısı (İzin verilenler: jpg, jpeg, png, webp).";
                }
            } elseif ($err !== UPLOAD_ERR_NO_FILE) {
                // Diğer hata kodları
                switch ($err) {
                    case UPLOAD_ERR_INI_SIZE:
                        $upload_error = "Fotoğraf boyutu sunucu limitini aşıyor.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $upload_error = "Fotoğraf diske yazılamadı.";
                        break;
                    default:
                        $upload_error = "Dosya yükleme hatası oluştu (Kod: $err).";
                        break;
                }
            }
        }

        if (!empty($upload_error)) {
            $error_message = $upload_error;
        } else {
            if ($edit_id) {
                // Güncelle
                foreach ($team as &$m) {
                    if ($m['id'] === $edit_id) {
                        $m['name'] = $name;
                        $m['role'] = $role;
                        $m['photo'] = $photo;
                        $m['active'] = $active;
                        break;
                    }
                }
            } else {
                // Ekle
                $new_member = [
                    "id" => 'mem_' . uniqid(),
                    "name" => $name,
                    "role" => $role,
                    "photo" => $photo,
                    "active" => $active
                ];
                $team[] = $new_member;
            }

            if (file_put_contents($team_file, json_encode($team, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                redirect("team.php?success=saved");
            } else {
                $error_message = "Veriler kaydedilirken bir dosya hatası oluştu.";
            }
        }
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-page-header">
    <h2><?php echo $edit_id ? 'Ekip Üyesini Düzenle' : 'Yeni Ekip Üyesi Ekle'; ?></h2>
    <a href="team.php" class="admin-btn admin-btn-secondary">Geri Dön</a>
</div>

<?php if (!empty($error_message)): ?>
    <div class="admin-alert admin-alert-danger">
        ✗ <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<div class="admin-form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        
        <h3 style="margin-bottom: 20px; font-family: var(--font-title); font-size: 1.25rem; border-bottom: 1px solid #eee; padding-bottom: 5px; color: var(--primary-color);">Üye Bilgileri</h3>

        <div class="admin-form-group">
            <label for="name">Adı Soyadı</label>
            <input type="text" id="name" name="name" class="admin-form-control" placeholder="Örn: Ahmet Yılmaz" value="<?php echo htmlspecialchars($member ? ($member['name'] ?? '') : '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="admin-form-group">
            <label for="role">Rol / Unvan</label>
            <input type="text" id="role" name="role" class="admin-form-control" placeholder="Örn: Genel Koordinatör, Akademik Başkan" value="<?php echo htmlspecialchars($member ? ($member['role'] ?? '') : '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="admin-form-group">
            <label for="photo">Profil Fotoğrafı</label>
            <input type="file" id="photo" name="photo" class="admin-form-control" accept="image/*">
            <?php if ($member && !empty($member['photo'])): ?>
                <img src="../<?php echo htmlspecialchars($member['photo'], ENT_QUOTES, 'UTF-8'); ?>" class="img-preview-lg" alt="Profil">
            <?php endif; ?>
        </div>

        <div class="admin-form-group" style="display: flex; align-items: center; gap: 15px; margin-top: 20px;">
            <label class="switch">
                <input type="checkbox" name="active" <?php echo (!isset($member) || ($member['active'] ?? false)) ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>
            <div>
                <strong style="font-size: 14px; display: block;">Bu ekip üyesi aktif olarak gösterilsin</strong>
                <span style="font-size: 12px; color: #6c757d;">Seçili olduğunda web sitesinde listelenecektir.</span>
            </div>
        </div>

        <button type="submit" class="admin-btn admin-btn-primary" style="margin-top: 20px; width: 100%; justify-content: center; font-size: 16px; padding: 12px;">Kaydet</button>

    </form>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
