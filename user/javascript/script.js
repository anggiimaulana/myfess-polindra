// Mengambil elemen yang diperlukan
const searchBar = document.querySelector(".users .search input"),
      searchBtn = document.querySelector(".users .search button"),
      usersList = document.querySelector(".users .users-list"),
      usersSection = document.getElementById("usersSection"), // Bagian users
      chatbotContainer = document.getElementById("chatbotContainer"),
      onlineBtn = document.getElementById('onlineBtn'),
      offlineBtn = document.getElementById('offlineBtn'),
      onlineSection = document.getElementById('onlineSection'),
      psi = document.getElementById('psi'),
      bot = document.getElementById('bot'),
      friend = document.getElementById('friend');

// Fungsi Toggle pada Search
searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
};

// Fungsi pencarian pengguna
searchBar.onkeyup = () => {
    let searchTerm = searchBar.value.trim();
    if (searchTerm) {
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }

    // Mengirim permintaan AJAX untuk pencarian
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "proses-konsultasi/search.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            usersList.innerHTML = xhr.response;
        }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + encodeURIComponent(searchTerm));
};

// Interval untuk Memuat Daftar Pengguna
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "proses-konsultasi/users.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            if (!searchBar.classList.contains("active")) {
                usersList.innerHTML = xhr.response;
            }
        }
    };
    xhr.send();
}, 300);

// Fungsi untuk Menyembunyikan atau Menampilkan Users Section
function toggleUsersVisibility(show) {
    usersSection.style.display = show ? "block" : "none";
}

// Reset Status Aktif pada Pilihan Konsultasi
function resetActiveKonsultasi() {
    [psi, bot, friend].forEach(el => el.classList.remove('active'));
}

// Event Listener untuk Mode Online
onlineBtn.addEventListener('click', () => {
    onlineSection.classList.add('show');
    onlineBtn.classList.add('active');
    offlineBtn.classList.remove('active');
    resetActiveKonsultasi();
    friend.classList.add('active'); // Teman sebagai pilihan default
    chatbotContainer.innerHTML = ""; // Reset konten
    toggleUsersVisibility(true); // Tampilkan usersSection
});

// Event Listener untuk Mode Offline
offlineBtn.addEventListener('click', () => {
    onlineSection.classList.remove('show');
    offlineBtn.classList.add('active');
    onlineBtn.classList.remove('active');
    resetActiveKonsultasi();
    chatbotContainer.innerHTML = ""; // Reset konten
    toggleUsersVisibility(true); // Tampilkan usersSection
});

// Event Listener untuk Pilihan Psikolog
psi.addEventListener('click', () => {
    resetActiveKonsultasi();
    psi.classList.add('active');
    chatbotContainer.innerHTML = ""; // Reset konten
    toggleUsersVisibility(true); // Tampilkan usersSection
});

// Event Listener untuk Pilihan Chatbot (Bot)
bot.addEventListener('click', () => {
    resetActiveKonsultasi();
    bot.classList.add('active');

    // Sembunyikan usersSection saat bot aktif
    toggleUsersVisibility(false);

    // Load konten chatbot dari chatbot.php menggunakan AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "template/konsultasi/chatbot.php", true);
    xhr.onload = () => {
        chatbotContainer.innerHTML = xhr.status === 200 ? xhr.responseText : `Gagal memuat chatbot. Status code: ${xhr.status}`;
    };
    xhr.onerror = () => {
        chatbotContainer.innerHTML = "Terjadi kesalahan jaringan atau file tidak ditemukan.";
    };
    xhr.send();
});

// Event Listener untuk Pilihan Teman
friend.addEventListener('click', () => {
    resetActiveKonsultasi();
    friend.classList.add('active');
    chatbotContainer.innerHTML = ""; // Reset konten
    toggleUsersVisibility(true); // Tampilkan usersSection
});


    function sendMessage() {
        const userInput = document.getElementById("userInput").value.trim();
        if (!userInput) {
            alert("Pesan tidak boleh kosong!");
            return;
        }

        const chatbox = document.getElementById("chatbox");
        chatbox.innerHTML += `<div class='user-message'><strong>User:</strong> ${userInput}</div>`;
        document.getElementById("userInput").value = "";

        chatbox.scrollTop = chatbox.scrollHeight;

        const botMessageDiv = document.createElement('div');
        botMessageDiv.className = 'bot-message';
        botMessageDiv.innerHTML = "<strong>Chatbot:</strong> Mengetik...";
        chatbox.appendChild(botMessageDiv);
        chatbox.scrollTop = chatbox.scrollHeight;

        fetch('template/konsultasi/proses/response.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: userInput })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            botMessageDiv.innerHTML = `<strong>Chatbot:</strong> ${data.reply}`;
            chatbox.scrollTop = chatbox.scrollHeight;
        })
        .catch(error => {
            console.error('Error:', error);
            botMessageDiv.innerHTML = "<strong>Chatbot:</strong> Terjadi kesalahan saat menghubungi API.";
            chatbox.scrollTop = chatbox.scrollHeight;
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
    const userInput = document.getElementById("userInput");
    if (userInput) { // Periksa apakah elemen ada
        userInput.addEventListener("keyup", function(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });
    }
});