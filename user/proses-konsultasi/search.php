<?php
session_start();
include_once "../../config/config.php";

$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$output = "";

// Menggunakan prepared statement untuk pencarian
$sql = $conn->prepare("SELECT * FROM users WHERE unique_id != ? AND (fname LIKE ? OR lname LIKE ?)");
if ($sql === false) {
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}

$likeSearchTerm = "%{$searchTerm}%"; // Menyiapkan nilai pencarian
$sql->bind_param("iss", $outgoing_id, $likeSearchTerm, $likeSearchTerm);
$sql->execute();
$result = $sql->get_result(); // Mendapatkan hasil

if ($result) { // Memastikan $result valid
    if ($result->num_rows > 0) {
        include "data.php"; // Pastikan data.php menggunakan $result dengan benar
    } else {
        $output .= "Nama user tidak tersedia"; // Umpan balik jika tidak ada hasil
        echo $output; // Mengirimkan output jika tidak ada hasil
    }
} else {
    // Jika eksekusi query gagal
    die("Error executing query: " . htmlspecialchars($sql->error));
}

$sql->close(); // Menutup prepared statement