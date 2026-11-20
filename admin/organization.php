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

// 1. Durum Değiştirme (Active Toggle)
if (isset($_GET['toggle'])) {
    $toggle_id = $_GET['toggle'];
    $updated = false;

    foreach ($cards as &$c) {
        if ($c['id'] === $toggle_id) {
            $c['active'] = !($c['active'] ?? false);
            $updated = true;
            break;
        }
    }

    if ($updated) {
        file_put_contents($org_file, json_encode($cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("organization.php?success=status");
    }
}

// 2. Silme İşlemi (Delete)
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $filtered_cards = [];
    $found = false;

    foreach ($cards as $c) {
        if ($c['id'] === $delete_id) {
            $found = true;
            // Dosyaları sil
            if (!empty($c['image']) && file_exists(__DIR__ . '/../' . $c['image'])) {
                if ($c['image'] !== 'assets/images/sagufanasayfa.jpeg' && $c['image'] !== 'assets/images/sagufyonetim.jpeg') {
                    unlink(__DIR__ . '/../' . $c['image']);
                }
            }
        } else {
            $filtered_cards[] = $c;
        }
    }

    if ($found) {
        file_put_contents($org_file, json_encode($filtered_cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("organization.php?success=deleted");
    }
}

// Başarı mesajları
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'status') {
        $success_message = "Kart aktiflik durumu başarıyla güncellendi.";
    } elseif ($_GET['success'] === 'deleted') {
        $success_message = "Kart başarıyla silindi.";
    } elseif ($_GET['success'] === 'saved') {
        $success_message = "Kart başarıyla kaydedildi.";
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-page-header">
    <h2>Organizasyon Kart Yönetimi</h2>
    <a href="edit_organization.php" class="admin-btn admin-btn-primary">+ Yeni Departman Ekle</a>
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
                <th style="width: 120px;">Görsel</th>
                <th>Departman / Kart Adı</th>
                <th>Slogan</th>
                <th>Başkanlar / Yöneticiler</th>
                <th style="width: 120px;">Durum</th>
                <th style="text-align: right; width: 180px;">İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($cards)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #888; padding: 30px;">Kayıtlı organizasyon kartı bulunmamaktadır.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($cards as $c): ?>
                    <tr>
                        <td>
                            <?php if (!empty($c['image']) && file_exists(__DIR__ . '/../' . $c['image'])): ?>
                                <img src="../<?php echo htmlspecialchars($c['image']); ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(185, 143, 66, 0.3);" alt="Kapak">
                            <?php else: ?>
                                <div style="width: 80px; height: 50px; display:flex; justify-content:center; align-items:center; background-color:rgba(255,255,255,0.05); color:#888; font-size:10px; border-radius: 6px;">Yok</div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: 700; color: var(--text-light);">
                            <?php echo htmlspecialchars($c['name']); ?>
                        </td>
                        <td style="font-style: italic; color: rgba(255, 255, 255, 0.7); max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo htmlspecialchars($c['slogan']); ?>
                        </td>
                        <td style="color: var(--accent-color); font-weight: 500;">
                            <?php echo htmlspecialchars($c['leaders']); ?>
                        </td>
                        <td>
                            <a href="organization.php?toggle=<?php echo $c['id']; ?>" style="text-decoration:none;">
                                <?php if ($c['active'] ?? false): ?>
                                    <span style="background-color: rgba(40, 167, 69, 0.15); color: #2ee25d; padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #28a745;">AKTİF</span>
                                <?php else: ?>
                                    <span style="background-color: rgba(220, 53, 69, 0.15); color: #ff5a6a; padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #dc3545;">PASİF</span>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td style="text-align: right;">
                            <a href="edit_organization.php?id=<?php echo $c['id']; ?>" class="admin-btn admin-btn-secondary" style="padding: 6px 12px; font-size: 12px;">Düzenle</a>
                            <a href="organization.php?delete=<?php echo $c['id']; ?>" class="admin-btn admin-btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('Bu kartı silmek istediğinize emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
