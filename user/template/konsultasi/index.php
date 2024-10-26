<h4 style="text-align:center; margin-top:5px;">Konsultasi</h4>

<section class="pilihanKonsultasi">
    <div class="konsultasi active" id="onlineBtn">
        <p>Online</p>
    </div>
    <span class="separator">|</span>
    <div class="konsultasi" id="offlineBtn">
        <p>Offline</p>
    </div>
</section>

<hr>

<section class="online show" id="onlineSection">
    <div class="onlineKonsultasi" id="psi" onclick="toggleBotStatus(false, true)">
        <p>Psikolog</p>
    </div>
    <span class="separator">|</span>
    <div class="onlineKonsultasi" id="bot" onclick="toggleBotStatus(true)">
        <p>MyfessAI</p>
    </div>
    <span class="separator">|</span>
    <div class="onlineKonsultasi active" id="friend" onclick="toggleBotStatus(false)">
        <p>Teman</p>
    </div>
</section>

<hr>

<!-- Section untuk memuat konten chatbot.php atau psi.php -->
<div id="chatbotContainer"></div>

<script>
    function toggleBotStatus(isBotActive, isPsiActive = false) {
        resetActiveKonsultasi(); // Reset status aktif pada pilihan konsultasi

        if (isBotActive) {
            bot.classList.add('active');
            toggleUsersVisibility(false); // Menyembunyikan usersSection
            
            // Muat konten bot dari chatbot.php
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "template/konsultasi/chatbot.php", true);
            xhr.onload = () => {
                chatbotContainer.innerHTML = xhr.status === 200 ? xhr.responseText : `Gagal memuat chatbot. Status code: ${xhr.status}`;
            };
            xhr.onerror = () => {
                chatbotContainer.innerHTML = "Terjadi kesalahan jaringan atau file tidak ditemukan.";
            };
            xhr.send();
        } else if (isPsiActive) { // Muat konten psikolog dari psi.php jika aktif
            psi.classList.add('active');
            toggleUsersVisibility(false); // Menyembunyikan usersSection jika tidak diperlukan

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "template/konsultasi/psi.php", true);
            xhr.onload = () => {
                chatbotContainer.innerHTML = xhr.status === 200 ? xhr.responseText : `Gagal memuat psikolog. Status code: ${xhr.status}`;
            };
            xhr.onerror = () => {
                chatbotContainer.innerHTML = "Terjadi kesalahan jaringan atau file tidak ditemukan.";
            };
            xhr.send();
        } else {
            // Opsi lain seperti "Teman" tanpa muatan konten khusus
            friend.classList.add('active');
            toggleUsersVisibility(true);
            chatbotContainer.innerHTML = ""; // Reset konten
        }
    }
</script>