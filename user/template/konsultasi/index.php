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
    <div class="onlineKonsultasi" id="psi" onclick="toggleBotStatus(false)">
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

<!-- Section untuk memuat konten chatbot.php -->
<div id="chatbotContainer"></div>