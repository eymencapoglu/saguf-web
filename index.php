<?php
require_once __DIR__ . '/header.php';
?>

<main>
    <!-- Anasayfa Hero Banner (Görsel ve Slogan) -->
    <div class="home-hero-banner" style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(77, 9, 14, 0.2) 60%, var(--primary-color) 100%), url('assets/images/sagufanasayfa.jpeg');">
        <div class="home-hero-content">
            <h1 class="home-hero-slogan">Egemenlik Kayıtsız Şartsız Milletindir</h1>
        </div>
    </div>

    <!-- Sayaç Başlığı ve Sayaç (Orijinal Tasarım) -->
    <div class="countdown-section" style="margin-top: 50px;">
        <p class="countdown-header-text"><?php echo htmlspecialchars($event_title); ?> Başlıyor</p>
        
        <div id="countdown-timer" class="countdown-wrapper" data-target="<?php echo $countdown_target; ?>">
            
            <!-- Gün -->
            <div class="time-box">
                <svg class="column-bg-svg" viewBox="0 0 120 180" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 15 25 L 105 25 A 8 8 0 0 0 115 17 A 8 8 0 0 0 105 9 L 15 9 A 8 8 0 0 0 5 17 A 8 8 0 0 0 15 25 Z" />
                    <circle cx="17" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="17" cy="22" r="5" fill="none" stroke-width="1" />
                    <circle cx="103" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="103" cy="22" r="5" fill="none" stroke-width="1" />
                    <path d="M 18 30 C 18 30, 8 30, 8 45 L 8 150 C 8 165, 23 172, 60 172 C 97 172, 112 165, 112 150 L 112 45 C 112 30, 102 30, 102 30 Z" />
                    <line x1="20" y1="45" x2="20" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="28" y1="42" x2="28" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="92" y1="42" x2="92" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="100" y1="45" x2="100" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                </svg>
                <div id="days" class="number">00</div>
                <div class="label">Gün</div>
            </div>

            <div class="colon">:</div>

            <!-- Saat -->
            <div class="time-box">
                <svg class="column-bg-svg" viewBox="0 0 120 180" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 15 25 L 105 25 A 8 8 0 0 0 115 17 A 8 8 0 0 0 105 9 L 15 9 A 8 8 0 0 0 5 17 A 8 8 0 0 0 15 25 Z" />
                    <circle cx="17" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="17" cy="22" r="5" fill="none" stroke-width="1" />
                    <circle cx="103" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="103" cy="22" r="5" fill="none" stroke-width="1" />
                    <path d="M 18 30 C 18 30, 8 30, 8 45 L 8 150 C 8 165, 23 172, 60 172 C 97 172, 112 165, 112 150 L 112 45 C 112 30, 102 30, 102 30 Z" />
                    <line x1="20" y1="45" x2="20" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="28" y1="42" x2="28" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="92" y1="42" x2="92" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="100" y1="45" x2="100" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                </svg>
                <div id="hours" class="number">00</div>
                <div class="label">Saat</div>
            </div>

            <div class="colon">:</div>

            <!-- Dakika -->
            <div class="time-box">
                <svg class="column-bg-svg" viewBox="0 0 120 180" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 15 25 L 105 25 A 8 8 0 0 0 115 17 A 8 8 0 0 0 105 9 L 15 9 A 8 8 0 0 0 5 17 A 8 8 0 0 0 15 25 Z" />
                    <circle cx="17" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="17" cy="22" r="5" fill="none" stroke-width="1" />
                    <circle cx="103" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="103" cy="22" r="5" fill="none" stroke-width="1" />
                    <path d="M 18 30 C 18 30, 8 30, 8 45 L 8 150 C 8 165, 23 172, 60 172 C 97 172, 112 165, 112 150 L 112 45 C 112 30, 102 30, 102 30 Z" />
                    <line x1="20" y1="45" x2="20" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="28" y1="42" x2="28" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="92" y1="42" x2="92" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="100" y1="45" x2="100" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                </svg>
                <div id="minutes" class="number">00</div>
                <div class="label">Dakika</div>
            </div>

            <div class="colon">:</div>

            <!-- Saniye -->
            <div class="time-box">
                <svg class="column-bg-svg" viewBox="0 0 120 180" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 15 25 L 105 25 A 8 8 0 0 0 115 17 A 8 8 0 0 0 105 9 L 15 9 A 8 8 0 0 0 5 17 A 8 8 0 0 0 15 25 Z" />
                    <circle cx="17" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="17" cy="22" r="5" fill="none" stroke-width="1" />
                    <circle cx="103" cy="22" r="9" fill="none" stroke-width="1.5" />
                    <circle cx="103" cy="22" r="5" fill="none" stroke-width="1" />
                    <path d="M 18 30 C 18 30, 8 30, 8 45 L 8 150 C 8 165, 23 172, 60 172 C 97 172, 112 165, 112 150 L 112 45 C 112 30, 102 30, 102 30 Z" />
                    <line x1="20" y1="45" x2="20" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="28" y1="42" x2="28" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="92" y1="42" x2="92" y2="148" stroke-dasharray="2 2" stroke-width="1" />
                    <line x1="100" y1="45" x2="100" y2="145" stroke-dasharray="2 2" stroke-width="1" />
                </svg>
                <div id="seconds" class="number">00</div>
                <div class="label">Saniye</div>
            </div>

        </div>
    </div>

    <!-- TBMM Silüeti ve SAGUF Yazısı Birleşik (Dikey Hizalanmış Tasarım) -->
    <div class="hero-brand-group">
        <!-- TBMM Silüeti -->
        <img src="assets/images/tbmm_2.png" alt="TBMM Silüeti" class="tbmm-siluet-main">
        
        <!-- Yazı Katmanı (Silüetin Hemen Altında) -->
        <div class="brand-text-under">
            <h1 class="brand-main-title">SAGUF'26</h1>
            <p class="brand-sub-title">SAKARYA GENÇLİK ULUSAL FORUMU</p>
            <div class="brand-divider">❖</div>
        </div>
    </div>

    <!-- Scroll Down Hakkımızda (SAGUF'26 Nedir?) Bölümü -->
    <section class="page-section about-section" style="width: 100%; max-width: 1150px; margin-top: 100px; border-top: 1px solid rgba(185, 143, 66, 0.2); padding-top: 80px; text-align: left;">
        
        <div style="max-width: 900px; margin: 0 auto; width: 100%;">
            <h2 class="page-title" style="margin-bottom: 30px;">SAGUF'26 Nedir?</h2>

            <blockquote class="about-quote">
                "Gelecek, farklı fikirlerin ortak sesinde yükselecek."
            </blockquote>

            <div class="about-text">
                <p>
                    <strong style="color: var(--accent-color); font-weight: 700;">24-25-26 Ekim</strong> tarihlerinde Sakarya’da gerçekleştirilecek olan <strong style="color: var(--accent-color); font-weight: 700;">SAGUF’26 (Sakarya Gençlik Ulusal Forumu)</strong>, Sakarya’nın ilk ve tek bağımsız ulusal forumu olarak gençleri, Türkiye Cumhuriyeti’nin güncel ve stratejik meselelerini değerlendirmek üzere ortak bir zeminde buluşturmaktadır.
                </p>
                
                <p>
                    SAGUF’26; eğitim, sağlık, adalet, milli güvenlik ve dış politika gibi ülkemizin geleceğinde belirleyici rol oynayan alanlarda gençlerin fikir üretmesine, çözüm önerileri geliştirmesine ve farklı bakış açılarını yapıcı bir diyalog ortamında bir araya getirmesine olanak sağlamaktadır. Bilimsel düşünceyi, katılımcılığı ve ortak aklı esas alan forum, gençlerin karar alma süreçlerine yönelik farkındalıklarını artırmayı ve toplumsal sorumluluk bilincini güçlendirmeyi amaçlamaktadır.
                </p>

                <p>
                    Türkiye’nin geleceğine yön verecek gençleri bir araya getiren SAGUF’26, fikirlerin özgürce paylaşıldığı, iş birliğinin teşvik edildiği ve ortak vizyonun güçlendirildiği saygın bir platform olarak katılımcılarına nitelikli bir forum deneyimi sunmaktadır.
                </p>
            </div>
        </div>

        <?php 
        $any_hl_detail_active = (
            (isset($settings['hl_date_active']) && $settings['hl_date_active'] == '1') ||
            (isset($settings['hl_location_active']) && $settings['hl_location_active'] == '1') ||
            (isset($settings['hl_participants_active']) && $settings['hl_participants_active'] == '1') ||
            (isset($settings['hl_language_active']) && $settings['hl_language_active'] == '1')
        );
        $show_highlights = (isset($settings['highlights_active']) && $settings['highlights_active'] == '1' && $any_hl_detail_active);
        ?>
        <!-- Sekreterya Mektubu ve Detay Kartı Bölümü -->
        <div class="secretariat-section-wrapper <?php echo $show_highlights ? 'has-highlights' : ''; ?>">
            
            <!-- Sekreterya Mektubu Alt Kartı -->
            <div class="secretariat-card">
                <div class="secretariat-header">
                    <div class="secretariat-title-block">
                        <h3>SAGUF'26 Sekreterya Mektubu</h3>
                        <p>Sakarya Gençlik Ulusal Forumu</p>
                    </div>
                </div>
                
                <div class="secretariat-content">
                    <p class="secretariat-greeting">Sayın Katılımcılar,</p>
                    <p>Sakarya’nın ilk ve tek bağımsız ulusal forumuna hepiniz hoş geldiniz!</p>
                    <p>
                        SAGUF’26’yı ekibimiz ile birlikte sizler için büyük bir özen, sorumluluk ve heyecanla birlikte hazırlıyoruz. Sürecin her aşamasında aktif olarak yer alıyor, sizlere düzenli, adil ve ilham verici bir forum deneyimi sunmayı hedefliyoruz.
                    </p>
                    <p>
                        SAGUF’26; gençlerin bir araya gelerek fikir ürettiği, farklı bakış açılarını paylaştığı ve ortak bir gelecek vizyonu etrafında buluştuğu bir platform olarak tasarlanmaktadır. Bizler de bu yapının güçlü, verimli ve herkes için faydalı bir şekilde ilerlemesi adına katkı sağlıyor, tüm süreci birlikte şekillendiriyoruz.
                    </p>
                    <p>
                        Temel amacımız; her katılımcının kendini özgürce ifade edebildiği, fikirlerin saygı çerçevesinde değerlendirildiği ve yapıcı bir atmosferin hâkim olduğu bir ortam oluşturmaktır. Bu doğrultuda, forumun her detayını titizlikle planlıyor ve en iyi deneyimi sunmak için çalışıyoruz.
                    </p>
                    <p>
                        SAGUF’26’nın, yalnızca akademik bir ortam değil; aynı zamanda keyifli vakit geçirilen, yeni dostlukların kurulduğu ve farklı bakış açılarını kazandığı bir deneyim olması en büyük dileğimizdir. Buradan ayrılırken “iyi ki SAGUF’26” diyebileceğiniz bir forum oluşturmak için tüm gücümüzle çalışıyoruz.
                    </p>
                    <p>
                        Sizleri aramızda görmekten büyük mutluluk duyuyor, SAGUF’26’da birlikte güçlü, verimli ve unutulmaz bir deneyim yaşamayı sabırsızlıkla bekliyoruz.
                    </p>
                    
                    <p class="secretariat-closing">En içten saygılarımızla,</p>
                </div>

                <!-- İmzalar -->
                <div class="secretariat-signatures">
                    <div class="signature-col">
                        <div class="signature-svg-wrapper">
                            <img src="assets/images/nehir_huma_imza_v4.png" alt="Nehir Hüma Can İmza" class="signature-img-file">
                        </div>
                        <strong>Nehir Hüma CAN</strong>
                        <span>Konferans Divanı</span>
                    </div>
                    <div class="signature-col">
                        <div class="signature-svg-wrapper">
                            <img src="assets/images/bilal_mazlum_imza.png" alt="Bilal Mazlum İmza" class="signature-img-file">
                        </div>
                        <strong>Bilal MAZLUM</strong>
                        <span>Konferans Divan Yardımcısı</span>
                    </div>
                </div>
            </div>

            <!-- Konferans Detayları Kartı (Highlights) -->
            <?php if ($show_highlights): ?>
            <div class="highlights-card">
                <h3 class="highlights-title"><?php echo htmlspecialchars($settings['highlights_title'] ?? 'Konferans Bilgileri', ENT_QUOTES, 'UTF-8'); ?></h3>
                
                <div class="highlights-list">
                    <?php if (isset($settings['hl_date_active']) && $settings['hl_date_active'] == '1'): ?>
                    <div class="highlight-item">
                        <div class="highlight-icon-wrapper">
                            <svg class="highlight-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </div>
                        <div class="highlight-info">
                            <span class="highlight-label">Tarih</span>
                            <span class="highlight-value"><?php echo htmlspecialchars($settings['hl_date_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($settings['hl_location_active']) && $settings['hl_location_active'] == '1'): ?>
                    <div class="highlight-item">
                        <div class="highlight-icon-wrapper">
                            <svg class="highlight-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div class="highlight-info">
                            <span class="highlight-label">Yer</span>
                            <span class="highlight-value"><?php echo htmlspecialchars($settings['hl_location_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($settings['hl_participants_active']) && $settings['hl_participants_active'] == '1'): ?>
                    <div class="highlight-item">
                        <div class="highlight-icon-wrapper">
                            <svg class="highlight-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <div class="highlight-info">
                            <span class="highlight-label">Katılımcılar</span>
                            <span class="highlight-value"><?php echo htmlspecialchars($settings['hl_participants_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($settings['hl_language_active']) && $settings['hl_language_active'] == '1'): ?>
                    <div class="highlight-item">
                        <div class="highlight-icon-wrapper">
                            <svg class="highlight-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </div>
                        <div class="highlight-info">
                            <span class="highlight-label">Etkinlik Dili</span>
                            <span class="highlight-value"><?php echo htmlspecialchars($settings['hl_language_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Sıkça Sorulan Sorular Bölümü -->
    <section class="page-section faq-section" style="width: 100%; max-width: 900px; text-align: left;">
        <h2 class="page-title" style="margin-bottom: 10px;">Sıkça Sorulan Sorular</h2>
        <p class="page-subtitle" style="text-align: center; margin-bottom: 40px;">SAGUF'26 hakkında en çok merak edilen konular</p>

        <div class="faq-container">
            <!-- Soru 1 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Ulusal Forum Nedir?</span>
                    <svg class="faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                       Ulusal Forum, katılımcıların belirlenen gündem doğrultusunda ülke sorunlarını tartışıp çözüm önerileri geliştirdiği bir simülasyondur. Açılış töreninin ardından katılımcılar komitelerine geçerek gündem maddelerini değerlendirir, sorunları tespit eder ve çözüm önerilerini oylayarak ortak bir Sonuç Bildirgesi hazırlar. Hazırlanan bildirgeler forumun son gününde Genel Meclis’te sunulur, diğer komitelerin soruları yanıtlanır ve oylamaya açılır.Süreç boyunca katılımcılar aktif tartışma, ekip çalışması, müzakere ve demokratik karar alma deneyimi kazanır.
                    </div>
                </div>
            </div>

            <!-- Soru 2 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Nasıl Başvuru Yapabilirim?</span>
                    <svg class="faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                         Başvurular, saguf.org adresinde bulunan Başvurular sayfası üzerinden gerçekleştirilmektedir. Başvuru sürecine ilişkin tüm güncel duyuru ve bilgilendirmeler, resmî sosyal medya hesaplarımız ve internet sitemiz aracılığıyla paylaşılmaktadır.
                    </div>
                </div>
            </div>

            <!-- Soru 3 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Ulusal Forumun İşleyişi Nasıldır?</span>
                    <svg class="faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Konferans açılış töreni ile başlar.Açılış töreninin ardından delegeler komitelerine geçerek çalışmalarına başlar. Komitelerde gündem maddeleri doğrultusunda sorunlar belirlenir, çözüm önerileri geliştirilir ve oylamalarla ortak kararlar alınır. Kabul edilen öneriler komite tarafından Sonuç Bildirgesi hâline getirilir. Forumun son gününde bildirgeler Genel Meclis’te sunulur, diğer komitelerin soru ve değerlendirmeleri alınır ve oylama gerçekleştirilir.Süreç boyunca katılımcılar müzakere, ekip çalışması ve demokratik karar alma deneyimi kazanır.
                    </div>
                </div>
            </div>

            <!-- Soru 4 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Kıyafet Kuralı Nedir?</span>
                    <svg class="faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Konferans süresince tüm katılımcıların resmî kıyafet prosedürüne uymaları zorunludur. Prosedüre aykırı hareket eden katılımcılar, Konferans Divanının kararı doğrultusunda Genel Meclis’te söz alma ve kürsüye çıkma haklarını kaybedebilirler.
                    </div>
                </div>
            </div>

            <!-- Soru 5 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Yiyecek ve İçecek Sağlanacak mı?</span>
                    <svg class="faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Konferans programı kapsamında katılımcılara gerekli ikramlar ile yemek hizmeti organizasyon tarafından sağlanacaktır.
                    </div>
                </div>
            </div>

            <!-- Soru 6 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Komite veya Görev Değişikliği Yapılabilir mi?</span>
                    <svg class="faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Komite yerleşimleri, organizasyon ve akademik ekip tarafından konferansın planlaması doğrultusunda belirlenmektedir. Programın düzenli ve verimli bir şekilde yürütülebilmesi amacıyla komite değişikliği talepleri, istisnai durumlar haricinde değerlendirmeye alınmamaktadır.
                    </div>
                </div>
            </div>

            <!-- Soru 7 -->
            <div class="faq-item">
                <button class="faq-question">
                    <span>Katılım Belgesi Verilecek mi?</span>
                    <svg class="faq-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                       Evet. Konferans kurallarına uygun hareket eden ve zorunlu oturum katılımını sağlayan tüm katılımcılara Katılım Belgesi takdim edilecektir. Ancak oturum yoklamalarına katılmayan veya konferans süresince iki akademik uyarı alan katılımcılar, Katılım Belgesi almaya hak kazanamayacaktır.
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Sekreterya Mektubu ve SSS Accordion Stilleri -->
<style>
    main {
        padding: 0 !important;
    }
    .about-section, .faq-section {
        padding-left: 20px !important;
        padding-right: 20px !important;
        box-sizing: border-box;
    }

    /* --- Anasayfa Hero Banner Stilleri --- */
    .home-hero-banner {
        width: 100%;
        height: 550px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        z-index: 5;
    }
    .home-hero-content {
        padding: 20px;
        max-width: 950px;
        z-index: 2;
    }
    .home-hero-slogan {
        font-family: var(--font-title);
        font-size: 3.2rem;
        font-weight: 800;
        color: var(--white);
        line-height: 1.4;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.8);
        animation: fadeIn 1.5s ease-out;
    }

    /* --- Temaya Uygun Sayaç Stilleri --- */
    .countdown-section {
        text-align: center;
        margin: 50px auto 20px auto;
        width: 100%;
        max-width: 800px;
        z-index: 5;
        position: relative;
    }
    .countdown-header-text {
        font-family: var(--font-body);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 20px;
        font-weight: 600;
    }
    .countdown-wrapper-simple {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }
    .time-box-simple {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 90px;
    }
    .number-simple {
        font-family: var(--font-title);
        font-size: 3.2rem;
        font-weight: 700;
        color: var(--white);
        line-height: 1;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }
    .label-simple {
        font-family: var(--font-body);
        font-size: 0.65rem;
        font-weight: 700;
        color: var(--accent-color);
        letter-spacing: 1px;
        margin-top: 8px;
        background-color: rgba(255, 255, 255, 0.05);
        padding: 3px 8px;
        border-radius: 4px;
        border: 1px solid rgba(185, 143, 66, 0.15);
    }
    .time-separator-simple {
        font-size: 2.2rem;
        color: rgba(255, 255, 255, 0.3);
        font-weight: 300;
        position: relative;
        top: -12px;
    }

    /* --- TBMM ve SAGUF Marka Grubu (HTML/CSS Tasarım) --- */
    .hero-brand-group {
        width: 100%;
        max-width: 850px;
        margin: 40px auto 20px auto;
        z-index: 5;
        position: relative;
        padding: 0 20px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: center;
        animation: fadeIn 1.8s ease-out;
    }
    .tbmm-siluet-main {
        width: 100%;
        height: auto;
        display: block;
        max-width: 850px;
    }
    .brand-text-under {
        text-align: center;
        width: 100%;
        margin-top: -35px;
        z-index: 6;
        position: relative;
    }
    .brand-main-title {
        font-family: var(--font-title);
        font-size: 5.2rem;
        font-weight: 800;
        color: var(--white);
        margin: 0;
        line-height: 1;
        letter-spacing: 5px;
        text-shadow: 0 4px 25px rgba(0, 0, 0, 0.95), 0 2px 10px rgba(0, 0, 0, 0.9);
    }
    .brand-sub-title {
        font-family: var(--font-body);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--accent-color);
        margin: 15px 0 0 0;
        letter-spacing: 6px;
        text-transform: uppercase;
        text-shadow: 0 2px 12px rgba(0, 0, 0, 0.95);
    }
    .brand-divider {
        color: var(--accent-color);
        margin-top: 15px;
        font-size: 1.25rem;
        opacity: 0.85;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.9);
        letter-spacing: 8px;
    }

    @media (max-width: 768px) {
        .home-hero-banner {
            height: 380px;
        }
        .home-hero-slogan {
            font-size: 1.8rem;
        }
        .hero-brand-group {
            margin: 30px auto 10px auto;
        }
        .brand-text-under {
            margin-top: -15px;
        }
        .brand-main-title {
            font-size: 2.8rem;
            letter-spacing: 2px;
        }
        .brand-sub-title {
            font-size: 0.75rem;
            letter-spacing: 2.5px;
            margin-top: 8px;
        }
        .brand-divider {
            margin-top: 8px;
            font-size: 0.9rem;
        }
    }

    /* Responsive Düzenler ve Genel Bölüm Ayarları */
    .about-section {
        margin-top: 100px;
        border-top: 1px solid rgba(185, 143, 66, 0.2);
        padding-top: 80px;
        max-width: 900px;
        text-align: left;
        animation: none !important;
        opacity: 1 !important;
        transform: none !important;
    }

    .faq-section {
        margin-top: 80px;
        animation: none !important;
        opacity: 1 !important;
        transform: none !important;
    }

    .about-quote {
        font-family: var(--font-title);
        font-size: clamp(1.2rem, 4.5vw, 1.8rem);
        color: var(--accent-color);
        text-align: center;
        margin-bottom: 40px;
        font-weight: 700;
        line-height: 1.5;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .about-text {
        font-size: 15px;
        font-weight: 300;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.95);
        text-align: justify;
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 50px;
    }

    /* Sekreterya Mektubu ve Detay Kartı Düzeni */
    .secretariat-section-wrapper {
        display: block;
        width: 100%;
        margin-top: 30px;
    }

    .secretariat-section-wrapper:not(.has-highlights) .secretariat-card {
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .secretariat-section-wrapper.has-highlights {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    .secretariat-card {
        background: #FFFFFF;
        color: #333333;
        border-radius: 16px;
        padding: 45px 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        border: 2px solid var(--accent-color);
        width: 100%;
        transition: var(--transition);
    }

    .secretariat-section-wrapper.has-highlights .secretariat-card {
        flex: 1.6;
        width: auto;
        margin-top: 0;
    }

    .secretariat-card:hover {
        box-shadow: 0 20px 45px rgba(185, 143, 66, 0.15);
    }

    /* Konferans Detayları Kartı (Highlights) */
    .highlights-card {
        flex: 0.9;
        max-width: 360px;
        background: #FFFFFF;
        color: #333333;
        border-radius: 16px;
        padding: 35px 25px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        border: 2px solid var(--accent-color);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .highlights-card:hover {
        box-shadow: 0 20px 45px rgba(185, 143, 66, 0.15);
    }
    
    .highlights-title {
        font-family: var(--font-title);
        font-size: 1.45rem;
        font-weight: 700;
        color: #3d0814;
        text-align: center;
        margin: 0 0 25px 0;
        letter-spacing: 0.5px;
    }
    
    .highlights-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        flex-grow: 1;
    }
    
    .highlight-item {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(185, 143, 66, 0.05);
        padding: 15px 20px;
        border-radius: 12px;
        border: 1px solid rgba(185, 143, 66, 0.08);
        transition: var(--transition);
    }

    .highlight-item:hover {
        background: rgba(185, 143, 66, 0.09);
        transform: translateY(-2px);
    }
    
    .highlight-icon-wrapper {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #3d0814;
        color: #B98F42;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .highlight-icon-svg {
        width: 20px;
        height: 20px;
    }
    
    .highlight-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
        text-align: left;
    }
    
    .highlight-label {
        font-family: var(--font-body);
        font-size: 0.95rem;
        font-weight: 700;
        color: #3d0814;
        text-transform: capitalize;
        letter-spacing: 0.2px;
    }
    
    .highlight-value {
        font-family: var(--font-body);
        font-size: 0.88rem;
        color: #444444;
        font-weight: 600;
        line-height: 1.4;
    }

    .secretariat-header {
        text-align: center;
        border-bottom: 1.5px solid rgba(133, 20, 28, 0.15);
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    .secretariat-title-block h3 {
        font-family: var(--font-title);
        font-size: clamp(1.2rem, 4vw, 1.7rem);
        color: var(--primary-color);
        margin: 0;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: 0.5px;
    }

    .secretariat-title-block p {
        font-family: var(--font-body);
        font-size: 0.85rem;
        color: #666666;
        margin: 5px 0 0 0;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 600;
    }

    .secretariat-content {
        font-family: var(--font-body);
        font-size: 0.95rem;
        line-height: 1.8;
        color: #444444;
        text-align: justify;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .secretariat-greeting {
        font-weight: 700;
        color: #111111;
        font-size: 1.05rem;
        margin-bottom: 5px;
    }

    .secretariat-closing {
        margin-top: 15px;
        font-weight: 700;
        color: #111111;
        text-align: right;
    }

    .secretariat-signatures {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 15px;
        border-top: 1px solid rgba(0, 0, 0, 0.);
        padding-top: 25px;
        text-align: center;
    }

    .signature-col {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .signature-svg-wrapper {
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .signature-img-file {
        height: 65px;
        width: auto;
        mix-blend-mode: multiply;
        filter: brightness(0);
        display: block;
    }

    .signature-col strong {
        color: #222222;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .signature-col span {
        color: #666666;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 3px;
    }

    /* Şık ve Zarif SSS Tasarımı (Kutusuz, İnce Beyaz/Altın Çizgisel) */
    .faq-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        margin-top: 10px;
    }

    .faq-item {
        background: none !important;
        border: none !important;
        border-bottom: 1.5px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        border-bottom-color: rgba(185, 143, 66, 0.4) !important;
        background: none !important;
    }

    .faq-question {
        width: 100%;
        background: none !important;
        border: none !important;
        padding: 22px 0 !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: left;
        color: var(--white) !important;
        font-family: var(--font-body);
        font-size: 1.15rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        outline: none;
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        color: var(--accent-color) !important;
    }

    .faq-chevron {
        color: var(--accent-color);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), stroke 0.3s ease;
        flex-shrink: 0;
    }

    .faq-item.active .faq-chevron {
        transform: rotate(180deg);
        color: var(--white);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
        opacity: 0;
    }

    .faq-item.active .faq-answer {
        opacity: 1;
    }

    .faq-answer-content {
        padding: 0 0 22px 0;
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.95rem;
        line-height: 1.8;
        font-weight: 300;
        text-align: left;
    }

    /* Mobil Responsive Düzenler (Mobile Native Koruma) */
    @media (max-width: 768px) {
        .about-section {
            margin-top: 40px !important;
            padding-top: 40px !important;
            border-top: 1px solid rgba(185, 143, 66, 0.15) !important;
        }

        .faq-section {
            margin-top: 45px !important;
        }

        .page-section {
            padding: 40px 10px !important; /* side margins to give a bit of breathe */
        }

        .about-quote {
            font-size: 1.25rem !important;
            margin-bottom: 25px !important;
        }

        .about-text {
            font-size: 14px !important;
            line-height: 1.7 !important;
            text-align: left !important;
            gap: 15px !important;
            margin-bottom: 30px !important;
        }

        .secretariat-section-wrapper.has-highlights {
            flex-direction: column;
            gap: 25px;
        }
        .secretariat-section-wrapper.has-highlights .secretariat-card {
            flex: none;
            width: 100%;
        }
        .highlights-card {
            flex: none;
            max-width: 100% !important;
            width: 100%;
            padding: 30px 20px;
        }

        .secretariat-card {
            padding: 30px 20px !important;
            margin-top: 20px;
        }

        .secretariat-header {
            text-align: center;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .secretariat-content {
            font-size: 0.88rem !important;
            line-height: 1.75 !important;
            text-align: left !important;
            gap: 14px !important;
        }

        .secretariat-greeting {
            font-size: 0.92rem !important;
            text-align: left !important;
            margin-bottom: 2px !important;
        }

        .secretariat-closing {
            margin-top: 10px !important;
            text-align: right !important;
        }

        .secretariat-signatures {
            grid-template-columns: 1fr !important;
            gap: 25px !important;
            padding-top: 20px !important;
        }

        .faq-question {
            padding: 18px 0 !important;
            font-size: 0.98rem;
        }

        .faq-answer-content {
            padding: 0 0 18px 0;
            font-size: 0.88rem;
            line-height: 1.7;
            text-align: left;
        }
    }
</style>

<!-- Accordion Toggle JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const item = question.parentElement;
            const answer = item.querySelector('.faq-answer');
            const isActive = item.classList.contains('active');
            
            // Diğer açık akordeonları yumuşakça kapat
            document.querySelectorAll('.faq-item').forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-answer').style.maxHeight = null;
                }
            });
            
            if (isActive) {
                item.classList.remove('active');
                answer.style.maxHeight = null;
            } else {
                item.classList.add('active');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });
});
</script>

<?php
require_once __DIR__ . '/footer.php';
?>
