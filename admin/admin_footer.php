        </main>
    </div>
</div>

<!-- Footer -->
<footer style="padding: 20px 5%; border-top: 1px solid var(--border-color); background-color: white; text-align: center; font-size: 13px; color: #6c757d; margin-top: auto; width: 100%;">
    <p>&copy; <?php echo date("Y"); ?> SAGUF'26 Yönetim Paneli. Tüm hakları saklıdır.</p>
</footer>

<!-- Mobil Menü Toggle Scripti -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuToggleBtn = document.getElementById('menuToggleBtn');
        const adminSidebar = document.getElementById('adminSidebar');

        if (menuToggleBtn && adminSidebar) {
            // Menüyü Aç/Kapat
            menuToggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                adminSidebar.classList.toggle('open');
            });

            // Ekranın boş bir yerine tıklanırsa menüyü kapat
            document.addEventListener('click', (e) => {
                if (!adminSidebar.contains(e.target) && e.target !== menuToggleBtn) {
                    adminSidebar.classList.remove('open');
                }
            });
        }
    });
</script>
</body>
</html>
