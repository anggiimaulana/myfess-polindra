<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once "../../config/config.php";

    // Sanitize input
    $unique_post = mysqli_real_escape_string($conn, $_POST['post_unique']);

    // Prepare the query with parameterized values
    $stmt = $conn->prepare("SELECT comment.*, users.img, users.fname, users.lname, post.unique_post
                            FROM comment 
                            LEFT JOIN users ON users.unique_id = comment.users_unique 
                            LEFT JOIN post ON post.unique_post = comment.post_unique
                            WHERE comment.post_unique = ?
                            ORDER BY comment.comment_id");
    $stmt->bind_param("s", $unique_post);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize output variable
    $output = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Sanitize output to prevent XSS
            $commentText = htmlspecialchars($row['isi_komen']);
            $fname = htmlspecialchars($row['fname']);
            $lname = htmlspecialchars($row['lname']);
            $userPhoto = htmlspecialchars($row['img']);

            $output .= '<div class="komen incoming">
                            <div class="anonim-komen">
                                <img src="../user/images/' . $userPhoto . '" alt="" loading="lazy">
                                <h4>' . $fname . ' ' . $lname . '</h4>
                            </div>
                            <div class="details">
                                <p>'. $commentText .'</p>
                            </div>
                        </div>';
        }
        echo $output;
    } else {
        echo "Tidak ada komentar untuk postingan ini.";
    }
} else {
    header("Location: ../../myfess/login.php");
}
?>
