<?php
session_start();

// Eğer zaten giriş yapılmışsa doğrudan panele yönlendir
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    $expected_password = getenv('ADMIN_PASSWORD') ?: 'CHANGE_ME';
    if ($password === $expected_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Hatalı şifre! Lütfen tekrar deneyiniz.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAGUF'26 - Yönetim Paneli Giriş</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #85141C;
            --bg-dark: #4D090E;
            --accent-color: #B98F42;
            --white: #FFFFFF;
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
            background-color: var(--primary-color);
            background-image: radial-gradient(circle, var(--primary-color) 0%, var(--bg-dark) 100%);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            background-color: var(--primary-color);
            border: 2px solid var(--accent-color);
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px auto;
            border: 2px solid var(--accent-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--bg-dark);
            box-shadow: 0 0 10px rgba(185, 143, 66, 0.2);
        }

        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        h2 {
            font-family: var(--font-title);
            margin-bottom: 10px;
            font-size: 1.8rem;
            color: var(--white);
        }

        p.subtitle {
            font-size: 0.85rem;
            color: var(--accent-color);
            margin-bottom: 30px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
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
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--white);
            box-shadow: 0 0 8px rgba(255,255,255,0.2);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: var(--accent-color);
            color: var(--bg-dark);
            border: 2px solid var(--accent-color);
            border-radius: 8px;
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: transparent;
            color: var(--white);
            border-color: var(--white);
        }

        .error-message {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid #dc3545;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-logo">
        <!-- Logo Resmi -->
        <img src="../assets/images/logo.png" alt="SAGUF'26 Logo">
    </div>
    
    <h2>Yönetim Paneli</h2>
    <p class="subtitle">SAGUF'26 Giriş</p>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            ✗ <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="password">Yönetici Şifresi</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Şifrenizi giriniz" required autofocus>
        </div>
        <button type="submit" class="btn-primary">Giriş Yap</button>
    </form>
</div>

</body>
</html>
