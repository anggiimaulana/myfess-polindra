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

<section class="online show" id="onlineSection"> <!-- Default show -->
    <div class="onlineKonsultasi active" id="psi">
        <p>Psikolog</p>
    </div>
    <span class="separator">|</span>
    <div class="onlineKonsultasi" id="bot">
        <p>Chatbot</p>
    </div>
    <span class="separator">|</span>
    <div class="onlineKonsultasi" id="friend">
        <p>Teman</p>
    </div>
</section>

<hr>

<script>
// Ambil elemen yang diperlukan
const onlineBtn = document.getElementById('onlineBtn');
const offlineBtn = document.getElementById('offlineBtn');
const onlineSection = document.getElementById('onlineSection');
const psi = document.getElementById('psi');  // Element untuk Psikolog
const bot = document.getElementById('bot');  // Element untuk Chatbot
const friend = document.getElementById('friend'); // Element untuk Teman

// Function untuk reset semua active di onlineKonsultasi
function resetActiveKonsultasi() {
    psi.classList.remove('active');
    bot.classList.remove('active');
    friend.classList.remove('active');
}

// Event Listener untuk Online (menampilkan online, dan beri active class)
onlineBtn.addEventListener('click', function() {
    onlineSection.classList.add('show');  
    onlineBtn.classList.add('active'); 
    offlineBtn.classList.remove('active');  
    resetActiveKonsultasi(); 
    psi.classList.add('active');  
});

// Event Listener untuk Offline (menyembunyikan online, hilangkan active class)
offlineBtn.addEventListener('click', function() {
    onlineSection.classList.remove('show'); 
    offlineBtn.classList.add('active');  
    onlineBtn.classList.remove('active');  
    resetActiveKonsultasi();  
});

// Event Listener untuk Psikolog, Chatbot, dan Teman
psi.addEventListener('click', function() {
    resetActiveKonsultasi();  
    psi.classList.add('active');  
});

bot.addEventListener('click', function() {
    resetActiveKonsultasi(); 
    bot.classList.add('active');  
});

friend.addEventListener('click', function() {
    resetActiveKonsultasi();  
    friend.classList.add('active');  
});

</script>