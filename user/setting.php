<?php
    session_start();
    if (!isset($_SESSION['unique_id'])) {
        header("Location: ../login.php");
        exit();
    }
?>

<?php include 'template/head.php' ?>

    <div class="wrapper">
    <?php include 'template/header.php' ?>

        <section class="header-pengaturan">
            <header>
                <h4>Pengaturan akun</h4>
            </header>
        </section>
        <section class="setting-content">
            <a href="setting/profile.php">
                <div class="profile-user">
                    <p>> Profile Mahasiswa</p>
                </div>
            </a>

            <div class="keluar">
            <?php
                if (isset($_SESSION['unique_id'])) {
                    $unique_id = $_SESSION['unique_id'];
                } else {
                    // Jika sesi tidak ditemukan, arahkan ke halaman login
                    header("location: ../login.php");
                    exit();
                }

                include_once "../config/config.php";
                $sql = mysqli_query($conn, "SELECT  * from users where unique_id = '{$unique_id}'");
                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                }
            ?>
                <a href="proses-setting/logout.php?logout_id=<?php echo $row['unique_id']?>" class="logout">Logout</a>
            </div>
            <div class="hapus">
                <?php
                if (isset($_SESSION['unique_id'])) {
                    $unique_id = $_SESSION['unique_id'];
                } else {
                    // Jika sesi tidak ditemukan, arahkan ke halaman login
                    header("location: ../login.php");
                    exit();
                }

                include_once "../config/config.php";
                $sql = mysqli_query($conn, "SELECT  * from users where unique_id = '{$unique_id}'");
                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                ?>
                    <a href="proses-setting/delete.php?delete_id=<?php echo $row['unique_id'] ?>" class="hapus">Hapus Akun</a>
                <?php
                } else {
                    echo "Tidak ada pengguna yang ditemukan.";
                }
                ?>
            </div>

        </section>
        <?php include 'template/menu.php' ?>

    </div>
</body>