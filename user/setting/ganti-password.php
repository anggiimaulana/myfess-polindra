<?php 
    session_start(); // Memulai session sebelum menggunakan $_SESSION

    if(!isset($_SESSION['unique_id'])) {
        header("location: ../../login.php");
    }

?>

<?php include 'template/head.php' ?>

    <div class="wrapper">
    <?php include 'template/header.php' ?>

        <section class="header-profile">
            <header>
                <a href="edit-profile.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <h4>Edit Password Mahasiswa</h4>
            </header>
        </section>
        <section class="form-isi profile">
            <form action="../proses-setting/proses-edit-pw.php" method="post" enctype="multipart/form-data">
                <div class="list-daftar">
                <div class="field input">
                        <label for="password">Password Lama</label>
                        <input type="password" name="passwordOld" id="passwordOld" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password Baru</label>
                        <input type="password" name="newPassword" id="newPassword" required>
                    </div>
                    <div class="field input">
                        <label for="password">Konfirmasi Password Baru</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" required>
                    </div>
                    <div class="field button">
                        <input type="submit" value="Submit" name="simpan">
                    </div>
                </div>
            </form>
        </section>
        <?php include 'template/menu.php' ?>

    </div>
</body>
</html>