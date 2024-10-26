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

// Fungsi untuk mengirim pesan
function sendMessage() {
    const userInputElem = document.getElementById("userInput");
    const userInput = userInputElem.value.trim();

    // Check if input is empty
    if (!userInput) {
        alert("Pesan tidak boleh kosong!");
        return;
    }

    // Display user's message in chatbox
    const chatbox = document.getElementById("chatbox");
    chatbox.innerHTML += `<div class='user-message'><strong>Anda:</strong><br> ${userInput}</div>`;
    userInputElem.value = "";  // Clear input after sending

    // Auto-scroll chatbox to the latest message
    chatbox.scrollTop = chatbox.scrollHeight;

    // Display a "typing" message from the bot
    const botMessageDiv = document.createElement('div');
    botMessageDiv.className = 'bot-message';
    botMessageDiv.innerHTML = "<strong>MyfessAI:</strong> Mengetik...";
    chatbox.appendChild(botMessageDiv);
    chatbox.scrollTop = chatbox.scrollHeight;

    // Send user's message to the backend API
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
        // Display bot's reply
        botMessageDiv.innerHTML = `<strong>MyfessAI:</strong><br> ${data.reply}`;
        chatbox.scrollTop = chatbox.scrollHeight;
    })
    .catch(error => {
        console.error('Error:', error);
        botMessageDiv.innerHTML = "<strong>MyfessAI:</strong><br> Terjadi kesalahan saat menghubungi API.";
        chatbox.scrollTop = chatbox.scrollHeight;
    });
}

// Event listener for Enter key behavior in the textarea
document.addEventListener("DOMContentLoaded", function() {
    const userInputElem = document.getElementById("userInput");
    if (userInputElem) { // Check if element exists
        userInputElem.addEventListener("keydown", function(event) {
            if (event.key === 'Enter') {
                // If Enter is pressed without Shift, send the message
                if (!event.shiftKey) {
                    event.preventDefault();  // Prevent newline in textarea
                    sendMessage();
                }
            }
        });
    }
});
