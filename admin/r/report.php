<?php 
    include "../../config/config.php";

    // Tangkap ID dari URL
    if(isset($_GET['id'])){
        $laporan_id = $_GET['id'];

        // Query untuk mengambil laporan berdasarkan ID
        $query = "SELECT * FROM laporan WHERE id = $laporan_id";
        $result = mysqli_query($conn, $query);

        // Cek apakah data ditemukan
        if(mysqli_num_rows($result) > 0) {
            $laporan_data = mysqli_fetch_assoc($result);
        } else {
            echo "Laporan tidak ditemukan";
            exit;
        }
    } else {
        echo "ID Laporan tidak cocok!";
        exit;
    }

    // Ketika form di-submit
    if(isset($_POST['submit'])){
        // Tangkap nilai status dari form
        $status = $_POST['status'];

        // Query untuk memperbarui status laporan
        $update_query = "UPDATE laporan SET status = $status WHERE id = $laporan_id";

        // Eksekusi query update
        if(mysqli_query($conn, $update_query)){
            // Redirect atau tampilkan pesan sukses
            echo "<script>alert('Status berhasil diperbarui!'); window.location.href='../laporan.php';</script>";
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
                    <h1>Tinjau Laporan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a href="#">Daftar Laporan</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Tinjau</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Laporan #<?php echo $laporan_id; ?></h3>
                    </div>
                    <form method="POST">
                        <div class="form-group">
                            <div class="dataPost">
                                <label for="nama">Nama Pengirim</label>
                                <input type="text" id="nama" name="nama" value="Anggi" disabled>
                            </div>
                            <div class="dataPost">
                                <label for="tanggal_laporan">Tanggal Laporan:</label>
                                <input type="text" id="tanggal_laporan" name="tanggal_laporan" value="<?php echo date('d M Y', strtotime($laporan_data['date'])); ?>" readonly disabled>
                            </div>
                            <div class="dataPost">
                                <label for="file">File</label>
                                <?php
                                // Path ke direktori tempat file disimpan
                                $file_dir = '/myfess/admin/r/doc/';
                                $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_dir . $laporan_data['file'];

                                // Cek apakah file ada di direktori
                                if(file_exists($file_path)){
                                    // Tampilkan nama file sebagai tautan yang bisa diklik untuk membuka file
                                    echo "<a href='{$file_dir}{$laporan_data['file']}' target='_blank'>" . $laporan_data['file'] . "</a>";
                                } else {
                                    echo "File tidak ditemukan.";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="status-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status">
                                <option value="1" <?php echo ($laporan_data['status'] == 1) ? 'selected' : ''; ?>>Dibaca</option>
                                <option value="0" <?php echo ($laporan_data['status'] == 0) ? 'selected' : ''; ?>>Belum Dibaca</option>
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
