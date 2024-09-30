<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../../config/config.php";

    // Cek apakah logout_id ada dalam query string
    if (isset($_GET['logout_id'])) {
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        $status = "Offline";

        // Update status users
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$logout_id}'");
        
        if ($sql) {
            session_unset();
            session_destroy();
            header("location: ../../login.php");
        } else {
            echo "Error: " . mysqli_error($conn); // Tambahkan penanganan kesalahan
        }
    } else {
        header("location: ../konsultasi.php");
    }
} else {
    header("location: ../../../login.php");
}