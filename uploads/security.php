<?php
// security.php - Anti-DDoS ve Bot Koruma Rate Limiter (IP Bazlı)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_client_ip() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    }
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '127.0.0.1';
}

function rate_limit_check() {
    // Admin panelini veya giriş yapmış yöneticileri rate limit dışı bırak
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        return;
    }
    $req_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($req_uri, '/admin/') !== false || strpos($req_uri, 'admin/') !== false) {
        return;
    }

    $ip = get_client_ip();
    
    // Güvenli klasör yapısı (Yazma izni olan uploads altında)
    $dir = __DIR__ . '/uploads/rate_limit';
    if (!file_exists($dir)) {
        @mkdir($dir, 0755, true);
        @file_put_contents($dir . '/index.html', '');
    }

    // Çöp Toplayıcı (Garbage Collection - %1 ihtimalle 10 dakikadan eski limit loglarını temizler)
    if (rand(1, 100) === 1) {
        $files = glob($dir . '/limit_*.json');
        $now = time();
        foreach ($files as $file) {
            if ($now - @filemtime($file) > 600) {
                @unlink($file);
            }
        }
    }

    $ip_hash = md5($ip);
    $limit_file = $dir . '/limit_' . $ip_hash . '.json';
    
    $time_window = 5; // saniye aralığı
    $max_requests = 2500; // Saniyede 500 istek hızı limiti (5 saniyede 2500 istek)
    $cooldown_time = 10; // Engellendiğinde bekleme süresi (saniye)

    $now = time();
    $requests = [];
    $blocked_until = 0;

    if (file_exists($limit_file)) {
        $raw_data = @file_get_contents($limit_file);
        $data = json_decode($raw_data, true);
        if (is_array($data)) {
            $requests = $data['requests'] ?? [];
            $blocked_until = $data['blocked_until'] ?? 0;
        }
    }

    // IP şu an engelli durumdaysa engellemeye devam et
    if ($blocked_until > $now) {
        $retry_after = $blocked_until - $now;
        header("HTTP/1.1 429 Too Many Requests");
        header("Retry-After: $retry_after");
        render_blocked_page($retry_after);
        exit;
    }

    // Zaman penceresi dışındaki eski istekleri filtrele
    $requests = array_filter($requests, function($timestamp) use ($now, $time_window) {
        return ($now - $timestamp) < $time_window;
    });

    // İstek limit aşımı kontrolü
    if (count($requests) >= $max_requests) {
        $blocked_until = $now + $cooldown_time;
        @file_put_contents($limit_file, json_encode([
            'requests' => $requests,
            'blocked_until' => $blocked_until
        ]));

        header("HTTP/1.1 429 Too Many Requests");
        header("Retry-After: $cooldown_time");
        render_blocked_page($cooldown_time);
        exit;
    }

    // Yeni isteği kaydet
    $requests[] = $now;
    @file_put_contents($limit_file, json_encode([
        'requests' => array_values($requests),
        'blocked_until' => 0
    ]));
}

function render_blocked_page($seconds) {
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Güvenlik Koruması - SAGUF'26</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                background-color: #3d0814;
                color: #ffffff;
                font-family: 'Montserrat', sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                text-align: center;
                box-sizing: border-box;
            }
            .container {
                max-width: 500px;
                padding: 45px 30px;
                background: rgba(255, 255, 255, 0.04);
                border: 1px solid rgba(185, 143, 66, 0.25);
                border-radius: 16px;
                box-shadow: 0 15px 50px rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(12px);
                margin: 20px;
            }
            .shield-icon {
                font-size: 3.5rem;
                color: #B98F42;
                margin-bottom: 25px;
                animation: pulse 2s infinite ease-in-out;
            }
            h1 {
                font-size: 1.6rem;
                margin-bottom: 15px;
                font-weight: 700;
                color: #ffffff;
                letter-spacing: 0.5px;
            }
            p {
                font-size: 0.95rem;
                line-height: 1.6;
                color: rgba(255,255,255,0.75);
                margin-bottom: 30px;
            }
            .countdown {
                font-size: 1.4rem;
                font-weight: 700;
                color: #B98F42;
                background: rgba(185, 143, 66, 0.08);
                padding: 12px 25px;
                border-radius: 8px;
                display: inline-block;
                border: 1px solid rgba(185, 143, 66, 0.3);
                letter-spacing: 1px;
            }
            @keyframes pulse {
                0% { transform: scale(1); opacity: 0.9; }
                50% { transform: scale(1.05); opacity: 1; }
                100% { transform: scale(1); opacity: 0.9; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="shield-icon">🛡️</div>
            <h1>Şüpheli İstek Engellendi</h1>
            <p>Sistemlerimiz bu IP adresinden çok hızlı ve yoğun istek yapıldığını algıladı. Spam ve DDoS saldırılarını önlemek amacıyla erişiminiz geçici olarak kısıtlandı.</p>
            <p>Lütfen bekleyin, süre bitiminde sayfa otomatik olarak açılacaktır:</p>
            <div class="countdown" id="timer"><?php echo $seconds; ?> saniye</div>
        </div>
        <script>
            let time = <?php echo $seconds; ?>;
            const timerEl = document.getElementById('timer');
            const interval = setInterval(() => {
                time--;
                if (time <= 0) {
                    clearInterval(interval);
                    window.location.reload();
                } else {
                    timerEl.textContent = time + ' saniye';
                }
            }, 1000);
        </script>
    </body>
    </html>
    <?php
}

rate_limit_check();
