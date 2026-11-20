<?php
require_once __DIR__ . '/config.php';

// Komite ID'sini GET parametresinden al
$id = isset($_GET['id']) ? trim($_GET['id']) : '';

$committees_file = __DIR__ . '/committees.json';
$committee = null;

if (file_exists($committees_file)) {
    $committees = json_decode(file_get_contents($committees_file), true);
    if (is_array($committees)) {
        foreach ($committees as $c) {
            if ($c['id'] === $id && ($c['active'] ?? false)) {
                $committee = $c;
                break;
            }
        }
    }
}

// Komite bulunamazsa ana sayfaya yönlendir
if (!$committee) {
    header("Location: committees.php");
    exit;
}

require_once __DIR__ . '/header.php';
?>

<!-- Özel Komite Detay Sayfası Tasarımı -->
<!-- Custom Banner (Komiteye Özel) -->
<div class="page-banner-section" style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(133, 20, 28, 0.15) 50%, rgba(133, 20, 28, 0.85) 85%, var(--primary-color) 100%), url('<?php echo !empty($committee['cover_image']) && file_exists(__DIR__ . '/' . $committee['cover_image']) ? htmlspecialchars($committee['cover_image']) : 'assets/images/sagufkomite.jpeg'; ?>');">
    <div class="page-banner-content">
        <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 3px; color: var(--accent-color); font-weight: 700; display: block; margin-bottom: 8px;">Sakarya Gençlik Ulusal Forumu</span>
        <h1 class="page-banner-title" style="font-size: 4rem;"><?php echo htmlspecialchars($committee['name']); ?></h1>
        <p class="page-banner-subtitle" style="font-size: 1.1rem; max-width: 900px;"><?php echo htmlspecialchars($committee['description']); ?></p>
    </div>
</div>

