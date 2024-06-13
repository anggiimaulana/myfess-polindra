<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    
    $isi_komen = isset($_POST['isi_komen']) ? mysqli_real_escape_string($conn, $_POST['isi_komen']) : '';
    $user_id = $_SESSION['unique_id'];
    $post_id = isset($_POST['post_unique']) ? mysqli_real_escape_string($conn, $_POST['post_unique']) : '';

    if (!empty($isi_komen) && !empty($post_id)) {
        $unique_comment = rand(time(), 10000000);
        $sql = "INSERT INTO comment (unique_comment, user_id, post_id, msg) VALUES ('{$unique_comment}', '{$user_id}', '{$post_id}', '{$isi_komen}')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Komentar berhasil ditambahkan'); window.location.href='../komentar.php?post_unique={$post_id}';</script>";
        } else {
            echo "Gagal menambahkan komentar: " . mysqli_error($conn);
        }
    } else {
        echo "Isi komentar dan ID postingan tidak boleh kosong";
    }
} else {
    header("Location: ../login.php");
    exit(); // tambahkan exit untuk menghentikan eksekusi skrip setelah redirect
}
?>
