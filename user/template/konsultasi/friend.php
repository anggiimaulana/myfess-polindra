<?php require "../../../config/config.php"; ?>

<div class="search">
    <span class="text">Cari dan pilih user</span>
    <input type="text" placeholder="Cari nama user">
    <button><i class="fas fa-search"></i></button>
</div>
<hr style="margin-bottom: 15px;">
<div class="users-list">
    <!-- Data user akan dimuat di sini dari users.php -->
</div>

<script>
    // Ambil elemen DOM untuk search bar, search button, dan users list
    const searchBar = document.querySelector(".search input"),
          searchBtn = document.querySelector(".search button"),
          usersList = document.querySelector(".users-list");

    // Fungsi untuk mendapatkan data pengguna secara berkala menggunakan AJAX (XMLHttpRequest)
    setInterval(() => {
        let xhr = new XMLHttpRequest(); // Membuat objek XML
        xhr.open("GET", "proses-konsultasi/users.php", true); // Permintaan GET ke users.php
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) { // Cek apakah permintaan selesai
                if (xhr.status === 200) { // Jika status respons 200 (OK)
                    let data = xhr.response; // Ambil data dari respons
                    if (!searchBar.classList.contains("active")) { // Jika searchBar tidak aktif
                        usersList.innerHTML = data; // Masukkan data ke dalam users-list
                    }
                } else {
                    console.error("Error fetching users: " + xhr.statusText); // Menangani kesalahan
                }
            }
        };
        xhr.onerror = function() {
            console.log("Request failed");
        };
        xhr.send(); // Kirim permintaan
    }, 300); // Lakukan setiap 300ms

    // Ketika tombol search diklik, aktifkan input search
    searchBtn.onclick = () => {
        searchBar.classList.toggle("active"); // Toggle kelas active pada searchBar
        searchBar.focus(); // Fokus ke input search
        searchBtn.classList.toggle("active"); // Toggle kelas active pada tombol search
        searchBar.value = ""; // Reset nilai input
    };

    // Fungsi untuk mencari user saat mengetik di searchBar
    searchBar.onkeyup = () => {
        let searchTerm = searchBar.value; // Ambil nilai input
        if (searchTerm != "") {
            searchBar.classList.add("active"); // Jika input tidak kosong, tambahkan kelas active
        } else {
            searchBar.classList.remove("active"); // Jika kosong, hapus kelas active
        }

        // AJAX untuk pencarian user
        let xhr = new XMLHttpRequest(); // Membuat objek XML
        xhr.open("POST", "proses-konsultasi/search.php", true); // Permintaan POST ke search.php
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) { // Cek apakah permintaan selesai
                if (xhr.status === 200) { // Jika status respons 200 (OK)
                    let data = xhr.response; // Ambil data dari respons
                    usersList.innerHTML = data; // Tampilkan hasil pencarian
                } else {
                    console.error("Error searching users: " + xhr.statusText); // Menangani kesalahan
                }
            }
        };
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Set header
        xhr.send("searchTerm=" + encodeURIComponent(searchTerm)); // Kirim permintaan dengan parameter searchTerm
    };
</script>