<main>
    <div class="committee-detail-container">
        <!-- 2 Sütunlu Yerleşim -->
        <div class="committee-detail-layout">
            
            <!-- Sol Kolon: Komite Hakkında & Detaylar -->
            <div class="detail-left-col">
                <div class="detail-card">
                    <h2 class="detail-card-title">Komite Hakkında</h2>
                    <div class="detail-card-divider"></div>
                    <div class="detail-card-text">
                        <h3 style="color: var(--accent-color); font-family: var(--font-body); font-size: 1.25rem; font-weight: 700; margin-bottom: 15px; line-height: 1.5;">Gündem Maddesi / Agenda Item:</h3>
                        <p style="font-size: 1.1rem; font-weight: 600; color: var(--white); margin-bottom: 25px; line-height: 1.6; padding-left: 15px; border-left: 3px solid var(--accent-color);">
                            &ldquo;<?php echo htmlspecialchars($committee['description']); ?>&rdquo;
                        </p>
                        
                        <h3 style="color: var(--accent-color); font-family: var(--font-body); font-size: 1.15rem; font-weight: 700; margin-bottom: 10px;">Açıklama:</h3>
                        <p>
                            SAGUF'26 bünyesinde yer alan bu komitemizde delegelerimiz, belirtilen akademik konular üzerinde araştırmalarını sürdürerek, ülkemizin ve dünyanın güncel sorunlarına çözüm üretmek amacıyla Sonuç Bildirgeleri hazırlayacaktır. Forum süresince yapıcı tartışmalar ve diplomasi dili esas alınacaktır.
                        </p>
                    </div>

                    <?php if (!empty($committee['study_guide']) && file_exists(__DIR__ . '/' . $committee['study_guide'])): ?>
                        <div style="margin-top: 35px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px;">
                            <a href="<?php echo htmlspecialchars($committee['study_guide']); ?>" target="_blank" class="btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.95rem; text-decoration: none; padding: 14px 30px; width: auto; border-radius: 30px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                Çalışma Kılavuzunu İndir (PDF)
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sağ Kolon: Akademik Kadro (Chairs) -->
            <div class="detail-right-col">
                <div class="detail-card">
                    <h2 class="detail-card-title">Akademik Takım</h2>
                    <div class="detail-card-divider"></div>
                    
                    <div class="detail-chairs-list" style="gap: 20px; display: flex; flex-direction: column;">
                        
                        <!-- Chair (Komite Başkanı) -->
                        <?php if (!empty($committee['chair_name'])): ?>
                            <div class="detail-chair-item">
                                <div class="detail-chair-img-wrapper">
                                    <?php if (!empty($committee['chair_photo']) && file_exists(__DIR__ . '/' . $committee['chair_photo'])): ?>
                                        <img class="detail-chair-img" src="<?php echo htmlspecialchars($committee['chair_photo']); ?>" alt="<?php echo htmlspecialchars($committee['chair_name']); ?>">
                                    <?php else: ?>
                                        <div class="detail-chair-placeholder">👤</div>
                                    <?php endif; ?>
                                </div>
                                <div class="detail-chair-info">
                                    <strong><?php echo htmlspecialchars($committee['chair_name']); ?></strong>
                                    <span><?php echo htmlspecialchars($committee['chair_title'] ?? 'Komite Başkanı'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Co-Chair (Eş Başkan) -->
                        <?php if (!empty($committee['co_chair_name'])): ?>
                            <div class="detail-chair-item">
                                <div class="detail-chair-img-wrapper">
                                    <?php if (!empty($committee['co_chair_photo']) && file_exists(__DIR__ . '/' . $committee['co_chair_photo'])): ?>
                                        <img class="detail-chair-img" src="<?php echo htmlspecialchars($committee['co_chair_photo']); ?>" alt="<?php echo htmlspecialchars($committee['co_chair_name']); ?>">
                                    <?php else: ?>
                                        <div class="detail-chair-placeholder">👤</div>
                                    <?php endif; ?>
                                </div>
                                <div class="detail-chair-info">
                                    <strong><?php echo htmlspecialchars($committee['co_chair_name']); ?></strong>
                                    <span><?php echo htmlspecialchars($committee['co_chair_title'] ?? 'Co-Chair'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($committee['chair_name']) && empty($committee['co_chair_name'])): ?>
                            <p style="color: rgba(255,255,255,0.5); text-align: center; font-size: 13px; padding: 20px 0;">Bu komite için akademik takım henüz eklenmemiştir.</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    /* Detay Sayfası Konteyneri */
    .committee-detail-container {
        width: 100%;
        max-width: 1200px;
        margin: 50px auto 80px auto;
        padding: 0 20px;
    }

    .committee-detail-layout {
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 35px;
        align-items: start;
    }

    /* Detay Kartı Tasarımları */
    .detail-card {
        background-color: rgba(77, 9, 14, 0.5);
        border: 1px solid var(--accent-color);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .detail-card-title {
        font-family: var(--font-title);
        font-size: 1.6rem;
        color: var(--white);
        letter-spacing: 1px;
    }

    .detail-card-divider {
        width: 60px;
        height: 2px;
        background-color: var(--accent-color);
        margin: 15px 0 25px 0;
    }

    .detail-card-text {
        font-size: 0.98rem;
        line-height: 1.8;
        color: rgba(255,255,255,0.9);
        font-weight: 300;
        text-align: justify;
    }

    /* Akademik Takım Tasarımları */
    .detail-chairs-list {
        display: flex;
        flex-direction: column;
    }

    .detail-chair-item {
        background-color: rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(185, 143, 66, 0.15);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: var(--transition);
    }

    .detail-chair-item:hover {
        border-color: var(--accent-color);
        background-color: rgba(185, 143, 66, 0.08);
        transform: translateY(-2px);
    }

    .detail-chair-img-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--accent-color);
        flex-shrink: 0;
        background-color: rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detail-chair-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-chair-placeholder {
        font-size: 32px;
    }

    .detail-chair-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-chair-info strong {
        font-size: 1.1rem;
        color: var(--white);
        font-weight: 600;
    }

    .detail-chair-info span {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--accent-color);
        font-weight: 700;
    }

    /* Responsive Tasarım */
    @media (max-width: 992px) {
        .committee-detail-layout {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .detail-card {
            padding: 30px 25px;
        }
    }
</style>

<?php
require_once __DIR__ . '/footer.php';
?>
