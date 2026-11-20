<?php
require_once __DIR__ . '/header.php';

// JSON'dan yönetim kurulu üyelerini yükle
$team_file = __DIR__ . '/team.json';
$members = [];
if (file_exists($team_file)) {
    $members = json_decode(file_get_contents($team_file), true);
    if (!is_array($members)) {
        $members = [];
    }
}

// Yalnızca aktif olan üyeleri filtrele
$active_members = array_filter($members, function($m) {
    return isset($m['active']) && $m['active'] === true;
});
?>

<!-- Özel Ekip Sayfası Stilleri (Merkezleme ve Kart Boyutu Sabitleme) -->
<style>
    .executive-grid {
        display: flex !important;
        flex-wrap: wrap;
        justify-content: center;
        gap: 35px;
        width: 100%;
    }

    .executive-card {
        width: 100%;
        max-width: 280px; /* Kartın aşırı büyümesini engeller */
    }
</style>

<main>
    <section class="page-section">
        <?php if (!isset($active_page_banner) || !$active_page_banner): ?>
            <h1 class="page-title">Yönetim Kurulu</h1>
            <p class="page-subtitle">SAGUF'26 Etkinliğini düzenleyen ve koordine eden yönetim ekibimiz</p>
        <?php endif; ?>

        <div class="executive-grid">
            <?php if (empty($active_members)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: rgba(255,255,255,0.7);">
                    Yönetim kurulu üyeleri yakında açıklanacaktır. Lütfen takipte kalın!
                </div>
            <?php else: ?>
                <?php foreach ($active_members as $m): ?>
                    <div class="executive-card">
                        <div class="executive-img-wrapper">
                            <?php if (!empty($m['photo']) && file_exists(__DIR__ . '/' . $m['photo'])): ?>
                                <img class="executive-img" src="<?php echo htmlspecialchars($m['photo']); ?>" alt="<?php echo htmlspecialchars($m['name']); ?>">
                            <?php else: ?>
                                <svg class="executive-img" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="100%" height="100%" fill="#85141C" />
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="#B98F42" stroke-width="1.5" opacity="0.3" />
                                    <circle cx="100" cy="80" r="30" fill="none" stroke="#B98F42" stroke-width="2" />
                                    <path d="M 50 160 C 50 120, 80 120, 100 120 C 120 120, 150 120, 150 160" fill="none" stroke="#B98F42" stroke-width="2" />
                                    <path d="M 40 90 Q 30 70, 45 50" fill="none" stroke="#B98F42" stroke-width="1.5" />
                                    <path d="M 160 90 Q 170 70, 155 50" fill="none" stroke="#B98F42" stroke-width="1.5" />
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div class="executive-info">
                            <h3><?php echo htmlspecialchars($m['name']); ?></h3>
                            <p><?php echo htmlspecialchars($m['role']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/footer.php';
?>
