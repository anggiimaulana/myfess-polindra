<?php
session_start();
include_once "../config/config.php";

// Escape all input
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$nip = mysqli_real_escape_string($conn, $_POST['nip']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Ensure all input is not empty
if (empty($nama) || empty($nip) || empty($email) || empty($password)) {
    echo "Semua input harus diisi!";
    exit();
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email tidak valid.";
    exit();
}

// Check if NIP already exists
$sql = mysqli_query($conn, "SELECT nip FROM admin WHERE nip = '{$nip}'");
if (mysqli_num_rows($sql) > 0) {
    echo "NIP $nip sudah digunakan.";
    exit();
}

// Check if email already exists
$sql = mysqli_query($conn, "SELECT email FROM admin WHERE email = '{$email}'");
if (mysqli_num_rows($sql) > 0) {
    echo "Email $email sudah digunakan.";
    exit();
}

// Hash the password before storing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Upload profile picture if exists
$new_img_name = "";
if (isset($_FILES['image'])) {
    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $allowed_extensions = ['png', 'jpeg', 'jpg'];

    if (!in_array($img_ext, $allowed_extensions)) {
        echo "Silakan pilih file gambar - jpeg, jpg, png";
        exit();
    }

    $time = time();
    $new_img_name = $time . "_" . $img_name;

    // Ensure the image directory exists
    $img_dir = "../admin/img/";
    if (!is_dir($img_dir)) {
        mkdir($img_dir, 0755, true);
    }

    if (!move_uploaded_file($tmp_name, $img_dir . $new_img_name)) {
        echo "Gagal mengunggah gambar.";
        exit();
    }
}

// Insert admin data into the database
$status = "Online";
$unique_id = rand(time(), 10000000);

$sql2 = mysqli_query($conn, "INSERT INTO admin (unique_id, nama, nip, email, password, img, status)
                            VALUES ('{$unique_id}', '{$nama}', '{$nip}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}')");

if ($sql2) {
    // Retrieve inserted admin data
    $sql3 = mysqli_query($conn, "SELECT * FROM admin WHERE nip = '{$nip}'");
    if (mysqli_num_rows($sql3) > 0) {
        $row = mysqli_fetch_assoc($sql3);
        $_SESSION['unique_id'] = $row['unique_id'];
        echo "success";
        exit();
    } else {
        echo "Admin tidak ditemukan setelah penyisipan.";
    }
} else {
    echo "Terjadi kesalahan. Silakan coba lagi.";
}
?>
