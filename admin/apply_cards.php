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

// 1. Durum Değiştirme (Active Toggle)
if (isset($_GET['toggle'])) {
    $toggle_id = $_GET['toggle'];
    $updated = false;

    foreach ($apply_cards as &$card) {
        if ($card['id'] === $toggle_id) {
            $card['active'] = !($card['active'] ?? false);
            $updated = true;
            break;
        }
    }

    if ($updated) {
        file_put_contents($apply_cards_file, json_encode($apply_cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("apply_cards.php?success=status");
    }
}

// 2. Silme (Delete)
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $filtered_cards = [];
    $found = false;

    foreach ($apply_cards as $card) {
        if ($card['id'] === $delete_id) {
            $found = true;
        } else {
            $filtered_cards[] = $card;
        }
    }

    if ($found) {
        file_put_contents($apply_cards_file, json_encode($filtered_cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        redirect("apply_cards.php?success=deleted");
    }
}

// Başarı mesajları kontrolü
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'status') {
        $success_message = "Kart aktiflik durumu başarıyla güncellendi.";
    } elseif ($_GET['success'] === 'deleted') {
        $success_message = "Başvuru kartı başarıyla silindi.";
    } elseif ($_GET['success'] === 'saved') {
        $success_message = "Başvuru kartı başarıyla kaydedildi.";
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<div class="admin-main">
    <div class="admin-page-header">
        <h2>Başvuru Kartları Yönetimi</h2>
        <a href="edit_apply_card.php" class="admin-btn admin-btn-primary">+ Yeni Kart Ekle</a>
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
                    <th>Başlık (Title)</th>
                    <th>Ücret (Fee)</th>
                    <th>Buton Metni</th>
                    <th>Yönlendirme Linki (URL)</th>
                    <th>Durum</th>
                    <th style="text-align: right;">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($apply_cards)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #888;">Kayıtlı başvuru kartı bulunmamaktadır.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($apply_cards as $card): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($card['title']); ?></strong>
                                <div style="font-size: 11px; color:#6c757d; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo htmlspecialchars($card['description']); ?>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: var(--primary-color);"><?php echo htmlspecialchars($card['fee']); ?></span>
                            </td>
                            <td>
                                <span style="background-color: #eee; padding: 3px 8px; border-radius: 4px; font-size:11px; font-weight:600;"><?php echo htmlspecialchars($card['button_text']); ?></span>
                            </td>
                            <td>
                                <a href="<?php echo htmlspecialchars($card['redirect_url']); ?>" target="_blank" style="color: var(--primary-color); font-size:12px; text-decoration: underline; display:block; max-width: 200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    <?php echo htmlspecialchars($card['redirect_url']); ?>
                                </a>
                            </td>
                            <td>
                                <a href="apply_cards.php?toggle=<?php echo $card['id']; ?>" style="text-decoration:none;">
                                    <?php if ($card['active'] ?? false): ?>
                                        <span style="background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">AKTİF</span>
                                    <?php else: ?>
                                        <span style="background-color: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">PASİF</span>
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 8px;">
                                    <a href="edit_apply_card.php?id=<?php echo $card['id']; ?>" class="admin-btn admin-btn-accent" style="padding: 6px 12px; font-size: 12px;">Düzenle</a>
                                    <a href="apply_cards.php?delete=<?php echo $card['id']; ?>" onclick="return confirm('Bu başvuru kartını silmek istediğinize emin misiniz?');" class="admin-btn admin-btn-danger" style="padding: 6px 12px; font-size: 12px;">Sil</a>
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
