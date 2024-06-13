<?php
    session_start();
    include_once "config.php";

    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if (!empty($nim) && !empty($password)) {
        // Ambil data pengguna dari database berdasarkan NIM
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE nim = '{$nim}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            // Periksa apakah password yang dimasukkan sesuai dengan hash yang tersimpan di database
            if (password_verify($password, $row['password'])) {
                // Jika password benar, tandai pengguna sebagai aktif
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$row['unique_id']}'");
                if ($sql2) {
                    // Set session unique_id untuk pengguna yang berhasil login
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                } else {
                    echo "Terjadi kesalahan saat memperbarui status pengguna.";
                }
            } else {
                echo "NIM atau password salah!";
            }
        } else {
            echo "Pengguna dengan NIM tersebut tidak ditemukan.";
        }
    } else {
        echo "Kolom input harus diisi!";
    }
?>
