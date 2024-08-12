<?php
    session_start();
    if (isset($_SESSION['unique_id'])) { //user akan ke halaman login.php
        include_once "../../config/config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if (isset($logout_id)) {
            $status = "Offline";

            // update status users
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' where unique_id = {$logout_id}");
            if ($sql) {
                session_unset();
                session_destroy();
                header("location: ../../login.php");
            }
        } else {
            header("location: ../konsultasi.php");
        }
    } else {
        header("location: ../../../login.php");
    }
?>