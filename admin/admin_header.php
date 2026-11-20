<?php
// Aktif admin sayfası belirleme
$admin_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAGUF'26 - Yönetim Paneli</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
       <!-- Admin Arayüz CSS (Gelişmiş Sol Sidebar & Modern Dashboard - Web Temasıyla Uyumlu Dark) -->
    <style>
        :root {
            --primary-color: #85141C;    /* Bordo */
            --bg-dark: #4D090E;          /* Koyu Bordo */
            --bg-dark-active: #5E0C12;   /* Aktif Menü Arka Planı */
            --bg-light: #2C0508;         /* Koyu Bordo Gövde */
            --accent-color: #B98F42;      /* Altın */
            --accent-sub: #E25C3C;        /* Turuncu-Kızıl */
            --text-dark: #FFFFFF;        /* Beyaz Metin */
            --text-light: #FFFFFF;       /* Beyaz Metin */
            --border-color: rgba(185, 143, 66, 0.25); /* Altın Çerçeve */
            --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            --font-title: 'Cinzel', serif;
            --font-body: 'Montserrat', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-light);
            background-image: radial-gradient(circle, var(--primary-color) 0%, var(--bg-dark) 100%);
            color: var(--text-light);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- Panel Kapsayıcı Yapısı --- */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* --- SOL SİDEBAR --- */
        .admin-sidebar {
            width: 260px;
            background-color: var(--bg-dark);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
            transition: var(--transition);
            flex-shrink: 0;
            z-index: 100;
        }

        /* Sidebar Logo / Başlık */
        .sidebar-brand {
            padding: 30px 25px;
            border-bottom: 1px solid rgba(185, 143, 66, 0.15);
            text-align: center;
        }

        .sidebar-brand h1 {
            font-family: var(--font-title);
            font-size: 1.35rem;
            color: var(--text-light);
            letter-spacing: 1px;
            margin: 0;
        }

        .sidebar-brand p {
            font-size: 10px;
            color: var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 5px;
            font-weight: 600;
        }

        /* Menü Bölümleri */
        .sidebar-menu {
            flex: 1;
            padding: 20px 15px;
            list-style: none;
            overflow-y: auto;
        }

        .menu-section {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 25px 0 10px 10px;
        }

        .menu-section:first-child {
            margin-top: 5px;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding: 12px 15px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            transition: var(--transition);
        }

        .sidebar-menu a svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            transition: var(--transition);
        }

        .sidebar-menu a:hover {
            color: var(--text-light);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu a.active {
            color: var(--bg-dark);
            background-color: var(--accent-color);
            box-shadow: 0 4px 12px rgba(185, 143, 66, 0.25);
            font-weight: 600;
        }

        .sidebar-menu a.active svg {
            stroke: var(--bg-dark);
        }

        /* Kırmızı Çıkış Menüsü */
        .sidebar-menu a.menu-logout {
            color: #ff4d5b;
        }
        
        .sidebar-menu a.menu-logout:hover {
            background-color: rgba(220, 53, 69, 0.15);
            color: #ff4d5b;
        }

        /* --- SAĞ PANEL (İçerik Alanı) --- */
        .admin-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: transparent;
            min-width: 0;
        }

        /* Üst Panel Başlığı (Topbar) */
        .admin-topbar {
            height: 70px;
            background-color: var(--bg-dark);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-light);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: rgba(185, 143, 66, 0.1);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            border: 1px solid var(--accent-color);
        }

        .topbar-user svg {
            width: 16px;
            height: 16px;
            stroke: var(--accent-color);
            fill: none;
            stroke-width: 2;
        }

        /* Menü Toggle Butonu (Mobil) */
        .menu-toggle {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            color: var(--text-light);
        }

        .menu-toggle svg {
            width: 24px;
            height: 24px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        /* Ana İçerik Gövdesi */
        .admin-content-area {
            flex: 1;
            padding: 40px;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        /* --- DASHBOARD ÖZET KARTLARI --- */
        .dashboard-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background-color: rgba(77, 9, 14, 0.6);
            border-radius: 16px;
            border: 1px solid var(--accent-color);
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 170px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(185, 143, 66, 0.25);
            border-color: var(--white);
        }

        .card-header-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--accent-color);
            font-size: 14px;
            font-weight: 600;
        }

        .card-header-info svg {
            width: 18px;
            height: 18px;
            stroke: var(--accent-color);
            fill: none;
            stroke-width: 2;
        }

        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-light);
            margin: 15px 0 5px 0;
            font-family: var(--font-body);
        }

        .card-subtext {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
        }

        .card-btn {
            background-color: var(--accent-sub);
            color: var(--text-light);
            text-decoration: none;
            padding: 8px 25px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            width: fit-content;
            transition: var(--transition);
            border: 1px solid var(--accent-sub);
        }

        .card-btn:hover {
            background-color: transparent;
            color: var(--accent-sub);
            border-color: var(--accent-sub);
        }

        /* Hoş Geldiniz Banner */
        .welcome-banner {
            background-color: rgba(77, 9, 14, 0.6);
            border-radius: 16px;
            border: 1px solid var(--accent-color);
            padding: 40px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            margin-bottom: 35px;
        }

        .welcome-banner h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--accent-color);
        }

        .welcome-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(185, 143, 66, 0.15);
            padding-bottom: 20px;
        }

        .welcome-banner h4 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        .quick-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .quick-links a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .quick-links a:hover {
            color: var(--white);
            padding-left: 5px;
        }

        /* --- Sayfa Başlıkları --- */
        .admin-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .admin-page-header h2 {
            font-family: var(--font-title);
            font-size: 2rem;
            color: var(--white);
            margin: 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        /* Butonlar */
        .admin-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 6px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            outline: none;
        }

        .admin-btn-primary {
            background-color: var(--accent-color);
            color: var(--bg-light);
            border: 1px solid var(--accent-color);
        }

        .admin-btn-primary:hover {
            background-color: transparent;
            color: var(--white);
            border-color: var(--white);
        }

        .admin-btn-accent {
            background-color: var(--accent-sub);
            color: var(--white);
            border: 1px solid var(--accent-sub);
        }

        .admin-btn-accent:hover {
            background-color: transparent;
            color: var(--accent-sub);
            border-color: var(--accent-sub);
        }

        .admin-btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        .admin-btn-danger:hover {
            background-color: transparent;
            color: #dc3545;
        }

        .admin-btn-secondary {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid transparent;
        }

        .admin-btn-secondary:hover {
            background-color: transparent;
            color: white;
            border-color: white;
        }

        /* Bilgilendirme Kutuları */
        .admin-alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
        }

        .admin-alert-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: #2ee25d;
            border: 1px solid #28a745;
        }

        .admin-alert-danger {
            background-color: rgba(220, 53, 69, 0.15);
            color: #ff5a6a;
            border: 1px solid #dc3545;
        }

        /* Tablo Stilleri */
        .admin-table-container {
            background-color: rgba(77, 9, 14, 0.6);
            border: 1px solid var(--accent-color);
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            overflow-x: auto;
            margin-bottom: 30px;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
            color: #FFFFFF;
        }

        .admin-table th, .admin-table td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(185, 143, 66, 0.15);
        }

        .admin-table th {
            background-color: rgba(185, 143, 66, 0.15);
            font-weight: 700;
            color: var(--accent-color);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Form Stilleri */
        .admin-form-container {
            background-color: rgba(77, 9, 14, 0.6);
            border: 1px solid var(--accent-color);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            max-width: 800px;
            margin: 0 auto;
            color: #FFFFFF;
        }

        .admin-form-group {
            margin-bottom: 25px;
        }

        .admin-form-group label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            color: var(--accent-color);
            letter-spacing: 0.5px;
        }

        .admin-form-control {
            width: 100%;
            padding: 10px 15px;
            background-color: rgba(77, 9, 14, 0.4);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: #FFFFFF;
            font-family: var(--font-body);
            font-size: 14px;
            outline: none;
            transition: var(--transition);
        }

        .admin-form-control::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .admin-form-control:focus {
            border-color: var(--white);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.25);
            background-color: rgba(77, 9, 14, 0.6);
        }

        /* Toggle Düğmesi (Switch) */
        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #555;
            transition: .4s;
            border-radius: 24px;
            border: 1px solid var(--border-color);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--accent-color);
        }

        input:checked + .slider:before {
            transform: translateX(22px);
            background-color: var(--bg-dark);
        }

        /* Görsel Önizleme */
        .img-preview {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border-color);
            background-color: rgba(77, 9, 14, 0.5);
        }

        .img-preview-lg {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
            margin-top: 10px;
            display: block;
        }

        /* --- MOBİL UYUMLULUK --- */
        @media (max-width: 992px) {
            .admin-sidebar {
                position: fixed;
                left: -260px;
                height: 100vh;
                box-shadow: 5px 0 25px rgba(0,0,0,0.5);
            }

            .admin-sidebar.open {
                left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .admin-topbar {
                padding: 0 20px;
            }

            .dashboard-cards-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <!-- SOL SİDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <h1>SAGUF'26</h1>
            <p>Yönetim Paneli</p>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-section">Genel</li>
            <li>
                <a href="index.php" class="<?php echo ($admin_page == 'index.php') ? 'active' : ''; ?>">
                    <!-- Grid İkonu -->
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="settings.php" class="<?php echo ($admin_page == 'settings.php') ? 'active' : ''; ?>">
                    <!-- Dişli Çark İkonu -->
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Site Ayarları
                </a>
            </li>
            <li>
                <a href="navbar.php" class="<?php echo ($admin_page == 'navbar.php') ? 'active' : ''; ?>">
                    <!-- Menu İkonu -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    Menü Ayarları
                </a>
            </li>

            <li class="menu-section">İçerik Yönetimi</li>
            <li>
                <a href="committees.php" class="<?php echo ($admin_page == 'committees.php' || $admin_page == 'edit_committee.php') ? 'active' : ''; ?>">
                    <!-- Liste İkonu -->
                    <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    Komiteler
                </a>
            </li>
            <li>
                <a href="organization.php" class="<?php echo ($admin_page == 'organization.php' || $admin_page == 'edit_organization.php') ? 'active' : ''; ?>">
                    <!-- Kullanıcı Grubu İkonu -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Organizasyon
                </a>
            </li>
            <li>
                <a href="team.php" class="<?php echo ($admin_page == 'team.php' || $admin_page == 'edit_member.php') ? 'active' : ''; ?>">
                    <!-- Kullanıcı İkonu -->
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Ekip Üyeleri
                </a>
            </li>
            <li>
                <a href="apply_cards.php" class="<?php echo ($admin_page == 'apply_cards.php' || $admin_page == 'edit_apply_card.php') ? 'active' : ''; ?>">
                    <!-- Dosya/Kart İkonu -->
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Başvuru Kartları
                </a>
            </li>
            <li>
                <a href="page_banners.php" class="<?php echo ($admin_page == 'page_banners.php' || $admin_page == 'edit_page_banner.php') ? 'active' : ''; ?>">
                    <!-- Fotoğraf İkonu -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    Sayfa Başlıkları
                </a>
            </li>

            <li class="menu-section">Hesap</li>
            <li>
                <a href="logout.php" class="menu-logout">
                    <!-- Çıkış İkonu -->
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Çıkış Yap
                </a>
            </li>
        </ul>
    </aside>

    <!-- SAĞ PANEL -->
    <div class="admin-panel">
        <!-- Topbar -->
        <header class="admin-topbar">
            <!-- Mobil Hamburger -->
            <button class="menu-toggle" id="menuToggleBtn" aria-label="Menüyü Aç">
                <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <div class="topbar-title">
                <?php
                if ($admin_page === 'index.php') echo 'Dashboard';
                elseif ($admin_page === 'settings.php') echo 'Site Ayarları';
                elseif ($admin_page === 'navbar.php') echo 'Menü Ayarları';
                elseif ($admin_page === 'committees.php' || $admin_page === 'edit_committee.php') echo 'Komiteler';
                elseif ($admin_page === 'organization.php' || $admin_page === 'edit_organization.php') echo 'Organizasyon';
                elseif ($admin_page === 'team.php' || $admin_page === 'edit_member.php') echo 'Ekip Üyeleri';
                elseif ($admin_page === 'apply_cards.php' || $admin_page === 'edit_apply_card.php') echo 'Başvuru Kartları';
                elseif ($admin_page === 'page_banners.php' || $admin_page === 'edit_page_banner.php') echo 'Sayfa Başlıkları';
                ?>
            </div>

            <div class="topbar-user">
                <!-- Profil İkonu -->
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Admin User</span>
            </div>
        </header>

        <!-- İçerik Alanı -->
        <main class="admin-content-area">
