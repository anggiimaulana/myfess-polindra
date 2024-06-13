<?php 
    while($row = mysqli_fetch_assoc($sql)) {
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id}
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        
        if (mysqli_num_rows($query2) > 0) {
            $row2 = mysqli_fetch_assoc($query2);
            $result = $row2['msg'];
            (strlen($result) > 28) ? $msg = substr($result, 0, 28).'...' : $msg = $result;
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Anda: " : $you = "";
        } else {
            $result = "Belum ada pesan";
            $msg = $result;
            $you = "";
        }

        // check status online - offline user
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

        $output .= '<a href="chat.php?user_id='.$row['unique_id'].'">
                    <div class="content">
                        <img src="php/images/'. $row['img'] .'" alt="User Image">
                        <div class="details">
                            <span>'. $row['fname'] . " " . $row['lname'] .'</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                    </div>
                    <div class="status-dot '. $offline .' "><i class="fas fa-circle"></i></div>
                    </a>';
    }
?>
