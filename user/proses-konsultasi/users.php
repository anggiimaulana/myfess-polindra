<?php 
session_start();
include_once "../../config/config.php";

// Cek apakah unique_id ada dalam session
if (!isset($_SESSION['unique_id'])) {
    echo "Anda tidak terautentikasi.";
    exit();
}

$outgoing_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);
$sql = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = '{$outgoing_id}'");
$output = "";

// Cek hasil query
if (mysqli_num_rows($sql) == 0) {
    $output .= "Tidak ada pesan yang tersedia!";
} else {
    include "data.php";
}

echo $output;