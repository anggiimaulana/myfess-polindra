<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("location: ../login.php");
    exit();
}

// Menyiapkan data form jika tersedia dalam session
$post_content = isset($_SESSION['form_data']['post_content']) ? $_SESSION['form_data']['post_content'] : '';

?>

<?php include 'template/head.php' ?>
    <div class="wrapper">
    <?php include 'template/header.php' ?>
        <section class="postingan-area">
            <header>
                <a href="./" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <p>Buat Cerita</p>
                <!-- <a href="#"><h4>Bagikan</h4></a> -->
            </header>
            <div class="postingan-box">
                <div class="postingan incoming">
                    <img src="../anonim.png" alt="">
                    <div class="details">
                        <h4>Anonim</h4>
                        <h6>Bercerita tanpa dikenali orang lain!.</h6>
                    </div>
                </div>
                <div class="postingan-content">
                    <form action="proses-cerita/insert_postingan.php" method="POST" class="typing-area">
                        <textarea class="input-field" id="story" name="post_content" placeholder="Tulis ceritamu disini!"><?php echo htmlspecialchars($post_content); ?></textarea>
                        <input type="text" name="post_user" hidden>
                        <div class="catatan">
                            <h4>Catatan:</h4>
                            <ol>
                                <li>Sebelum masuk ke beranda, postingan (cerita) akan di filter terlebih dahulu oleh admin.</li>
                                <li>Gunakan bahasa yang baik dan tidak mengandung bahasa kasar.</li>
                                <li>Orang lain tidak akan mengenali anda, kecuali <i>Admin</i> dan <i>Psikolog.</i></li>
                            </ol>
                        </div>
                        <div class="setuju">
                            <input type="checkbox" name="setuju" id="setuju"> 
                            <label for="setuju">Saya setuju dengan ketentuan yang berlaku.</label>
                        </div>
                        <button type="submit" class="tombol-posting">Bagikan</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
