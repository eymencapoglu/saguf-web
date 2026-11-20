<?php
require_once __DIR__ . '/config.php';

// Komiteleri JSON'dan yükle
$committees_file = __DIR__ . '/committees.json';
$committees = [];
if (file_exists($committees_file)) {
    $committees = json_decode(file_get_contents($committees_file), true);
    if (!is_array($committees)) {
        $committees = [];
    }
}

// Yalnızca aktif komiteleri filtrele
$active_committees = array_filter($committees, function($c) {
    return isset($c['active']) && $c['active'] === true;
});

require_once __DIR__ . '/header.php';
?>

<!-- Özel Komite Sayfası Stilleri (UNEP Tarzı Kart Tasarımı & Detay Pop-up Modal) -->
<style>
    /* Kart Izgarası ve Esnek Merkezleme */
    .committees-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 35px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Görseldeki Tarzda Komite Kartı (Tam Boyut Arka Plan Görseli) */
    .committee-card {
        background-color: var(--bg-dark);
        border: 1px solid var(--accent-color);
        border-radius: 20px;
        width: 100%;
        max-width: 330px; /* Görselle uyumlu boyut */
        height: 380px; /* Sabit yükseklik ile simetrik görünüm */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        cursor: pointer;
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: flex-end; /* İçeriği alta yasla */
    }

    .committee-card:hover {
        transform: translateY(-8px);
        border-color: var(--white);
        box-shadow: 0 15px 35px rgba(185, 143, 66, 0.35);
    }

    /* Arka Plan Görsel Katmanı */
    .committee-card-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
    }

    .committee-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .committee-card:hover .committee-card-img {
        transform: scale(1.08); /* Yumuşak yakınlaşma efekti */
    }

    .committee-card-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--bg-dark) 100%);
    }

    /* Yazının Okunabilirliği İçin Degrade Karartma */
    .committee-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(17, 2, 4, 0.2) 0%, rgba(17, 2, 4, 0.75) 50%, rgba(17, 2, 4, 0.98) 100%);
        z-index: 2;
        transition: var(--transition);
    }

    .committee-card:hover .committee-card-overlay {
        background: linear-gradient(to bottom, rgba(17, 2, 4, 0.1) 0%, rgba(17, 2, 4, 0.65) 45%, rgba(17, 2, 4, 0.95) 100%);
    }

    /* Kart Gövdesi (Ön Planda) */
    .committee-card-body {
        padding: 25px;
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: none; /* Tıklamayı arka plana geçir */
    }

    .committee-card-body h3 {
        font-family: var(--font-body);
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 10px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        text-shadow: 0 2px 4px rgba(0,0,0,0.6);
    }

    .committee-card-body p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.88rem;
        font-weight: 300;
        line-height: 1.5;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }

    /* Altın Vurgulu Buton */
    .committee-card-more {
        color: var(--accent-color);
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }

    .committee-card:hover .committee-card-more {
        color: var(--white);
        padding-left: 5px;
    }

    /* Modal Tasarımı (TBMM / SAGUF Temasına Uygun Premium Glassmorphism) */
    .committee-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.85);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 20px;
    }

    .committee-modal.open {
        opacity: 1;
        pointer-events: auto;
    }

    .committee-modal-content {
        background-color: var(--primary-color);
        background-image: radial-gradient(circle, var(--primary-color) 0%, var(--bg-dark) 100%);
        border: 2px solid var(--accent-color);
        border-radius: 24px;
        width: 100%;
        max-width: 600px;
        padding: 35px;
        position: relative;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        transform: translateY(30px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        max-height: 90vh;
        overflow-y: auto;
    }

    .committee-modal.open .committee-modal-content {
        transform: translateY(0);
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 32px;
        color: var(--accent-color);
        cursor: pointer;
        background: none;
        border: none;
        line-height: 1;
        transition: var(--transition);
        z-index: 10;
    }

    .close-btn:hover {
        color: var(--white);
    }

    .modal-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .modal-logo {
        width: 90px;
        height: 90px;
        margin: 0 auto 15px auto;
        border-radius: 50%;
        border: 2px solid var(--accent-color);
        overflow: hidden;
        background-color: var(--bg-dark);
    }

    .modal-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-title {
        font-family: var(--font-title);
        color: var(--white);
        font-size: 1.8rem;
        margin: 0;
        letter-spacing: 1px;
    }

    .modal-body p {
        font-size: 0.95rem;
        font-weight: 300;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
        text-align: justify;
    }

    .chairs-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        border-top: 1px solid rgba(185, 143, 66, 0.2);
        padding-top: 25px;
        margin-bottom: 30px;
    }

    .chair-box {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .chair-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 1.5px solid var(--accent-color);
        object-fit: cover;
    }

    .chair-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 1.5px solid var(--accent-color);
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: var(--bg-dark);
        color: var(--accent-color);
        font-size: 20px;
    }

    .chair-info h4 {
        font-size: 11px;
        color: var(--accent-color);
        text-transform: uppercase;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .chair-info strong {
        font-size: 13px;
        color: var(--white);
        display: block;
        margin-top: 2px;
    }

    .modal-footer {
        display: flex;
        justify-content: center;
    }

    /* Mobil Düzen */
    @media (max-width: 768px) {
        .committees-grid {
            gap: 25px;
        }
        .committee-card {
            max-width: 300px;
        }
        .chairs-container {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .committee-modal-content {
            padding: 25px 20px;
        }
        .modal-title {
            font-size: 1.4rem;
        }
    }
</style>

<main>
    <section class="page-section">
        <?php if (!isset($active_page_banner) || !$active_page_banner): ?>
            <h1 class="page-title">Komiteler</h1>
            <p class="page-subtitle">SAGUF'26 kapsamında delege ve komite başkanlarımızın çalışacağı alanlar</p>
        <?php endif; ?>

        <div class="committees-grid">
            <?php if (empty($active_committees)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: rgba(255,255,255,0.7);">
                    Komiteler çok yakında açıklanacaktır. Lütfen takipte kalın!
                </div>
            <?php else: ?>
                <?php foreach ($active_committees as $c): ?>
                    <a href="committee.php?id=<?php echo urlencode($c['id']); ?>" class="committee-card-link" style="text-decoration: none; color: inherit; display: block; width: 100%; max-width: 300px;">
                        <div class="committee-card">
                            
                            <!-- Arka Plan Kapak Görseli ve Overlay -->
                            <div class="committee-card-bg">
                                <?php if (!empty($c['cover_image']) && file_exists(__DIR__ . '/' . $c['cover_image'])): ?>
                                    <img class="committee-card-img" src="<?php echo htmlspecialchars($c['cover_image']); ?>" alt="<?php echo htmlspecialchars($c['name']); ?>">
                                <?php else: ?>
                                    <div class="committee-card-placeholder">
                                        <svg width="45" height="45" viewBox="0 0 24 24" fill="none" stroke="var(--accent-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    </div>
                                <?php endif; ?>
                                <div class="committee-card-overlay"></div>
                            </div>

                            <!-- Kart Gövdesi (Üzerine Bindirilmiş) -->
                            <div class="committee-card-body">
                                <h3><?php echo htmlspecialchars($c['name']); ?></h3>
                                <p>&ldquo;<?php echo htmlspecialchars($c['description']); ?>&rdquo;</p>
                                <span class="committee-card-more">DETAYLI BİLGİ &rarr;</span>
                            </div>

                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/footer.php';
?>