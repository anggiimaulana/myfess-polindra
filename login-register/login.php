<?php
session_start();
include_once "../config/config.php";

$identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($identifier) && !empty($password)) {
    // Cek apakah input adalah NIM atau NIP
    if (is_numeric($identifier)) {
        // Cek di tabel mahasiswa
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE nim = '{$identifier}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            if (password_verify($password, $row['password'])) {
                // Update status pengguna
                $status = "Aktif";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$row['unique_id']}'");
                if ($sql2) {
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "mahasiswa_success";
                } else {
                    echo "Terjadi kesalahan saat memperbarui status pengguna.";
                }
            } else {
                echo "NIM atau password salah!";
            }
        } else {
            // Cek di tabel admin
            $sql3 = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '{$identifier}'");
            if (mysqli_num_rows($sql3) > 0) {
                $row = mysqli_fetch_assoc($sql3);
                if (password_verify($password, $row['password'])) {
                    // Update status pengguna
                    $status = "Online";
                    $sql4 = mysqli_query($conn, "UPDATE admin SET status = '{$status}' WHERE unique_id = '{$row['unique_id']}'");
                    if ($sql4) {
                        $_SESSION['unique_id'] = $row['unique_id'];
                        echo "admin_success";
                    } else {
                        echo "Terjadi kesalahan saat memperbarui status pengguna.";
                    }
                } else {
                    echo "NIP atau password salah!";
                }
            } else {
                echo "Pengguna dengan NIM atau NIP tersebut tidak ditemukan.";
            }
        }
    } else {
        echo "NIM atau NIP harus berupa angka.";
    }
} else {
    echo "Kolom input harus diisi!";
}
?>
