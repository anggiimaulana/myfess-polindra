<?php
session_start();
include_once "../../config/config.php";

if (isset($_POST['simpan'])) {
    $prodi = $_POST['pilihProdi'];
    $kelas = $_POST['pilihKelas'];
    $id = $_SESSION['unique_id'];

    // Mulai bagian untuk mengupdate foto
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    if (!empty($image)) {
        // Ambil nama file lama dari database
        $query = "SELECT img FROM users WHERE unique_id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $old_image = $row['img'];

        // Hapus foto lama
        if (file_exists("../../user/images/" . $old_image)) {
            unlink("../../user/images/" . $old_image);
        }

        // Generate nama baru untuk file gambar
        $new_image_name = rand(0, 10000000) . '_' . $image;

        // Simpan file gambar baru ke folder images
        move_uploaded_file($image_tmp, "../../user/images/" . $new_image_name);

        // Update data foto di database
        $sql = "UPDATE users SET img = '$new_image_name', prodi = '$prodi', kelas = '$kelas' WHERE unique_id = '$id'";
    } else {
        // Jika tidak mengganti foto, hanya update data prodi dan kelas
        $sql = "UPDATE users SET prodi = '$prodi', kelas = '$kelas' WHERE unique_id = '$id'";
    }

    $query = mysqli_query($conn, $sql);

    if ($query) {
        $_SESSION['update_status'] = 'success';
        header('Location: ../setting/profile.php');
        exit();
    } else {
        die("Gagal menyimpan, coba lagi!");
    }
} else {
    die("Gagal!");
}
?>
