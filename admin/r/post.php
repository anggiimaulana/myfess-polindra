<?php 
    include "../../config/config.php";

    // Tangkap ID dari URL
    if(isset($_GET['id'])){
        $post_id = $_GET['id'];

        $post_query = "SELECT post.*, users.fname, users.lname, users.kelas, users.nim
                        FROM post 
                        INNER JOIN users ON post.user_post = users.unique_id 
                        WHERE post.post_id = $post_id";
        $result = mysqli_query($conn, $post_query);

        // Cek apakah data ditemukan
        if(mysqli_num_rows($result) > 0) {
            $post_data = mysqli_fetch_assoc($result);
        } else {
            echo "Postingan tidak tersedia";
            exit;
        }
    } else {
        echo "Post ID tidak cocok!";
        exit;
    }

    if(isset($_POST['submit'])){
        $status = $_POST['status'];

        $update_query = "UPDATE post SET status = $status WHERE post_id = $post_id";

        // Eksekusi query
        if(mysqli_query($conn, $update_query)){
            echo "<script>alert('Status berhasil diperbarui!'); window.location.href='../filter-postingan.php';</script>";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
?>

<?php 
    include "layouts/header.php";
?>
<body>

    <!-- SIDEBAR -->
    <?php 
        include "layouts/sidebar.php";
    ?>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php 
            include "layouts/nav.php";
        ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Tinjau Postingan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a href="#">Filter Postingan</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Tinjau</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Postingan #<?php echo $post_id; ?></h3>
                    </div>
                    <form method="POST">
						<div class="form-group">
							<div class="dataPost">
								<label for="namaMhs">Nama:</label>
								<input type="text" id="namaMhs" name="namaMhs" value="<?php echo $post_data['fname'] . ' ' . $post_data['lname']; ?>" readonly disabled>
							</div>
							<div class="dataPost">
								<label for="kelas">Kelas:</label>
								<input type="text" id="kelas" name="kelas" value="<?php echo $post_data['kelas']; ?>" readonly disabled>
							</div>
							<div class="dataPost">
								<label for="nim">NIM:</label>
								<input type="text" id="nim" name="nim" value="<?php echo $post_data['nim']; ?>" readonly disabled> <!-- Update dengan NIM dari database -->
							</div>
						</div>
						
						<div class="dataPost">
							<label for="post">Isi Postingan:</label>
							<textarea name="post" id="post" readonly disabled><?php echo $post_data['post_content']; ?></textarea>
						</div>

						<div class="status-group">
							<label for="status">Status:</label>
							<select name="status" id="status">
								<option value="0" <?php echo ($post_data['status'] == 0) ? 'selected' : ''; ?>>Proses</option>
								<option value="1" <?php echo ($post_data['status'] == 1) ? 'selected' : ''; ?>>Publish</option>
								<option value="2" <?php echo ($post_data['status'] == 2) ? 'selected' : ''; ?>>Ditolak</option>
							</select>
						</div>

						<div class="dataPost">
							<input type="submit" name="submit" id="submit" value="Simpan">
						</div>
					</form>
                </div>
            </div>
            <?php
                include "layouts/footer.php";
            ?>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="../js/script.js"></script>
</body>
</html>