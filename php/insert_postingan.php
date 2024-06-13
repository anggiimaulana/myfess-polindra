<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Menyimpan data form ke dalam session untuk menjaga isi form jika ada kesalahan
        $_SESSION['form_data'] = $_POST;

        if (isset($_POST['setuju'])) {
            // Validasi $_POST['unique_post'] dan $_POST['post_content']
            $unique_post = isset($_POST['unique_post']) ? mysqli_real_escape_string($conn, $_POST['unique_post']) : '';
            $post_content = isset($_POST['post_content']) ? mysqli_real_escape_string($conn, $_POST['post_content']) : '';
            
            $user_post = $_SESSION['unique_id']; // Asumsi bahwa unique_id dalam sesi adalah user_id dari pengguna yang sedang login

            if (!empty($post_content)) {
                $unique_post = rand(time(), 10000000);
                $sql = mysqli_query($conn, "INSERT INTO post (unique_post, post_content, user_post) VALUES ('{$unique_post}', '{$post_content}', '{$user_post}')");

                if ($sql) {
                    // Hapus data form dari session setelah berhasil menyimpan
                    unset($_SESSION['form_data']);
                    echo "<script>alert('Postingan berhasil ditambahkan'); window.location.href='../home.php';</script>";
                } else {
                    echo "Gagal menambahkan postingan";
                }
            } else {
                echo "Isi postingan tidak boleh kosong";
            }

            // Kueri LEFT JOIN untuk mendapatkan daftar postingan dengan informasi pengguna
            $query = "
                SELECT * FROM post
                LEFT JOIN users ON users.user_id = post.user_post 
                WHERE post.user_post = {$user_post}
            ";
            $result = mysqli_query($conn, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "Post ID: " . $row['unique_post'] . " - Content: " . $row['post_content'] . " - User: " . $row['username'] . " - Email: " . $row['email'] . "<br>";
                }
            } else {
                echo "Gagal mengambil data";
            }
        } else {
            echo "<script>alert('Centang dulu bro!'); window.location.href='../cerita.php';</script>";
        }
    }
} else {
    header("Location: ../login.php");
    exit(); // tambahkan exit untuk menghentikan eksekusi skrip setelah redirect
}
?>
