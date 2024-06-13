<?php
session_start();
include_once "config.php";

// Escape semua input
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$nim = mysqli_real_escape_string($conn, $_POST['nim']);
$prodi = mysqli_real_escape_string($conn, $_POST['pilihanProdi']);
$kelas = mysqli_real_escape_string($conn, $_POST['pilihanKelas']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Memastikan semua input tidak kosong
if (empty($fname) || empty($lname) || empty($nim) || empty($prodi) || empty($kelas) || empty($email) || empty($password)) {
    echo "Semua input harus diisi!";
    exit();
}

// Validasi email dengan fungsi filter_var
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email tidak valid.";
    exit();
}

// Memeriksa apakah NIM sudah digunakan
$sql = mysqli_query($conn, "SELECT nim FROM users WHERE nim = '{$nim}'");
if (mysqli_num_rows($sql) > 0) {
    echo "NIM $nim sudah digunakan.";
    exit();
}

// Memeriksa apakah email sudah digunakan
$sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
if (mysqli_num_rows($sql) > 0) {
    echo "Email $email sudah digunakan.";
    exit();
}

// Hashing password sebelum disimpan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Upload gambar profil jika ada
if (isset($_FILES['image'])) {
    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $allowed_extensions = ['png', 'jpeg', 'jpg'];

    if (!in_array($img_ext, $allowed_extensions)) {
        echo "Please select an image file - jpeg, jpg, png";
        exit();
    }

    $time = time();
    $new_img_name = $time . $img_name;
    if (!move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
        echo "Failed to upload image.";
        exit();
    }
} else {
    $new_img_name = ""; // No image uploaded
}

// Insert user data into database
$status = "Active now";
$random_id = rand(time(), 10000000);
$sql2 = mysqli_query($conn, "INSERT INTO users(unique_id, fname, lname, nim, prodi, kelas, email, password, img, status)
                                    VALUES ('{$random_id}', '{$fname}', '{$lname}', '{$nim}', '{$prodi}', '{$kelas}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}')");
if ($sql2) {
    // Retrieve inserted user data
    $sql3 = mysqli_query($conn, "SELECT * from users where nim = '{$nim}'");
    if (mysqli_num_rows($sql3) > 0) {
        $row = mysqli_fetch_assoc($sql3);
        $_SESSION['unique_id'] = $row['unique_id'];
        echo "success";
        exit();
    }
} else {
    echo "Terjadi kesalahan. Silakan coba lagi.";
}
?>
