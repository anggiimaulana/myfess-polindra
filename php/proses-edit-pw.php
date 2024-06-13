<?php
session_start();
include_once "config.php";

if (isset($_POST['simpan'])) {
    $id = $_SESSION['unique_id'];
    $passwordOld = $_POST['passwordOld'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $error = ''; // Inisialisasi variabel untuk menyimpan pesan error

    // Periksa apakah password baru sama dengan password lama
    if ($newPassword === $passwordOld) {
        $error = "Password baru tidak boleh sama dengan password lama!";
    }

    // Periksa apakah password baru dan konfirmasi password baru sesuai
    if ($newPassword !== $confirmPassword) {
        $error = "Password baru dan konfirmasi password tidak sesuai!";
    }

    // Ambil password lama dari database
    $sql = "SELECT password FROM users WHERE unique_id = '$id'";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $hashedPassword = $row['password'];

        // Cocokkan password lama dengan yang diberikan
    if (!password_verify($passwordOld, $hashedPassword)) {
        $error = "Password lama tidak cocok!";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Password baru dan konfirmasi password tidak sesuai!";
    } else {
        // Hash newPassword
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password di database
        $updateSql = "UPDATE users SET password = '$newHashedPassword' WHERE unique_id = '$id'";
        $updateQuery = mysqli_query($conn, $updateSql);

        if ($updateQuery) {
            $_SESSION['update_status'] = 'success';
            header('Location: ../profile.php');
            exit();
        } else {
            $error = "Gagal mengupdate password, coba lagi!";
        }
    }

    } else {
        $error = "Gagal mengambil data pengguna!";
    }

    // alert JavaScript jika error
    if ($error !== '') {
        echo "<script>alert('$error'); window.location.href='../ganti-password.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Akses tidak sah!'); window.location.href='../ganti-password.php';</script>";
    exit();
}
?>
