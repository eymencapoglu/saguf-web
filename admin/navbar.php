<?php
require_once __DIR__ . '/admin_auth.php';

$success_message = "";
$error_message = "";

$navbar_file = __DIR__ . '/../navbar.json';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titles = isset($_POST['titles']) ? $_POST['titles'] : [];
    $visibles = isset($_POST['visibles']) ? $_POST['visibles'] : [];

    // Mevcut navbardan yükle
    $nav_items = [];
    if (file_exists($navbar_file)) {
        $nav_items = json_decode(file_get_contents($navbar_file), true);
    }
    if (empty($nav_items)) {
        $nav_items = [
            ["id" => "index", "title" => "Anasayfa", "url" => "index.php", "visible" => "1"],
            ["id" => "committees", "title" => "Komiteler", "url" => "committees.php", "visible" => "1"],
            ["id" => "organization", "title" => "Organizasyon", "url" => "organization.php", "visible" => "1"],
            ["id" => "executive", "title" => "Yönetim Kurulu", "url" => "executive.php", "visible" => "1"],
            ["id" => "apply", "title" => "Başvuru", "url" => "apply.php", "visible" => "1"],
            ["id" => "contact", "title" => "İletişim", "url" => "contact.php", "visible" => "1"]
        ];
    }

    // Güncelle
    foreach ($nav_items as &$item) {
        $id = $item['id'];
        if (isset($titles[$id])) {
            $item['title'] = trim($titles[$id]);
        }
        $item['visible'] = isset($visibles[$id]) ? "1" : "0";
    }

    if (file_put_contents($navbar_file, json_encode($nav_items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        redirect("navbar.php?success=saved");
    } else {
        $error_message = "Değişiklikler kaydedilirken bir hata oluştu.";
    }
}

if (isset($_GET['success']) && $_GET['success'] === 'saved') {
    $success_message = "Menü ayarları başarıyla güncellendi! Değişiklikler anında navbar'a yansıtıldı.";
}

// Navbardan oku
$nav_items = [];
if (file_exists($navbar_file)) {
    $nav_items = json_decode(file_get_contents($navbar_file), true);
}
if (empty($nav_items)) {
    $nav_items = [
        ["id" => "index", "title" => "Anasayfa", "url" => "index.php", "visible" => "1"],
        ["id" => "committees", "title" => "Komiteler", "url" => "committees.php", "visible" => "1"],
        ["id" => "organization", "title" => "Organizasyon", "url" => "organization.php", "visible" => "1"],
        ["id" => "executive", "title" => "Yönetim Kurulu", "url" => "executive.php", "visible" => "1"],
        ["id" => "apply", "title" => "Başvuru", "url" => "apply.php", "visible" => "1"],
        ["id" => "contact", "title" => "İletişim", "url" => "contact.php", "visible" => "1"]
    ];
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-page-header">
    <h2>Menü Ayarları (Navbar Kontrolü)</h2>
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

<div class="admin-form-container" style="max-width: 900px;">
    <form action="navbar.php" method="POST">
        
        <p style="font-size: 13px; color: rgba(255, 255, 255, 0.7); margin-bottom: 25px; line-height: 1.5;">
            Aşağıdaki listeden sitenin üst menüsünde (navbar) yer alan bağlantıların adlarını düzenleyebilir ve hangilerinin aktif (görünür) olacağını kontrol edebilirsiniz.
        </p>

        <div class="admin-table-container" style="box-shadow: none; border-color: rgba(185, 143, 66, 0.15); margin-bottom: 25px;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Menü Öğesi</th>
                        <th>Yönlendirme Adresi (URL)</th>
                        <th>Görünen Başlık</th>
                        <th style="text-align: center; width: 100px;">Aktiflik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nav_items as $item): ?>
                    <tr>
                        <td style="font-weight: 600; color: var(--accent-color);">
                            <?php 
                            if ($item['id'] === 'index') echo 'Anasayfa';
                            elseif ($item['id'] === 'committees') echo 'Komiteler';
                            elseif ($item['id'] === 'organization') echo 'Organizasyon';
                            elseif ($item['id'] === 'executive') echo 'Yönetim Kurulu';
                            elseif ($item['id'] === 'apply') echo 'Başvuru';
                            elseif ($item['id'] === 'contact') echo 'İletişim';
                            else echo htmlspecialchars($item['id']);
                            ?>
                        </td>
                        <td style="font-size: 12px; font-family: monospace; color: rgba(255, 255, 255, 0.65);">
                            <?php echo htmlspecialchars($item['url']); ?>
                        </td>
                        <td>
                            <input type="text" name="titles[<?php echo htmlspecialchars($item['id']); ?>]" class="admin-form-control" style="padding: 6px 12px; font-size: 13px;" value="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </td>
                        <td style="text-align: center;">
                            <label class="switch" style="display: inline-block; position: relative; width: 50px; height: 24px; vertical-align: middle;">
                                <input type="checkbox" name="visibles[<?php echo htmlspecialchars($item['id']); ?>]" value="1" <?php echo ($item['visible'] === '1') ? 'checked' : ''; ?> style="opacity: 0; width: 0; height: 0;">
                                <span class="slider round" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(185, 143, 66, 0.3); transition: .4s; border-radius: 24px;"></span>
                            </label>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="text-align: right;">
            <button type="submit" class="admin-btn admin-btn-primary">✓ Menüyü Kaydet</button>
        </div>
    </form>
</div>

<!-- Switch CSS -->
<style>
.switch input:checked + .slider {
    background-color: var(--accent-color) !important;
}

.switch input:checked + .slider:before {
    transform: translateX(26px) !important;
    background-color: var(--bg-dark) !important;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 3px;
    bottom: 3px;
    background-color: var(--white);
    transition: .4s;
    border-radius: 50%;
}
</style>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
