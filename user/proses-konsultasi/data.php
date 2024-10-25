<?php 
$users = [];
$encryption_key = 'wwax83rw2KN424PfnOjJDZZ881rRtue';

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
$sql = "SELECT u.*, m.msg, m.outgoing_msg_id, m.incoming_msg_id, m.msg_id FROM users u 
        LEFT JOIN (SELECT * FROM messages 
                    WHERE (outgoing_msg_id = '{$outgoing_id}' OR incoming_msg_id = '{$outgoing_id}')
                    ORDER BY msg_id DESC) m 
        ON u.unique_id = m.outgoing_msg_id OR u.unique_id = m.incoming_msg_id
        WHERE u.unique_id != '{$outgoing_id}'
        GROUP BY u.unique_id"; // Grouping berdasarkan pengguna

$query = mysqli_query($conn, $sql);

if (!$query) {
    die('Query Error: ' . mysqli_error($conn)); 
}

while($row = mysqli_fetch_assoc($query)) {
    if ($row['msg']) {
        $decrypted_message = decryptMessage($row['msg'], $encryption_key);
        $msg = (strlen($decrypted_message) > 28) ? substr($decrypted_message, 0, 28) . '...' : $decrypted_message;
        $you = ($outgoing_id == $row['outgoing_msg_id']) ? "Anda: " : "";
        $msg_id = $row['msg_id'];
    } else {
        $msg = "Belum ada pesan";
        $you = "";
        $msg_id = 0;
    }

    // Simpan data pengguna dan pesan terakhirnya
    $users[$row['unique_id']] = [
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

// Ambil pengguna terakhir yang memiliki pesan
if (!empty($users)) {
    // Urutkan pengguna berdasarkan pesan terakhir
    usort($users, function($a, $b) {
        return $b['msg_id'] <=> $a['msg_id']; 
    });

    // Lakukan perulangan pada setiap pengguna yang telah diurutkan
    foreach ($users as $user) {
        // Check status online - offline user
        $offline = ($user['status'] == "Offline") ? "offline" : "";

        // Buat output HTML untuk setiap pengguna
        $output .= '<a href="chat.php?user_id='.$user['unique_id'].'">
                    <div class="content">
                        <img src="images/'. $user['img'] .'" alt="User Image" loading="lazy">
                        <div class="details">
                            <span>'. htmlspecialchars($user['fname']) . " " . htmlspecialchars($user['lname']) .'</span>
                            <p>'. $user['you'] . htmlspecialchars($user['msg']) .'</p>
                        </div>
                    </div>
                    <div class="status-dot '. $offline .' "><i class="fas fa-circle"></i></div>
                    </a>';
    }

    echo $output; 
} else {
    echo "Tidak ada pengguna untuk ditampilkan.";
}
