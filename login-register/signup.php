<?php
session_start();
include_once "../config/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape semua input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $status = "Active now";
    $random_id = rand(time(), 10000000);

    // Validasi input berdasarkan field yang ada
    if (isset($_POST['nip'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $nip = mysqli_real_escape_string($conn, $_POST['nip']);
        if (empty($nama) || empty($email) || empty($password) || empty($nip)) {
            echo "Semua input harus diisi!";
            exit();
        }
        $identifier = "nip";
        $identifier_value = $nip;
        $table = "admin";
    } elseif (isset($_POST['nim'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $nim = mysqli_real_escape_string($conn, $_POST['nim']);
        $prodi = mysqli_real_escape_string($conn, $_POST['prodi']);
        $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
        if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($nim) || empty($prodi) || empty($kelas)) {
            echo "Semua input harus diisi!";
            exit();
        }
        $identifier = "nim";
        $identifier_value = $nim;
        $table = "users";
        $nama = $fname . " " . $lname;
    } else {
        echo "Invalid form submission.";
        exit();
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email tidak valid.";
        exit();
    }

    // Memeriksa apakah email sudah digunakan
    $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}' UNION SELECT email FROM admin WHERE email = '{$email}'");
    if (mysqli_num_rows($sql) > 0) {
        echo "Email $email sudah digunakan.";
        exit();
    }

    // Memeriksa apakah identifier sudah digunakan
    $sql = mysqli_query($conn, "SELECT $identifier FROM $table WHERE $identifier = '{$identifier_value}'");
    if (mysqli_num_rows($sql) > 0) {
        echo strtoupper($identifier) . " $identifier_value sudah digunakan.";
        exit();
    }

    // Upload gambar profil jika ada
    $new_img_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed_extensions = ['png', 'jpeg', 'jpg'];

        if (!in_array($img_ext, $allowed_extensions)) {
            echo "Please select an image file - jpeg, jpg, png";
            exit();
        }

        $time = time();
        $new_img_name = $time . "_" . $img_name;
        if (!move_uploaded_file($tmp_name, "../user/images/" . $new_img_name)) {
            echo "Failed to upload image.";
            exit();
        }
    }

    // Insert user data into database
    if ($table == "admin") {
        $sql = mysqli_query($conn, "INSERT INTO $table (unique_id, nama, nip, email, password, img, status)
                                    VALUES ('{$random_id}', '{$nama}', '{$identifier_value}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}')");
    } else {
        $sql = mysqli_query($conn, "INSERT INTO $table (unique_id, fname, lname, nim, prodi, kelas, email, password, img, status)
                                    VALUES ('{$random_id}', '{$fname}', '{$lname}', '{$identifier_value}', '{$prodi}', '{$kelas}', '{$email}', '{$hashed_password}', '{$new_img_name}', '{$status}')");
    }

    if ($sql) {
        $sql = mysqli_query($conn, "SELECT * FROM $table WHERE $identifier = '{$identifier_value}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        } else {
            echo "This $identifier_value not exist!";
        }
    } else {
        echo "Something went wrong!";
    }
}
?>
