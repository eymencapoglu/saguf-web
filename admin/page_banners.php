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

// Silme İşlemi (Delete)
if (isset($_GET['delete'])) {
    $delete_page = $_GET['delete'];
    $filtered_banners = [];
    $found = false;

    foreach ($banners as $b) {
        if ($b['page_id'] === $delete_page) {
            $found = true;
            // Banner görseli uploads altındaysa silelim
            if (strpos($b['image'], 'uploads/banners/') === 0 && file_exists(__DIR__ . '/../' . $b['image'])) {
                unlink(__DIR__ . '/../' . $b['image']);
            }
        } else {
            $filtered_banners[] = $b;
        }
    }

    if ($found) {
        file_put_contents($banners_file, json_encode($filtered_banners, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("page_banners.php?success=deleted");
    }
}

// Başarı mesajı kontrolü
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'deleted') {
        $success_message = "Sayfa başlığı başarıyla silindi.";
    } elseif ($_GET['success'] === 'saved') {
        $success_message = "Sayfa başlığı başarıyla kaydedildi.";
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-main">
    <div class="admin-page-header">
        <h2>Sayfa Başlığı ve Afiş Yönetimi</h2>
        <a href="edit_page_banner.php" class="admin-btn admin-btn-primary">+ Yeni Sayfa Başlığı Ekle</a>
    </div>

    <?php if (!empty($success_message)): ?>
        <div class="admin-alert admin-alert-success">
            ✓ <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Görsel</th>
                    <th>Sayfa Dosyası</th>
                    <th>Başlık (Title)</th>
                    <th>Alt Başlık (Subtitle)</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($banners)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px;">Kayıtlı sayfa başlığı bulunamadı.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($banners as $b): ?>
                        <tr>
                            <td>
                                <?php if (!empty($b['image']) && file_exists(__DIR__ . '/../' . $b['image'])): ?>
                                    <img src="../<?php echo htmlspecialchars($b['image']); ?>" alt="Banner" style="width: 100px; height: 55px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                                <?php else: ?>
                                    <span style="color: #6c757d; font-size: 11px;">Görsel Yok</span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($b['page_id']); ?></strong></td>
                            <td><?php echo htmlspecialchars($b['title']); ?></td>
                            <td><span style="font-size: 12px; opacity: 0.8;"><?php echo htmlspecialchars($b['subtitle']); ?></span></td>
                            <td>
                                <div class="admin-table-actions">
                                    <a href="edit_page_banner.php?page_id=<?php echo urlencode($b['page_id']); ?>" class="admin-btn admin-btn-sm admin-btn-edit">Düzenle</a>
                                    <a href="page_banners.php?delete=<?php echo urlencode($b['page_id']); ?>" class="admin-btn admin-btn-sm admin-btn-delete" onclick="return confirm('Bu sayfa başlığını silmek istediğinize emin misiniz?')">Sil</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
