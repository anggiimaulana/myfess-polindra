<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../../config/config.php";
    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Fungsi enkripsi
    function encryptMessage($message, $key) {
        $cipher = "aes-128-gcm";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($message, $cipher, $key, $options=0, $iv, $tag);
        return base64_encode($iv.$ciphertext.$tag);
    }

    $encryption_key = 'secretkey123'; // Gantilah dengan kunci enkripsi yang aman
    $encrypted_message = encryptMessage($message, $encryption_key);

    if(!empty($encrypted_message)) {
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                            VALUES ('{$incoming_id}', '{$outgoing_id}', '{$encrypted_message}')") or die(mysqli_error($conn));
    }
} else {
    header("Location: ../login.php");
}
