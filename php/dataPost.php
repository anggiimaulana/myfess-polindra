<?php 
    while($row = mysqli_fetch_assoc($sql)) {
        $sql2 = "SELECT * FROM post WHERE (unique_post = {$row['unique_id']}) ORDER BY post_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        
        if (mysqli_num_rows($query2) > 0) {
            $row2 = mysqli_fetch_assoc($query2);
            $result = $row2['post_content'];
            (strlen($result) > 2000) ? $cpost = substr($result, 0, 2000).'...' : $cpost = $result;
            // ($unique_post == $row2['unique_post']) ? $you = "Anda: " : $you = "";
        } else {
            $result = "Belum ada postingan";
            $cpost = $result;
            // $you = "";
        }

        // check status online - offline user
        // ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

        $output .= '<div>
                        <img src="anonim.png" alt="User Image">
                        <span>Anonim</span> 
                        <a href="komentar.php" class="balas-cerita">
                            <div class="icon-balas"><i class="fas fa-arrow-right"></i></div>
                            <p>Balas</p>
                        </a>
                    </div>
                    <div class="cerita-content">
                        <p>'. $cpost .'</p>
                    </div>';
    }
?>
