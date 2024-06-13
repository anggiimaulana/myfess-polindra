<?php
    session_start();
    include_once "config.php";
    $unique_post = $_SESSION['unique_post'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $output = "";
    // $sql = mysqli_query($conn, "SELECT * FROM users where not unique_id = {}")
    $sql = mysqli_query($conn, "SELECT * from post where not unique_post = {$unique_post} and (post_content like '%{$searchTerm}%')");
    if (mysqli_num_rows($sql) > 0) {
        include "dataPost.php";
    } else {
        $output .= "No user found related to your search";
    }
    echo $output;
?>