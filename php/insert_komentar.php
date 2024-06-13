<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $isi_komen = mysqli_real_escape_string($conn, $_POST['isi_komen']);
    $id_user_komen = mysqli_real_escape_string($conn, $_POST['id_user_komen']);
    $unique_post = mysqli_real_escape_string($conn, $_POST['post_unique']); // Mengambil nilai unique_post dari formulir


    if(!empty($isi_komen)) {
        $unique_comment = rand(time(), 10000000);
        $sql = mysqli_query($conn, "INSERT INTO comment (unique_comment, post_unique, users_unique, isi_komen)
                VALUES ('{$unique_comment}', '{$unique_post}', '{$id_user_komen}', '{$isi_komen}')") or die(mysqli_error($conn));

    }
} else {
    header("Location: ../login.php");
}
?>
