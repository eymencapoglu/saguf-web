<?php
require_once __DIR__ . '/config.php';

// Organizasyon kartlarını JSON'dan yükle
$org_file = __DIR__ . '/organization.json';
$cards = [];
if (file_exists($org_file)) {
    $cards = json_decode(file_get_contents($org_file), true);
    if (!is_array($cards)) {
        $cards = [];
    }
}

// Sadece aktif olanları filtrele
$active_cards = array_filter($cards, function($c) {
    return isset($c['active']) && $c['active'] === true;
});

require_once __DIR__ . '/header.php';
?>

<!-- Organizasyon Sayfası Stilleri (Büyütülmüş Premium Kart Yapısı) -->
<style>
    /* Kart Izgarası ve Esnek Hizalama */
    .org-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 40px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Büyütülmüş Departman Kartı (Komite Kartlarından Bi Tık Büyük) */
    .org-card {
        background-color: var(--bg-dark);
        border: 2px solid var(--accent-color);
        border-radius: 24px;
        width: 100%;
        max-width: 360px; /* Komite kartlarından (330px) daha büyük */
        height: 420px;    /* Komite kartlarından (380px) daha uzun */
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .org-card:hover {
        transform: translateY(-10px);
        border-color: var(--white);
        box-shadow: 0 20px 45px rgba(185, 143, 66, 0.4);
    }

    /* Arka Plan Görsel Katmanı */
    .org-card-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
    }

    .org-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .org-card:hover .org-card-img {
        transform: scale(1.08);
    }

    .org-card-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--bg-dark) 100%);
    }

    /* Yazının Okunabilirliği İçin Degrade Karartma */
    .org-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(17, 2, 4, 0.2) 0%, rgba(17, 2, 4, 0.7) 45%, rgba(17, 2, 4, 0.98) 100%);
        z-index: 2;
        transition: var(--transition);
    }

    .org-card:hover .org-card-overlay {
        background: linear-gradient(to bottom, rgba(17, 2, 4, 0.1) 0%, rgba(17, 2, 4, 0.6) 40%, rgba(17, 2, 4, 0.95) 100%);
    }

    /* Kart Gövdesi (Ön Planda) */
    .org-card-body {
        padding: 30px;
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: none;
    }

    .org-card-body h3 {
        font-family: var(--font-body);
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--white);
        margin-bottom: 10px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        text-shadow: 0 2px 5px rgba(0,0,0,0.6);
    }

    .org-card-body p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.92rem;
        font-style: italic;
        line-height: 1.5;
        margin-bottom: 20px;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }

    /* Başkanlar / Yöneticiler Alanı */
    .org-card-leaders {
        border-top: 1.5px solid rgba(185, 143, 66, 0.35);
        padding-top: 15px;
        margin-top: 5px;
        text-align: left;
    }

    .org-card-leaders strong {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--accent-color);
        margin-bottom: 5px;
        font-weight: 700;
    }

    .org-card-leaders span {
        display: block;
        font-size: 13.5px;
        color: var(--white);
        font-weight: 600;
        line-height: 1.4;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }

    /* Mobil Düzen */
    @media (max-width: 768px) {
        .org-grid {
            gap: 30px;
        }
        .org-card {
            max-width: 320px;
            height: 390px;
            border-radius: 20px;
        }
        .org-card-body {
            padding: 22px;
        }
        .org-card-body h3 {
            font-size: 1.25rem;
        }
        .org-card-body p {
            font-size: 0.85rem;
            margin-bottom: 15px;
        }
        .org-card-leaders span {
            font-size: 12.5px;
        }
    }
</style>

<main>
    <section class="page-section">
        <?php if (!isset($active_page_banner) || !$active_page_banner): ?>
            <h1 class="page-title">Organizasyon Ekibi</h1>
            <p class="page-subtitle">SAGUF'26 Organizasyon Yönetim Ekibimiz ve Departmanlarımız</p>
        <?php endif; ?>

        <div class="org-grid">
            <?php if (empty($active_cards)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: rgba(255,255,255,0.7);">
                    Organizasyon şeması çok yakında duyurulacaktır. Takipte kalın!
                </div>
            <?php else: ?>
                <?php foreach ($active_cards as $c): ?>
                    <div class="org-card">
                        
                        <!-- Arka Plan Görsel Katmanı -->
                        <div class="org-card-bg">
                            <?php if (!empty($c['image']) && file_exists(__DIR__ . '/' . $c['image'])): ?>
                                <img class="org-card-img" src="<?php echo htmlspecialchars($c['image']); ?>" alt="<?php echo htmlspecialchars($c['name']); ?>">
                            <?php else: ?>
                                <div class="org-card-placeholder">
                                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="var(--accent-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                            <?php endif; ?>
                            <div class="org-card-overlay"></div>
                        </div>

                        <!-- Kart Gövdesi (Ön Planda) -->
                        <div class="org-card-body">
                            <h3><?php echo htmlspecialchars($c['name']); ?></h3>
                            <?php if (!empty($c['slogan'])): ?>
                                <p>&ldquo;<?php echo htmlspecialchars($c['slogan']); ?>&rdquo;</p>
                            <?php endif; ?>
                            
                            <?php if (!empty($c['leaders'])): ?>
                                <div class="org-card-leaders">
                                    <strong>Başkan / Yöneticiler</strong>
                                    <span><?php echo htmlspecialchars($c['leaders']); ?></span>
                                </div>
                            <?php endif; ?>
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
