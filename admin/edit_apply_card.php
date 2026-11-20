<?php
require_once __DIR__ . '/admin_auth.php';

$success_message = "";
$error_message = "";

$apply_cards_file = __DIR__ . '/../apply_cards.json';
$apply_cards = [];

if (file_exists($apply_cards_file)) {
    $apply_cards = json_decode(file_get_contents($apply_cards_file), true);
    if (!is_array($apply_cards)) {
        $apply_cards = [];
    }
}

$edit_id = $_GET['id'] ?? null;
$card = null;

if ($edit_id) {
    foreach ($apply_cards as $c) {
        if ($c['id'] === $edit_id) {
            $card = $c;
            break;
        }
    }
    if (!$card) {
        header("Location: apply_cards.php");
        exit;
    }
}

// Form işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
    $description = isset($_POST['description']) ? trim($_POST['description']) : "";
    $fee = isset($_POST['fee']) ? trim($_POST['fee']) : "";
    $button_text = isset($_POST['button_text']) ? trim($_POST['button_text']) : "";
    $redirect_url = isset($_POST['redirect_url']) ? trim($_POST['redirect_url']) : "";
    $active = isset($_POST['active']) ? true : false;

    if (empty($title) || empty($description) || empty($fee) || empty($button_text) || empty($redirect_url)) {
        $error_message = "Lütfen tüm alanları doldurunuz.";
    } else {
        if ($edit_id) {
            foreach ($apply_cards as &$c) {
                if ($c['id'] === $edit_id) {
                    $c['title'] = $title;
                    $c['description'] = $description;
                    $c['fee'] = $fee;
                    $c['button_text'] = $button_text;
                    $c['redirect_url'] = $redirect_url;
                    $c['active'] = $active;
                    break;
                }
            }
        } else {
            $new_card = [
                "id" => 'card_' . uniqid(),
                "title" => $title,
                "description" => $description,
                "fee" => $fee,
                "button_text" => $button_text,
                "redirect_url" => $redirect_url,
                "active" => $active
            ];
            $apply_cards[] = $new_card;
        }

        if (file_put_contents($apply_cards_file, json_encode($apply_cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            redirect("apply_cards.php?success=saved");
        } else {
            $error_message = "Ayarlar kaydedilirken bir hata oluştu.";
        }
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-main">
    <div class="admin-page-header">
        <h2><?php echo $edit_id ? 'Başvuru Kartını Düzenle' : 'Yeni Başvuru Kartı Ekle'; ?></h2>
        <a href="apply_cards.php" class="admin-btn admin-btn-secondary">Geri Dön</a>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="admin-alert admin-alert-danger">
            ✗ <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="admin-form-container">
        <form action="" method="POST">
            
            <h3 style="margin-bottom: 20px; font-family: var(--font-title); font-size: 1.25rem; border-bottom: 1px solid #eee; padding-bottom: 5px; color: var(--primary-color);">Kart Düzenle</h3>

            <div class="admin-form-group">
                <label for="title">BAŞLIK</label>
                <input type="text" id="title" name="title" class="admin-form-control" placeholder="Örn: Apply as a Delegate" value="<?php echo htmlspecialchars($card ? ($card['title'] ?? '') : ''); ?>" required>
            </div>

            <div class="admin-form-group">
                <label for="description">AÇIKLAMA</label>
                <textarea id="description" name="description" class="admin-form-control" rows="4" placeholder="Başvuru detaylarını ve açıklamayı giriniz..." required><?php echo htmlspecialchars($card ? ($card['description'] ?? '') : ''); ?></textarea>
            </div>

            <div class="admin-form-group">
                <label for="fee">ÜCRET (FEE)</label>
                <input type="text" id="fee" name="fee" class="admin-form-control" placeholder="Örn: 1000 ₺" value="<?php echo htmlspecialchars($card ? ($card['fee'] ?? '') : ''); ?>" required>
            </div>

            <div class="admin-form-group">
                <label for="button_text">BUTON METNİ</label>
                <input type="text" id="button_text" name="button_text" class="admin-form-control" placeholder="Örn: Apply Now" value="<?php echo htmlspecialchars($card ? ($card['button_text'] ?? 'Apply Now') : 'Apply Now'); ?>" required>
            </div>

            <div class="admin-form-group">
                <label for="redirect_url">YÖNLENDİRME LİNKİ</label>
                <input type="url" id="redirect_url" name="redirect_url" class="admin-form-control" placeholder="Örn: https://forms.gle/..." value="<?php echo htmlspecialchars($card ? ($card['redirect_url'] ?? '') : ''); ?>" required>
            </div>

            <div class="admin-form-group" style="display: flex; align-items: center; gap: 15px; margin-top: 20px;">
                <label class="switch">
                    <input type="checkbox" name="active" <?php echo (!isset($card) || ($card['active'] ?? false)) ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
                <div>
                    <strong style="font-size: 14px; display: block;">Bu kart aktif olarak gösterilsin</strong>
                    <span style="font-size: 12px; color: #6c757d;">Seçili olduğunda başvuru sayfasında görünecektir.</span>
                </div>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary" style="margin-top: 20px; width: 100%; justify-content: center; font-size: 16px; padding: 12px;">Kaydet</button>

        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
