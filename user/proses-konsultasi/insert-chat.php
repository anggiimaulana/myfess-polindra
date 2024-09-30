<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit(); // Pastikan untuk menghentikan eksekusi jika user tidak terdaftar
}

include_once "../../config/config.php"; // Pastikan koneksi database sudah di-load

$outgoing_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

// Fungsi enkripsi
function encryptMessage($message, $key) {
    $cipher = "aes-128-gcm";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($message, $cipher, $key, $options=0, $iv, $tag);
    return base64_encode($iv . $ciphertext . $tag);
}

$encryption_key = 'wwax83rw2KN424PfnOjJDZZ881rRtue'; 
$encrypted_message = encryptMessage($message, $encryption_key);

if (!empty($encrypted_message)) {
    // Cek apakah outgoing_id dan incoming_id valid di tabel users
    $check_ids = "SELECT * FROM users WHERE unique_id IN ('$incoming_id', '$outgoing_id')";
    $result = mysqli_query($conn, $check_ids);
    
    if (mysqli_num_rows($result) == 2) { // Pastikan kedua ID ada
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) 
                                    VALUES ('$incoming_id', '$outgoing_id', '$encrypted_message')") 
                                    or die(mysqli_error($conn));
    } else {
        echo "Error: Salah satu ID tidak valid.";
    }
} else {
    echo "Error: Pesan tidak boleh kosong.";
}
