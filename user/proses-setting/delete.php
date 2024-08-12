<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../../config/config.php";
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    if (!empty($delete_id)) {
        // Mulai transaksi
        mysqli_begin_transaction($conn);

        try {
            // Hapus user dari tabel users
            $stmt = $conn->prepare("DELETE FROM users WHERE unique_id = ?");
            $stmt->bind_param("s", $delete_id);
            $stmt->execute();

            // Hapus data dari tabel post
            $stmt2 = $conn->prepare("DELETE FROM post WHERE user_post = ?");
            $stmt2->bind_param("s", $delete_id);
            $stmt2->execute();

            // Hapus data dari tabel comment
            $stmt3 = $conn->prepare("DELETE FROM comment WHERE users_unique = ?");
            $stmt3->bind_param("s", $delete_id);
            $stmt3->execute();

            // Hapus data dari tabel messages
            $stmt4 = $conn->prepare("DELETE FROM messages WHERE outgoing_msg_id = ?");
            $stmt4->bind_param("s", $delete_id);
            $stmt4->execute();

            // Commit transaksi
            mysqli_commit($conn);

            // Hapus session dan redirect ke login.php
            session_unset();
            session_destroy();
            header("Location: ../../login.php");
            exit();

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            mysqli_rollback($conn);
            // Redirect ke halaman users jika gagal
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
