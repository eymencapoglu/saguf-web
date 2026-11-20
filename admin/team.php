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

// 1. Durum Değiştirme (Active Toggle)
if (isset($_GET['toggle'])) {
    $toggle_id = $_GET['toggle'];
    $updated = false;

    foreach ($team as &$member) {
        if ($member['id'] === $toggle_id) {
            $member['active'] = !($member['active'] ?? false);
            $updated = true;
            break;
        }
    }

    if ($updated) {
        file_put_contents($team_file, json_encode($team, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("team.php?success=status");
    }
}

// 2. Silme İşlemi (Delete)
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $filtered_team = [];
    $found = false;

    foreach ($team as $member) {
        if ($member['id'] === $delete_id) {
            $found = true;
            // Fotoğrafı sunucudan sil
            if (!empty($member['photo']) && file_exists(__DIR__ . '/../' . $member['photo'])) {
                unlink(__DIR__ . '/../' . $member['photo']);
            }
        } else {
            $filtered_team[] = $member;
        }
    }

    if ($found) {
        file_put_contents($team_file, json_encode($filtered_team, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("team.php?success=deleted");
    }
}

// Başarı mesajları kontrolü
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'status') {
        $success_message = "Ekip üyesi aktiflik durumu başarıyla güncellendi.";
    } elseif ($_GET['success'] === 'deleted') {
        $success_message = "Ekip üyesi başarıyla silindi.";
    } elseif ($_GET['success'] === 'saved') {
        $success_message = "Ekip üyesi başarıyla kaydedildi.";
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-page-header">
    <h2>Ekip Üyeleri Yönetimi</h2>
    <a href="edit_member.php" class="admin-btn admin-btn-primary">+ Yeni Üye Ekle</a>
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
                <th>Fotoğraf</th>
                <th>Ad Soyad</th>
                <th>Rol / Unvan</th>
                <th>Durum</th>
                <th style="text-align: right;">İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($team)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #888;">Kayıtlı ekip üyesi bulunmamaktadır.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($team as $member): ?>
                    <tr>
                        <td>
                            <?php if (!empty($member['photo']) && file_exists(__DIR__ . '/../' . $member['photo'])): ?>
                                <img src="../<?php echo htmlspecialchars($member['photo'], ENT_QUOTES, 'UTF-8'); ?>" class="img-preview" style="border-radius: 50%;" alt="Profil">
                            <?php else: ?>
                                <div class="img-preview" style="display:flex; justify-content:center; align-items:center; background-color:#eee; color:#999; font-size:16px; border-radius:50%;">👤</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        </td>
                        <td>
                            <span style="background-color: rgba(185, 143, 66, 0.1); color: var(--primary-color); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                <?php echo htmlspecialchars($member['role'], ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>
                        <td>
                            <!-- Aktif/Pasif Toggle Butonu -->
                            <a href="team.php?toggle=<?php echo $member['id']; ?>" style="text-decoration:none;">
                                <?php if ($member['active'] ?? false): ?>
                                    <span style="background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">AKTİF</span>
                                <?php else: ?>
                                    <span style="background-color: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">PASİF</span>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <a href="edit_member.php?id=<?php echo $member['id']; ?>" class="admin-btn admin-btn-accent" style="padding: 6px 12px; font-size: 12px;">Düzenle</a>
                                <a href="team.php?delete=<?php echo $member['id']; ?>" onclick="return confirm('Bu ekip üyesini silmek istediğinize emin misiniz?');" class="admin-btn admin-btn-danger" style="padding: 6px 12px; font-size: 12px;">Sil</a>
                            </div>
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
