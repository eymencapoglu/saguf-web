<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sakarya Gençlik Ulusal Forumu SAGUF'26 resmi web sitesi. Gençlerin parlak geleceğe adım attığı yer.">
    <title><?php echo $event_title; ?> - <?php echo $event_subtitle; ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;800&family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Gömülü CSS (Vanilla CSS) -->
    <style>
        :root {
            --primary-color: #85141C; /* Ana Bordo */
            --bg-dark: #4D090E;       /* Koyu Bordo (Navbar, Footer, Gölgeler) */
            --accent-color: #B98F42;   /* Altın */
            --accent-sub: #b49052;     /* Altın Alt Tonu */
            --white: #FFFFFF;
            --transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            --font-title: 'Cinzel', serif;
            --font-body: 'Montserrat', sans-serif;
        }

        /* Temel Sıfırlama ve Body */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--primary-color);
            background-image: radial-gradient(circle, var(--primary-color) 0%, var(--bg-dark) 100%);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* --- Üst Menü (Header / Navbar) --- */
        header.nav-header {
            background-color: var(--bg-dark);
            border-bottom: 1px solid rgba(185, 143, 66, 0.25);
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 100;
            transition: var(--transition);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 8%;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Logo Ayarları */
        .logo-circle {
            width: 70px;
            height: 70px;
            border: 2px solid var(--accent-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: var(--primary-color);
            box-shadow: 0 0 12px rgba(185, 143, 66, 0.25);
            transition: var(--transition);
        }

        .logo-circle:hover {
            transform: scale(1.05) rotate(5deg);
            border-color: var(--white);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.35);
        }

        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* Nav Bağlantıları */
        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 8px 0;
            position: relative;
            transition: var(--transition);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent-color);
            transition: var(--transition);
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--white);
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-links a.active {
            font-weight: 700;
        }

        /* Hamburger Butonu (Mobil) */
        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            z-index: 101;
            padding: 5px;
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            margin: 5px 0;
            background-color: var(--accent-color);
            transition: var(--transition);
        }

        /* --- Ana İçerik --- */
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
        }

        /* --- index.php Hero / Geri Sayım Tasarımı --- */
        .tbmm-silhouette-wrapper {
            width: 100%;
            max-width: 650px;
            height: auto;
            opacity: 0.9;
            margin-bottom: -35px;
            z-index: 1;
            animation: fadeIn 2s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .tbmm-svg {
            width: 100%;
            height: auto;
        }

        .title-section {
            text-align: center;
            z-index: 2;
            margin-bottom: 30px;
        }

        .title-section h1 {
            font-family: var(--font-title);
            font-size: 7.5rem;
            margin: 0;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--white);
            line-height: 1.1;
            text-shadow: 2px 2px 20px rgba(0,0,0,0.4);
        }

        .title-section h2 {
            font-family: var(--font-body);
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: 4px;
            margin: 10px 0;
            color: var(--accent-color);
            text-shadow: 1px 1px 8px rgba(0,0,0,0.3);
        }

        .divider {
            color: var(--accent-color);
            font-size: 1.2rem;
            margin: 15px 0 25px 0;
            letter-spacing: 5px;
            opacity: 0.8;
        }

        /* Geri Sayım Alanı */
        .countdown-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            z-index: 2;
            margin-top: 10px;
            animation: slideUp 1.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .time-box {
            position: relative;
            width: 125px;
            height: 175px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .column-bg-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            stroke: var(--accent-color);
            stroke-width: 1.5;
            fill: rgba(77, 9, 14, 0.4);
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
            transition: var(--transition);
            z-index: 1;
        }

        .time-box:hover .column-bg-svg {
            stroke: var(--white);
            fill: rgba(133, 20, 28, 0.5);
            filter: drop-shadow(0 0 15px rgba(185, 143, 66, 0.5));
        }

        .number {
            font-family: var(--font-title);
            font-size: 3.8rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
            z-index: 2;
            margin-top: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .label {
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 400;
            color: var(--white);
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 2;
            margin-top: 5px;
        }

        .colon {
            font-size: 3rem;
            color: var(--accent-color);
            font-weight: bold;
            z-index: 2;
            position: relative;
            top: -5px;
            animation: blink 1s infinite;
        }

        /* --- Genel Kart ve Sayfa Yapıları (Bordo Arka Plan / Altın Çerçeve) --- */
        .page-section {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            z-index: 5;
            animation: slideUp 1.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .page-title {
            text-align: center;
            font-family: var(--font-title);
            font-size: 2.8rem;
            color: var(--white);
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .page-subtitle {
            text-align: center;
            color: var(--accent-color);
            font-size: 1.1rem;
            font-weight: 400;
            letter-spacing: 1px;
            margin-bottom: 50px;
        }

        /* Komiteler Sayfası */
        .committees-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            width: 100%;
        }

        /* Kartların Arka Planı Bordo Olacak */
        .committee-card {
            background-color: var(--primary-color);
            border: 2px solid var(--accent-color);
            border-radius: 15px;
            padding: 35px 25px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .committee-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: var(--accent-color);
            transition: var(--transition);
        }

        .committee-card:hover {
            transform: translateY(-8px);
            border-color: var(--white);
            box-shadow: 0 12px 30px rgba(185, 143, 66, 0.25);
        }

        .committee-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(185, 143, 66, 0.1);
            border: 1px solid var(--accent-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px auto;
            color: var(--accent-color);
            font-size: 24px;
            transition: var(--transition);
        }

        .committee-card:hover .committee-icon {
            background-color: var(--accent-color);
            color: var(--bg-dark);
            transform: scale(1.1);
        }

        .committee-card h3 {
            font-family: var(--font-title);
            font-size: 1.4rem;
            color: var(--white);
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .committee-card p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.95rem;
            font-weight: 300;
            line-height: 1.6;
        }

        /* Yönetim (Executive) Sayfası */
        .executive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 35px;
            width: 100%;
        }

        .executive-card {
            background-color: var(--primary-color);
            border: 2px solid var(--accent-color);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: var(--transition);
        }

        .executive-card:hover {
            transform: translateY(-5px);
            border-color: var(--white);
            box-shadow: 0 12px 30px rgba(185, 143, 66, 0.25);
        }

        .executive-img-wrapper {
            position: relative;
            width: 100%;
            padding-top: 100%;
            background-color: var(--bg-dark);
            border-bottom: 2px solid var(--accent-color);
            overflow: hidden;
        }

        .executive-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .executive-card:hover .executive-img {
            transform: scale(1.05);
        }

        .executive-info {
            padding: 20px 15px;
        }

        .executive-info h3 {
            font-family: var(--font-title);
            font-size: 1.25rem;
            color: var(--white);
            margin-bottom: 5px;
        }

        .executive-info p {
            color: var(--accent-color);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Başvuru (Apply) ve İletişim (Contact) Sayfası */
        .apply-container, .contact-container {
            max-width: 750px;
            margin: 0 auto;
            background-color: var(--primary-color);
            border: 2px solid var(--accent-color);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--white);
            letter-spacing: 1px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(77, 9, 14, 0.4);
            border: 1px solid var(--accent-color);
            border-radius: 8px;
            color: var(--white);
            font-family: var(--font-body);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--white);
            box-shadow: 0 0 10px rgba(255,255,255,0.2);
            background-color: rgba(77, 9, 14, 0.6);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23B98F42' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--bg-dark);
            border: 2px solid var(--accent-color);
            padding: 14px 30px;
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary:hover {
            background-color: transparent;
            color: var(--white);
            border-color: var(--white);
            box-shadow: 0 5px 15px rgba(255,255,255,0.15);
        }

        /* İletişim Bilgileri Kartları */
        .contact-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
            text-align: center;
        }

        .contact-info-card {
            background-color: var(--bg-dark);
            border: 1px solid var(--accent-color);
            padding: 25px 15px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .contact-info-card:hover {
            border-color: var(--white);
        }

        .contact-info-card h4 {
            color: var(--accent-color);
            font-family: var(--font-title);
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .contact-info-card p, .contact-info-card a {
            font-size: 0.95rem;
            color: var(--white);
            text-decoration: none;
        }

        /* --- Sayfa Altı (Footer) --- */
        footer.page-footer {
            background-color: var(--bg-dark);
            border-top: 1px solid rgba(185, 143, 66, 0.25);
            padding: 30px 8%;
            width: 100%;
            margin-top: auto;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-container p:last-child {
            color: var(--accent-color);
            font-weight: 600;
        }

        /* --- Animasyonlar --- */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.35; }
        }

        /* --- MOBİL UYUMLULUK (Mobile-Native Responsive Ayarları) --- */
        @media (max-width: 992px) {
            .navbar {
                padding: 12px 5%;
            }

            .title-section h1 {
                font-size: 5rem;
            }

            .title-section h2 {
                font-size: 1.1rem;
                letter-spacing: 2px;
            }

            .countdown-wrapper {
                gap: 15px;
            }

            .time-box {
                width: 105px;
                height: 150px;
            }

            .number {
                font-size: 3rem;
            }

            .label {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 768px) {
            /* Mobil Hamburger ve Kayar Menü */
            .hamburger {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                height: 100vh;
                background-color: var(--bg-dark);
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 40px;
                z-index: 100;
                transition: 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
                box-shadow: -5px 0 25px rgba(0, 0, 0, 0.5);
                border-left: 2px solid var(--accent-color);
            }

            .nav-links.active {
                right: 0;
            }

            /* Hamburger Animasyon Dönüşümü (X Efekti) */
            .hamburger.active span:nth-child(1) {
                transform: translateY(8px) rotate(45deg);
            }
            
            .hamburger.active span:nth-child(2) {
                opacity: 0;
            }
            
            .hamburger.active span:nth-child(3) {
                transform: translateY(-8px) rotate(-45deg);
            }

            /* Hero Alanı Mobil Ayarlar */
            .tbmm-silhouette-wrapper {
                margin-bottom: -15px;
                max-width: 90%;
            }

            .title-section h1 {
                font-size: 3.5rem;
            }

            .title-section h2 {
                font-size: 0.95rem;
                letter-spacing: 1.5px;
            }

            .countdown-wrapper {
                flex-wrap: wrap;
                max-width: 280px;
                margin: 20px auto 0 auto;
                gap: 15px 10px;
            }

            .colon {
                display: none; /* Mobilde kolonlar yerine 2x2 düzeni için gizlenir */
            }

            .time-box {
                width: 120px;
                height: 140px;
                padding: 10px;
            }

            .number {
                font-size: 2.8rem;
                margin-top: 10px;
            }

            /* Diğer Sayfalar */
            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 0.95rem;
                margin-bottom: 30px;
            }

            .apply-container, .contact-container {
                padding: 25px 20px;
            }

            .form-group style {
                grid-template-columns: 1fr !important;
                gap: 0 !important;
            }
            
            .form-row-mobile {
                display: block !important;
            }
            
            .form-row-mobile > div {
                margin-bottom: 20px;
            }

            .footer-container {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- Üst Menü Başlangıcı -->
    <header class="nav-header">
        <div class="navbar">
            <div class="logo-container">
                <a href="index.php" class="logo-circle" aria-label="SAGUF'26 Anasayfa">
                    <!-- Dinamik PNG Logo -->
                    <img src="assets/images/logo.png" alt="SAGUF'26 Logo">
                </a>
            </div>

            <!-- Hamburger Butonu (Mobil) -->
            <button class="hamburger" aria-label="Menüyü Aç/Kapat">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Menü Bağlantıları -->
            <ul class="nav-links">
                <li><a href="index.php" class="<?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>">Anasayfa</a></li>
                <li><a href="committees.php" class="<?php echo ($current_page == 'committees.php') ? 'active' : ''; ?>">Komiteler</a></li>
                <li><a href="executive.php" class="<?php echo ($current_page == 'executive.php') ? 'active' : ''; ?>">Executive</a></li>
                <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">İletişim</a></li>
                <li><a href="<?php echo htmlspecialchars($apply_url); ?>" class="<?php echo ($current_page == 'apply.php') ? 'active' : ''; ?>">Başvuru</a></li>
            </ul>
        </div>
    </header>
    <!-- Üst Menü Bitişi -->
