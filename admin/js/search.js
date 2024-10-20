

// Tangani pencarian saat mengetik
document.getElementById("searchInput").addEventListener("keyup", function() {
    var searchTerm = this.value;
    fetchResults(searchTerm);
});

function fetchResults(searchTerm) {
    // Menggunakan Fetch API untuk mengambil data pencarian
    fetch("controller/search_mahasiswa.php?search=" + encodeURIComponent(searchTerm))
        .then(response => response.json())
        .then(data => {
            // Menampilkan data ke dalam tabel
            var tbody = document.querySelector("table tbody");
            tbody.innerHTML = ""; // Menghapus data sebelumnya

            data.forEach(function(mhs) {
                var row = tbody.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                
                cell1.textContent = mhs.fullName; // Nama lengkap
                cell2.textContent = mhs.nim;       // NIM
                cell3.textContent = mhs.prodi;     // Program Studi
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}