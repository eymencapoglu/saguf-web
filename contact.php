<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/header.php';
?>

<!-- Özel İletişim Stilleri (Diamond Arka Plan ve Kart Parlaması) -->
<style>
    /* İletişim Sayfası Özel Arka Plan (Baklava / Diamond Desenli) */
    .contact-page-bg {
        background-color: var(--primary-color);
        background-image: 
            radial-gradient(circle, var(--primary-color) 0%, var(--bg-dark) 100%),
            repeating-linear-gradient(45deg, rgba(185, 143, 66, 0.03) 0px, rgba(185, 143, 66, 0.03) 2px, transparent 2px, transparent 40px),
            repeating-linear-gradient(-45deg, rgba(185, 143, 66, 0.03) 0px, rgba(185, 143, 66, 0.03) 2px, transparent 2px, transparent 40px);
        width: 100%;
        min-height: calc(100vh - 170px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 60px 20px;
    }

    .contact-header {
        text-align: center;
        margin-bottom: 50px;
        animation: slideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .contact-header h1 {
        font-family: var(--font-title);
        font-size: 4rem;
        font-weight: 800;
        color: var(--white);
        letter-spacing: 3px;
        margin-bottom: 10px;
        text-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }

    .contact-header p {
        font-family: var(--font-body);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--accent-color);
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    /* 4 Kutucuk Izgarası */
    .contact-tiles-grid {
        display: grid;
        grid-template-columns: repeat(4, 180px);
        gap: 30px;
        justify-content: center;
        align-items: center;
        max-width: 900px;
        width: 100%;
        animation: slideUp 1.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .contact-tile {
        background-color: rgba(77, 9, 14, 0.6);
        border: 2px solid rgba(185, 143, 66, 0.3);
        border-radius: 24px;
        aspect-ratio: 1 / 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: var(--white);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .contact-tile svg {
        width: 42px;
        height: 42px;
        stroke: var(--white);
        fill: none;
        stroke-width: 1.5;
        margin-bottom: 15px;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .contact-tile span {
        font-family: var(--font-body);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Görseldeki Aktif Turuncu-Kırmızı/Altın Parlama Hover Efekti */
    .contact-tile:hover {
        background-color: #E25C3C; /* Turuncu-kızıl vurgu rengi */
        border-color: #E25C3C;
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(226, 92, 60, 0.45);
    }

    .contact-tile:hover svg {
        transform: scale(1.1);
        stroke: var(--white);
    }

    .contact-tile:hover span {
        color: var(--white);
        font-weight: 700;
    }

    /* Modal (Telefon Listesi İçin Popup) */
    .phone-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .phone-modal.open {
        opacity: 1;
        pointer-events: auto;
    }

    .phone-modal-content {
        background-color: var(--primary-color);
        background-image: radial-gradient(circle, var(--primary-color) 0%, var(--bg-dark) 100%);
        border: 2px solid var(--accent-color);
        border-radius: 24px;
        width: 90%;
        max-width: 500px;
        padding: 35px;
        position: relative;
        box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        transform: translateY(30px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .phone-modal.open .phone-modal-content {
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
    }

    .close-btn:hover {
        color: var(--white);
    }

    .modal-title {
        font-family: var(--font-title);
        color: var(--white);
        font-size: 1.6rem;
        margin-bottom: 20px;
        border-bottom: 2px solid rgba(185, 143, 66, 0.2);
        padding-bottom: 10px;
        text-align: center;
    }

    .contact-item {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 15px;
    }

    .contact-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .contact-role {
        font-size: 11px;
        font-weight: 700;
        color: var(--accent-color);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .contact-name {
        font-size: 16px;
        font-weight: 600;
        color: var(--white);
        margin-bottom: 6px;
    }

    .contact-phone-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--white);
        font-size: 14px;
        text-decoration: none;
        font-weight: 400;
        transition: var(--transition);
        width: fit-content;
    }

    .contact-phone-link:hover {
        color: var(--accent-color);
        padding-left: 5px;
    }

    .contact-phone-link svg {
        width: 14px;
        height: 14px;
        stroke: var(--accent-color);
        fill: none;
        stroke-width: 2;
    }

    /* Mobil Uyumluluk */
    @media (max-width: 768px) {
        .contact-tiles-grid {
            grid-template-columns: repeat(2, 140px);
            gap: 20px;
        }
        .contact-header h1 {
            font-size: 2.8rem;
        }
        .contact-header p {
            font-size: 0.95rem;
        }
        .contact-tile svg {
            width: 32px;
            height: 32px;
            margin-bottom: 10px;
        }
        .contact-tile span {
            font-size: 10px;
        }
        .phone-modal-content {
            padding: 25px;
        }
        .modal-title {
            font-size: 1.3rem;
        }
    }
</style>

<div class="contact-page-bg">
    
    <?php if (!isset($active_page_banner) || !$active_page_banner): ?>
        <div class="contact-header">
            <h1>İLETİŞİM</h1>
            <p>BİZE ULAŞIN</p>
        </div>
    <?php endif; ?>

    <!-- 4 Kutucuk Izgarası -->
    <div class="contact-tiles-grid">
        
        <!-- INSTAGRAM -->
        <a href="https://www.instagram.com/saguf26?utm_source=ig_web_button_share_sheet&igsh=ODdmZWVhMTFiMw==" target="_blank" rel="noopener noreferrer" class="contact-tile">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg>
            <span>Instagram</span>
        </a>

        <!-- TIKTOK -->
        <a href="https://www.tiktok.com/@saguf26?_r=1&_t=ZS-96lYttzp5aa" target="_blank" rel="noopener noreferrer" class="contact-tile">
            <!-- TikTok SVG İkonu -->
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
            </svg>
            <span>TikTok</span>
        </a>

        <!-- PHONE -->
        <div id="phoneTileBtn" class="contact-tile">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span>Telefon</span>
        </div>

        <!-- EMAIL -->
        <a href="mailto:saguf26halklailiskiler@gmail.com" class="contact-tile">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            <span>E-posta</span>
        </a>

    </div>

</div>

<!-- Telefon Modal Pop-up -->
<div id="phoneModal" class="phone-modal">
    <div class="phone-modal-content">
        <button class="close-btn" id="closeModalBtn">&times;</button>
        <h3 class="modal-title">Telefon İletişim Rehberi</h3>
        
        <!-- Kişi 1 -->
        <div class="contact-item">
            <span class="contact-role">Konferans Divanı</span>
            <span class="contact-name">Nehir Hüma CAN</span>
            <a href="tel:05437112828" class="contact-phone-link">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                0 543 711 28 28
            </a>
        </div>

        <!-- Kişi 2 -->
        <div class="contact-item">
            <span class="contact-role">Konferans Divan Yardımcısı</span>
            <span class="contact-name">Bilal MAZLUM</span>
            <a href="tel:05518462440" class="contact-phone-link">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                0 551 846 24 40
            </a>
        </div>

        <!-- Kişi 3 -->
        <div class="contact-item">
            <span class="contact-role">Genel Koordinatör</span>
            <span class="contact-name">Berra ÖZKAN</span>
            <a href="tel:05323529378" class="contact-phone-link">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                0 532 352 93 78
            </a>
        </div>

        <!-- Kişi 4 -->
        <div class="contact-item">
            <span class="contact-role">Genel Koordinatör</span>
            <span class="contact-name">Elif TOPRAK</span>
            <a href="tel:05359337154" class="contact-phone-link">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                0 535 933 71 54
            </a>
        </div>
        <!-- Kişi 5 -->
        <div class="contact-item">
            <span class="contact-role">Genel Koordinatör</span>
            <span class="contact-name">Umut Can AYBAŞ</span>
            <a href="tel:05359337154" class="contact-phone-link">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                0 545 511 06 45
            </a>
        </div>
        <!-- Kişi 6 -->
                <div class="contact-item">
                    <span class="contact-role">Konferans Danışmanı</span>
                    <span class="contact-name">Esin OĞUZ</span>
                    <a href="tel:05437112828" class="contact-phone-link">
                        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        0 505 989 65 70
                    </a>
                </div>
    </div>
</div>

<!-- Modal Etkileşim Scripti -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const phoneTileBtn = document.getElementById('phoneTileBtn');
        const phoneModal = document.getElementById('phoneModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        if (phoneTileBtn && phoneModal && closeModalBtn) {
            // Modalı Aç
            phoneTileBtn.addEventListener('click', () => {
                phoneModal.classList.add('open');
            });

            // Modalı Kapat (X butonu ile)
            closeModalBtn.addEventListener('click', () => {
                phoneModal.classList.remove('open');
            });

            // Modalı Kapat (Dışarı tıklayarak)
            phoneModal.addEventListener('click', (e) => {
                if (e.target === phoneModal) {
                    phoneModal.classList.remove('open');
                }
            });
        }
    });
</script>

<?php
require_once __DIR__ . '/footer.php';
?>
