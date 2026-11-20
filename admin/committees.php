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

// 1. Durum Değiştirme (Active Toggle)
if (isset($_GET['toggle'])) {
    $toggle_id = $_GET['toggle'];
    $updated = false;

    foreach ($committees as &$c) {
        if ($c['id'] === $toggle_id) {
            $c['active'] = !($c['active'] ?? false);
            $updated = true;
            break;
        }
    }

    if ($updated) {
        file_put_contents($committees_file, json_encode($committees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("committees.php?success=status");
    }
}

// 2. Silme İşlemi (Delete)
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $filtered_committees = [];
    $found = false;

    foreach ($committees as $c) {
        if ($c['id'] === $delete_id) {
            $found = true;
            // Dosyaları sil
            if (!empty($c['cover_image']) && file_exists(__DIR__ . '/../' . $c['cover_image'])) {
                unlink(__DIR__ . '/../' . $c['cover_image']);
            }
            if (!empty($c['chair_photo']) && file_exists(__DIR__ . '/../' . $c['chair_photo'])) {
                unlink(__DIR__ . '/../' . $c['chair_photo']);
            }
            if (!empty($c['co_chair_photo']) && file_exists(__DIR__ . '/../' . $c['co_chair_photo'])) {
                unlink(__DIR__ . '/../' . $c['co_chair_photo']);
            }
            if (!empty($c['study_guide']) && file_exists(__DIR__ . '/../' . $c['study_guide'])) {
                unlink(__DIR__ . '/../' . $c['study_guide']);
            }
        } else {
            $filtered_committees[] = $c;
        }
    }

    if ($found) {
        file_put_contents($committees_file, json_encode($filtered_committees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("committees.php?success=deleted");
    }
}

// Başarı mesajları kontrolü
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'status') {
        $success_message = "Komite aktiflik durumu başarıyla güncellendi.";
    } elseif ($_GET['success'] === 'deleted') {
        $success_message = "Komite başarıyla silindi.";
    } elseif ($_GET['success'] === 'saved') {
        $success_message = "Komite başarıyla kaydedildi.";
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-main">
    <div class="admin-page-header">
        <h2>Komite Yönetimi</h2>
        <a href="edit_committee.php" class="admin-btn admin-btn-primary">+ Yeni Komite Ekle</a>
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
                    <th>Komite Adı</th>
                    <th>Başkan (Chair)</th>
                    <th>Eş Başkan (Co-Chair)</th>
                    <th>Kılavuz</th>
                    <th>Durum</th>
                    <th style="text-align: right;">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($committees)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888;">Kayıtlı komite bulunmamaktadır.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($committees as $c): ?>
                        <tr>
                            <td>
                                <?php if (!empty($c['cover_image']) && file_exists(__DIR__ . '/../' . $c['cover_image'])): ?>
                                    <img src="../<?php echo htmlspecialchars($c['cover_image']); ?>" class="img-preview" alt="Kapak">
                                <?php else: ?>
                                    <div class="img-preview" style="display:flex; justify-content:center; align-items:center; background-color:#eee; color:#999; font-size:10px;">Yok</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($c['name']); ?></strong>
                                <div style="font-size: 11px; color:#6c757d; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo htmlspecialchars($c['description']); ?>
                                </div>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($c['chair_name'] ?? 'Belirtilmedi'); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($c['co_chair_name'] ?? 'Belirtilmedi'); ?>
                            </td>
                            <td>
                                <?php if (!empty($c['study_guide']) && file_exists(__DIR__ . '/../' . $c['study_guide'])): ?>
                                    <span style="color: #28a745; font-weight: 600;">✓ Yüklü</span>
                                <?php else: ?>
                                    <span style="color: #dc3545;">✗ Yok</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Aktif/Pasif Toggle Butonu -->
                                <a href="committees.php?toggle=<?php echo $c['id']; ?>" style="text-decoration:none;">
                                    <?php if ($c['active'] ?? false): ?>
                                        <span style="background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">AKTİF</span>
                                    <?php else: ?>
                                        <span style="background-color: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">PASİF</span>
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 8px;">
                                    <a href="edit_committee.php?id=<?php echo $c['id']; ?>" class="admin-btn admin-btn-accent" style="padding: 6px 12px; font-size: 12px;">Düzenle</a>
                                    <a href="committees.php?delete=<?php echo $c['id']; ?>" onclick="return confirm('Bu komiteyi silmek istediğinize emin misiniz?');" class="admin-btn admin-btn-danger" style="padding: 6px 12px; font-size: 12px;">Sil</a>
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
