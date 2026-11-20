<?php
require_once __DIR__ . '/admin_auth.php';

// 1. Dinamik Özet Değerleri Hesaplama
// A. Başvuru Kartları Adeti
$cards_file = __DIR__ . '/../apply_cards.json';
$card_count = 0;
if (file_exists($cards_file)) {
    $cards = json_decode(file_get_contents($cards_file), true);
    if (is_array($cards)) {
        foreach ($cards as $c) {
            if ($c['active'] ?? false) {
                $card_count++;
            }
        }
    }
}

// B. Ekip Üyeleri Adeti
$team_file = __DIR__ . '/../team.json';
$member_count = 0;
if (file_exists($team_file)) {
    $team = json_decode(file_get_contents($team_file), true);
    if (is_array($team)) {
        foreach ($team as $t) {
            if ($t['active'] ?? false) {
                $member_count++;
            }
        }
    }
}

// C. Sayaç Tarihi
$settings_file = __DIR__ . '/../settings.json';
$target_date = "Belirtilmedi";
if (file_exists($settings_file)) {
    $settings = json_decode(file_get_contents($settings_file), true);
    if (isset($settings['countdown_target'])) {
        try {
            $date = new DateTime($settings['countdown_target']);
            $target_date = $date->format('d.m.Y H:i');
        } catch (Exception $e) {
            $target_date = $settings['countdown_target'];
        }
    }
}

// D. Organizasyon Kartları Adeti
$org_file = __DIR__ . '/../organization.json';
$org_count = 0;
if (file_exists($org_file)) {
    $org_cards = json_decode(file_get_contents($org_file), true);
    if (is_array($org_cards)) {
        foreach ($org_cards as $o) {
            if ($o['active'] ?? false) {
                $org_count++;
            }
        }
    }
}

require_once __DIR__ . '/admin_header.php';
?>

<!-- Dashboard Ana Paneli -->
<div class="dashboard-cards-grid">
    
    <!-- Kart 1: Başvuru Kartları -->
    <div class="dashboard-card">
        <div class="card-header-info">
            <!-- Dosya İkonu -->
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Apply Kartları
        </div>
        <div>
            <div class="card-value"><?php echo $card_count; ?></div>
            <div class="card-subtext">Aktif kartlar</div>
        </div>
        <a href="apply_cards.php" class="card-btn">Yönet</a>
    </div>

    <!-- Kart 2: Ekip Üyeleri -->
    <div class="dashboard-card">
        <div class="card-header-info">
            <!-- Kullanıcılar İkonu -->
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Ekip Üyeleri
        </div>
        <div>
            <div class="card-value"><?php echo $member_count; ?></div>
            <div class="card-subtext">Aktif üyeler</div>
        </div>
        <a href="team.php" class="card-btn">Yönet</a>
    </div>

    <!-- Kart 3: Organizasyon Kartları -->
    <div class="dashboard-card">
        <div class="card-header-info">
            <!-- Kullanıcılar Grubu İkonu -->
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Organizasyon Kartları
        </div>
        <div>
            <div class="card-value"><?php echo $org_count; ?></div>
            <div class="card-subtext">Aktif departmanlar</div>
        </div>
        <a href="organization.php" class="card-btn">Yönet</a>
    </div>

    <!-- Kart 4: Sayaç Tarihi -->
    <div class="dashboard-card">
        <div class="card-header-info">
            <!-- Saat İkonu -->
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Countdown Tarihi
        </div>
        <div>
            <div class="card-value" style="font-size: 20px; margin: 25px 0 15px 0;"><?php echo htmlspecialchars($target_date, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="card-subtext">Son başvuru tarihi</div>
        </div>
        <a href="settings.php" class="card-btn">Düzenle</a>
    </div>

</div>

<!-- Hoş Geldiniz Banner -->
<div class="welcome-banner">
    <h3>Hoş Geldiniz!</h3>
    <p>SAGUF'26 yönetim paneline hoş geldiniz. Soldaki menüden site içeriğini yönetebilirsiniz.</p>
    
    <h4>Hızlı Bağlantılar:</h4>
    <ul class="quick-links">
        <li>
            <a href="settings.php">
                ❖ Countdown timer tarihini güncelle
            </a>
        </li>
        <li>
            <a href="edit_apply_card.php">
                ❖ Yeni başvuru kartı ekle
            </a>
        </li>
        <li>
            <a href="edit_member.php">
                ❖ Yeni ekip üyesi ekle
            </a>
        </li>
        <li>
            <a href="../index.php" target="_blank">
                ❖ Ana sayfayı görüntüle
            </a>
        </li>
    </ul>
</div>

<?php
require_once __DIR__ . '/admin_footer.php';
?>
