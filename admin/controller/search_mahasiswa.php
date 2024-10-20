<?php 
require "../../config/config.php";

$searchTerm = $_GET['search'] ?? '';

// Mencari mahasiswa berdasarkan input
$sql = "SELECT * FROM users WHERE CONCAT(fname, ' ', lname) LIKE ? ORDER BY user_id DESC";
$stmt = $conn->prepare($sql);
$searchWildcard = "%" . $searchTerm . "%";
$stmt->bind_param("s", $searchWildcard);
$stmt->execute();
$result = $stmt->get_result();

$dataMahasiswa = [];
while ($row = $result->fetch_assoc()) {
    $dataMahasiswa[] = [
        'fullName' => $row['fname'] . ' ' . $row['lname'],
        'nim' => $row['nim'],
        'prodi' => $row['prodi']
    ];
}

// Mengembalikan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($dataMahasiswa);