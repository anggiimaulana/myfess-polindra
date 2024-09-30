<?php 
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../../config/config.php";
    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    // Fungsi dekripsi
    function decryptMessage($encrypted_message, $key) {
        $cipher = "aes-128-gcm";
        $c = base64_decode($encrypted_message);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($c, 0, $ivlen);
        $tag = substr($c, -16);
        $ciphertext = substr($c, $ivlen, strlen($c) - $ivlen - 16);
        return openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
    }

    $decryption_key = 'secretkey123'; // Gantilah dengan kunci enkripsi yang aman

    $sql = "SELECT * from messages 
            LEFT JOIN users on users.unique_id = messages.incoming_msg_id
            where (outgoing_msg_id = '{$outgoing_id}' AND incoming_msg_id = '{$incoming_id}')
            OR (outgoing_msg_id = '{$incoming_id}' AND incoming_msg_id = '{$outgoing_id}') 
            ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)) {
            $decrypted_message = decryptMessage($row['msg'], $decryption_key);
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. htmlspecialchars($decrypted_message) .'</p>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">              
                                <div class="details">
                                    <p>'. htmlspecialchars($decrypted_message) .'</p>
                                </div>
                            </div>';
            }
        }
        echo $output;
    }
} else {
    header("Location: ../../login.php");
}