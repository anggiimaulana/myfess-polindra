<?php 
$users = [];
$encryption_key = 'secretkey123'; // Gantilah dengan kunci enkripsi yang aman

// Fungsi dekripsi
function decryptMessage($encrypted_message, $key) {
    $cipher = "aes-128-gcm";
    $c = base64_decode($encrypted_message);
    $ivlen = openssl_cipher_iv_length($cipher);
    
    // Memastikan panjang IV benar
    if (strlen($c) < $ivlen + 16) {
        return "Pesan terenkripsi tidak valid";
    }
    
    $iv = substr($c, 0, $ivlen);
    $tag = substr($c, -16);
    $ciphertext = substr($c, $ivlen, strlen($c) - $ivlen - 16);
    
    return openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
}

// Kumpulkan semua data pengguna dan pesan terakhirnya
while($row = mysqli_fetch_assoc($sql)) {
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
            OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id}
            OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    
    if (mysqli_num_rows($query2) > 0) {
        $row2 = mysqli_fetch_assoc($query2);
        $decrypted_message = decryptMessage($row2['msg'], $encryption_key);
        (strlen($decrypted_message) > 28) ? $msg = substr($decrypted_message, 0, 28).'...' : $msg = $decrypted_message;
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Anda: " : $you = "";
        $msg_id = $row2['msg_id'];
    } else {
        $result = "Belum ada pesan";
        $msg = $result;
        $you = "";
        $msg_id = 0; // Jika tidak ada pesan, beri nilai msg_id yang lebih rendah dari yang ada
    }

    // Simpan data pengguna dan pesan terakhirnya dalam array
    $users[] = [
        'unique_id' => $row['unique_id'],
        'fname' => $row['fname'],
        'lname' => $row['lname'],
        'img' => $row['img'],
        'status' => $row['status'],
        'msg' => $msg,
        'you' => $you,
        'msg_id' => $msg_id
    ];
}

// Urutkan array berdasarkan msg_id
usort($users, function($a, $b) {
    return $b['msg_id'] <=> $a['msg_id']; // Urutkan secara descending
});

// Buat output HTML berdasarkan urutan yang telah diurutkan
$output = '';
foreach ($users as $user) {
    // check status online - offline user
    ($user['status'] == "Offline") ? $offline = "offline" : $offline = "";

    $output .= '<a href="chat.php?user_id='.$user['unique_id'].'">
                <div class="content">
                    <img src="images/'. $user['img'] .'" alt="User Image" loading="lazy">
                    <div class="details">
                        <span>'. $user['fname'] . " " . $user['lname'] .'</span>
                        <p>'. $user['you'] . $user['msg'] .'</p>
                    </div>
                </div>
                <div class="status-dot '. $offline .' "><i class="fas fa-circle"></i></div>
                </a>';
}
?>
