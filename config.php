<?php
// SAGUF'26 Web Sitesi Konfigürasyon Dosyası
require_once __DIR__ . '/security.php';

$settings_path = __DIR__ . '/settings.json';
$settings = [];

if (file_exists($settings_path)) {
    $json_content = file_get_contents($settings_path);
    $settings = json_decode($json_content, true);
}

// Varsayılan değerler (eğer json okunamadıysa)
$event_title = isset($settings['event_title']) ? $settings['event_title'] : "SAGUF'26";
$event_subtitle = isset($settings['event_subtitle']) ? $settings['event_subtitle'] : "SAKARYA GENÇLİK ULUSAL FORUMU";
$countdown_target = isset($settings['countdown_target']) ? $settings['countdown_target'] : "2026-09-15T09:00:00";
$apply_status = isset($settings['apply_status']) ? $settings['apply_status'] : "open";
$apply_url = isset($settings['apply_url']) ? $settings['apply_url'] : "apply.php";
$social_instagram = isset($settings['social_instagram']) ? $settings['social_instagram'] : "https://instagram.com/saguf26";
$contact_email = isset($settings['contact_email']) ? $settings['contact_email'] : "info@saguf.org";

// Aktif sayfa belirleme
$current_page = basename($_SERVER['PHP_SELF']);
?>
