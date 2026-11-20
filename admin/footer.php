<?php
require_once __DIR__ . '/config.php';
?>
    <!-- Sayfa Altı (Footer) Başlangıcı -->
    <footer class="page-footer">
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> <?php echo $event_title; ?>. Tüm Hakları Saklıdır.</p>
            <p><?php echo $event_subtitle; ?></p>
        </div>
    </footer>
    <!-- Sayfa Altı (Footer) Bitişi -->

    <!-- Gömülü JavaScript Kodları -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Mobil Hamburger Menü Kontrolü
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            
            if (hamburger && navLinks) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                    navLinks.classList.toggle('active');
                });

                // Linke tıklanıldığında menüyü kapat
                document.querySelectorAll('.nav-links a').forEach(link => {
                    link.addEventListener('click', () => {
                        hamburger.classList.remove('active');
                        navLinks.classList.remove('active');
                    });
                });
            }

            // 2. Dinamik Geri Sayım Sayacı (Countdown)
            const countdownElement = document.getElementById('countdown-timer');
            if (countdownElement) {
                const targetDateStr = countdownElement.getAttribute('data-target');
                const targetDate = new Date(targetDateStr).getTime();

                const daysVal = document.getElementById('days');
                const hoursVal = document.getElementById('hours');
                const minutesVal = document.getElementById('minutes');
                const secondsVal = document.getElementById('seconds');

                function updateCountdown() {
                    const now = new Date().getTime();
                    const difference = targetDate - now;

                    if (difference < 0) {
                        if (daysVal) daysVal.innerText = '00';
                        if (hoursVal) hoursVal.innerText = '00';
                        if (minutesVal) minutesVal.innerText = '00';
                        if (secondsVal) secondsVal.innerText = '00';
                        clearInterval(countdownInterval);
                        return;
                    }

                    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                    const formatTime = (time) => time < 10 ? `0${time}` : time;

                    if (daysVal) daysVal.innerText = formatTime(days);
                    if (hoursVal) hoursVal.innerText = formatTime(hours);
                    if (minutesVal) minutesVal.innerText = formatTime(minutes);
                    if (secondsVal) secondsVal.innerText = formatTime(seconds);
                }

                updateCountdown();
                const countdownInterval = setInterval(updateCountdown, 1000);
            }
        });
    </script>
</body>
</html>
