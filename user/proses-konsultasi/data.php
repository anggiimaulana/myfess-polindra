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
$sql = "SELECT * FROM users WHERE unique_id != '{$outgoing_id}'"; // Menghindari diri sendiri
$query = mysqli_query($conn, $sql); // Pastikan $conn adalah koneksi database yang valid

if (!$query) {
    die('Query Error: ' . mysqli_error($conn)); // Tangani kesalahan query
}

while($row = mysqli_fetch_assoc($query)) {
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = '{$row['unique_id']}' 
            OR outgoing_msg_id = '{$row['unique_id']}') AND (outgoing_msg_id = '{$outgoing_id}' 
            OR incoming_msg_id = '{$outgoing_id}') ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    
    if (!$query2) {
        die('Query Error: ' . mysqli_error($conn)); // Tangani kesalahan query
    }
    
    if (mysqli_num_rows($query2) > 0) {
        $row2 = mysqli_fetch_assoc($query2);
        $decrypted_message = decryptMessage($row2['msg'], $encryption_key);
        $msg = (strlen($decrypted_message) > 28) ? substr($decrypted_message, 0, 28) . '...' : $decrypted_message;
        $you = ($outgoing_id == $row2['outgoing_msg_id']) ? "Anda: " : "";
        $msg_id = $row2['msg_id'];
    } else {
        $msg = "Belum ada pesan";
        $you = "";
        $msg_id = 0; // Jika tidak ada pesan, beri nilai msg_id yang lebih rendah dari yang ada
    }

    // Simpan data pengguna dan pesan terakhirnya dalam array, jika belum ada
    $user_key = $row['unique_id']; // Ambil unique_id pengguna
    if (!array_key_exists($user_key, $users)) { // Cek apakah pengguna sudah ada
        $users[$user_key] = [
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
}

// Ambil pengguna terakhir yang memiliki pesan
if (!empty($users)) {
    // Ambil pengguna dengan pesan terakhir
    usort($users, function($a, $b) {
        return $b['msg_id'] <=> $a['msg_id']; // Urutkan secara descending
    });
    $last_user = reset($users); // Ambil pengguna pertama setelah diurutkan

    // Check status online - offline user
    $offline = ($last_user['status'] == "Offline") ? "offline" : "";

    // Buat output HTML untuk pengguna terakhir
    $output = '<a href="chat.php?user_id='.$last_user['unique_id'].'">
                <div class="content">
                    <img src="images/'. $last_user['img'] .'" alt="User Image" loading="lazy">
                    <div class="details">
                        <span>'. htmlspecialchars($last_user['fname']) . " " . htmlspecialchars($last_user['lname']) .'</span>
                        <p>'. $last_user['you'] . htmlspecialchars($last_user['msg']) .'</p>
                    </div>
                </div>
                <div class="status-dot '. $offline .' "><i class="fas fa-circle"></i></div>
                </a>';
    
    echo $output; // Output hasil
} else {
    echo "Tidak ada pengguna untuk ditampilkan.";
}