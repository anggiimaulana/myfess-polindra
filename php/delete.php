<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    if (!empty($delete_id)) {
        // Delete user from the database
        $sql = mysqli_query($conn, "DELETE FROM users WHERE unique_id = '$delete_id'");
        if ($sql) {
            // Hapus session dan redirect ke login.php
            session_unset();
            session_destroy();
            header("Location: ../login.php");
            exit();
        } else {
            // Jika gagal, redirect ke halaman users
            header("Location: ../users.php");
            exit();
        }
    } else {
        // Jika delete_id kosong, redirect ke halaman users
        header("Location: ../users.php");
        exit();
    }
} else {
    // Jika tidak ada session, redirect ke login.php
    header("Location: ../login.php");
    exit();
}
?>
