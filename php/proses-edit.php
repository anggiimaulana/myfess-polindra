<?php
session_start();
include_once "config.php";

if (isset($_POST['simpan'])) {
    $prodi = $_POST['pilihProdi'];
    $kelas = $_POST['pilihKelas'];
    $id = $_SESSION['unique_id'];


    $sql = "UPDATE users SET prodi = '$prodi', kelas = '$kelas' where unique_id = '$id' ";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $_SESSION['update_status'] = 'success';
        header('Location: ../profile.php');
        exit();
    } else {
        die ("Gagal menyimpan, coba lagi!");
    }
} else {
    die ("Gagal!");
}
?>