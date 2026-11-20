<?php
session_start();

// Tarayıcı önbelleğini kapat (Geri tuşu ile çıkış yapılmış panele dönülmesini engellemek için)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Giriş kontrolü (HTML çıktısı vermeden önce)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Sitedeki config yükleme
require_once __DIR__ . '/../config.php';

// Güvenli Yönlendirme Fonksiyonu (Headers already sent hatasını aşmak için)
function redirect($url) {
    if (!headers_sent()) {
        header("Location: " . $url);
        exit;
    } else {
        echo '<script>window.location.href="' . $url . '";</script>';
        echo '<noscript><meta http-equiv="refresh" content="0;url=' . $url . '"></noscript>';
        exit;
    }
}
?>
