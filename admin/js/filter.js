function toggleDropdown() {
    const dropdown = document.querySelector('.filter-dropdown');
    dropdown.classList.toggle('show');
}

function filterData() {
    const filterValue = document.getElementById('prodiFilter').value.toLowerCase();
    const tableRows = document.querySelectorAll('table tbody tr');

    tableRows.forEach(row => {
        const prodiCell = row.cells[2].innerText.toLowerCase(); // Mengambil nilai program studi dari kolom ketiga
        if (filterValue === "" || prodiCell.includes(filterValue)) {
            row.style.display = ""; // Tampilkan baris
        } else {
            row.style.display = "none"; // Sembunyikan baris
        }
    });
}