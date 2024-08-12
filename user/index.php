<?php
    session_start();
    if (!isset($_SESSION['unique_id'])) {
        header("Location: ../login.php");
        exit();
    }
?>

<?php include 'template/head.php' ?>
    <div class="wrapper">
        <!-- header -->
        <?php include 'template/header.php' ?>
        <!-- header -->
        <section class="cerita">
            <header>
                <div class="content">
                    <?php 
                        include_once "../config/config.php";

                        $user_id = $_SESSION['unique_id'];  // Mengambil ID pengguna dari sesi
        
                        // Menggunakan prepared statement untuk mencegah SQL Injection
                        $stmt = $conn->prepare("SELECT * FROM users WHERE unique_id = ?");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    ?>
                    <a href="cerita.php">
                        <img src="../anonim.png" alt="User Image">
                        <div class="details">
                            <span>
                                <p>Ayo Mulai bercerita dengan fitur anonim disini!</p>
                            </span>
                        </div>
                    </a>
                </div>
            </header>
            <div class="cerita-list">
                <?php 
                    include_once "../config/config.php";
                    $sql = "SELECT * FROM post 
                    -- LEFT JOIN users on users.unique_id = post.user_post
                            ORDER BY post_id DESC";
                    $query = mysqli_query($conn, $sql);        
                    if ($query) {
                        while ($post = mysqli_fetch_array($query)) {
                            echo "<div class='content'>";
                                echo "<div class='details'>";
                                    echo "<div>";
                                        echo "<img src='../anonim.png' alt='User Image'>";
                                        echo "<span>Anonim</span>"; 
                                        echo "<a href='komentar.php?post_unique=".$post['unique_post']."' class='balas-cerita'>";
                                            echo "<div class='icon-balas'><i class='fas fa-arrow-right'></i></div>";
                                            echo "<p>Balas</p>";
                                        echo "</a>";
                                    echo "</div>";
                                    echo "<div class='cerita-content'>";
                                        echo "<p>". $post['post_content'] ."</p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Terjadi kesalahan saat mengambil data dari database.</p>";
                    }
                ?>
            </div>
        </section>
        <!-- menu -->
         <?php include 'template/menu.php' ?>
        <!-- menu -->
    </div>
</body>
</html>
