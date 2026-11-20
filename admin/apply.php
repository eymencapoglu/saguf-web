<?php
require_once __DIR__ . '/config.php';

// Başvuru kartlarını JSON'dan yükle
$apply_cards_file = __DIR__ . '/apply_cards.json';
$apply_cards = [];
if (file_exists($apply_cards_file)) {
    $apply_cards = json_decode(file_get_contents($apply_cards_file), true);
    if (!is_array($apply_cards)) {
        $apply_cards = [];
    }
}

// Yalnızca aktif kartları filtrele
$active_cards = array_filter($apply_cards, function($card) {
    return $card['active'] === true;
});

require_once __DIR__ . '/header.php';
?>

<!-- Özel Başvuru Sayfası Stilleri (Pill Butonlar, Ücret Kapsülleri) -->
<style>
    .apply-page-bg {
        background-color: var(--primary-color);
        background-image: 
            radial-gradient(circle, var(--primary-color) 0%, var(--bg-dark) 100%),
            repeating-linear-gradient(45deg, rgba(185, 143, 66, 0.03) 0px, rgba(185, 143, 66, 0.03) 2px, transparent 2px, transparent 40px),
            repeating-linear-gradient(-45deg, rgba(185, 143, 66, 0.03) 0px, rgba(185, 143, 66, 0.03) 2px, transparent 2px, transparent 40px);
        width: 100%;
        min-height: calc(100vh - 170px);
        padding: 60px 20px;
    }

    .apply-header {
        text-align: center;
        margin-bottom: 50px;
        animation: slideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .apply-header h1 {
        font-family: var(--font-title);
        font-size: 4rem;
        font-weight: 800;
        color: var(--white);
        letter-spacing: 3px;
        margin-bottom: 10px;
        text-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }

    .apply-header p {
        font-family: var(--font-body);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--accent-color);
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    /* Başvuru Kartları Izgarası */
    .apply-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        animation: slideUp 1.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .apply-card {
        background-color: rgba(77, 9, 14, 0.65);
        border: 2px solid rgba(185, 143, 66, 0.35);
        border-radius: 28px;
        padding: 45px 35px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 360px; /* Bir satırda 3 adet olması için maks genişlik */
        min-height: 420px; /* Min height düşürüldü */
        gap: 25px; /* Kart içi öğelerin arasına dengeli boşluk */
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Görseldeki gibi kart hover olduğunda turuncu/kızıl parlama efekti */
    .apply-card:hover {
        transform: translateY(-10px);
        border-color: #E25C3C;
        box-shadow: 0 15px 35px rgba(226, 92, 60, 0.25);
    }

    .apply-card h3 {
        font-family: var(--font-body);
        font-size: 1.7rem;
        font-weight: 700;
        color: #E25C3C; /* Turuncu-kızıl başlık rengi */
        margin-bottom: 20px;
        letter-spacing: 0.5px;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .apply-card:hover h3 {
        color: var(--white);
    }

    .apply-card p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.95rem;
        font-weight: 300;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    /* Ücret Kapsülü (Pill Badge) */
    .fee-capsule {
        display: inline-block;
        background-color: rgba(226, 92, 60, 0.12);
        border: 2px solid #E25C3C;
        color: #E25C3C;
        border-radius: 30px;
        padding: 8px 35px;
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 25px;
        letter-spacing: 0.5px;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .apply-card:hover .fee-capsule {
        background-color: var(--white);
        border-color: var(--white);
        color: var(--bg-dark);
    }

    /* APPLY NOW Butonu (Pill Button) */
    .btn-apply-now {
        background-color: #E25C3C;
        color: var(--white);
        border: 2px solid #E25C3C;
        padding: 12px 40px;
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 14px;
        border-radius: 30px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        width: 80%;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(226, 92, 60, 0.3);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-apply-now:hover {
        background-color: transparent;
        color: var(--white);
        border-color: var(--white);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    }

    /* Mobil Uyumluluk */
    @media (max-width: 768px) {
        .apply-header h1 {
            font-size: 2.8rem;
        }
        .apply-header p {
            font-size: 0.95rem;
        }
        .apply-grid {
            grid-template-columns: 1fr;
            max-width: 100%;
        }
        .apply-card {
            padding: 35px 25px;
            min-height: 420px;
        }
        .apply-card h3 {
            font-size: 1.4rem;
        }
    }
</style>

<div class="apply-page-bg">
    <section class="page-section" style="padding: 0; max-width: 1400px; animation: none;">
        
        <div class="apply-header">
            <h1>ŞİMDİ BAŞVUR</h1>
            <p>SAGUF'26'YA KATIL</p>
        </div>

        <!-- Başvuru Kartları -->
        <?php if ($apply_status === 'open' && !empty($active_cards)): ?>
            <div class="apply-grid">
                <?php foreach ($active_cards as $card): ?>
                    <div class="apply-card">
                        
                        <div style="width: 100%;">
                            <!-- Kart Başlığı -->
                            <h3><?php echo htmlspecialchars($card['title']); ?></h3>
                            
                            <!-- Açıklama -->
                            <p><?php echo htmlspecialchars($card['description']); ?></p>
                        </div>

                        <div style="width: 100%;">
                            <!-- Ücret Kapsülü -->
                            <div class="fee-capsule">
                                <?php echo htmlspecialchars($card['fee']); ?>
                            </div>

                            <!-- Yönlendirme Butonu -->
                            <a href="<?php echo htmlspecialchars($card['redirect_url']); ?>" target="_blank" rel="noopener noreferrer" class="btn-apply-now" style="margin-left: auto; margin-right: auto;">
                                <?php echo htmlspecialchars($card['button_text']); ?>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Başvurular Kapalı Durumu -->
            <div class="apply-container" style="text-align: center; padding: 50px 30px; margin-top: 30px;">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--accent-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <h3 style="margin-bottom: 10px; font-family: var(--font-title); font-size: 1.6rem; color: var(--white);">Başvurular Kapalıdır</h3>
                <p style="color: rgba(255,255,255,0.7); font-size: 14px; max-width: 500px; margin: 0 auto;">SAGUF'26 başvuruları şu an için kapalı durumdadır. Başvuru duyuruları ve süreç güncellemeleri için sosyal medya hesaplarımızı takip edebilirsiniz.</p>
            </div>
        <?php endif; ?>

    </section>
</div>

<?php
require_once __DIR__ . '/footer.php';
?>
