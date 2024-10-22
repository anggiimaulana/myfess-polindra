<?php 
    include "../../config/config.php";

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
                    <h1>Buat Laporan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a href="#">Laporan</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Buat</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Buat Laporan</h3>
                    </div>
                    <form method="POST">
                        <div class="form-group">
                            <div class="dataPost">
                                <label for="tanggal_laporan">Tanggal:</label>
                                <input type="date" id="tanggal_laporan" name="tanggal_laporan">
                            </div>
                            <div class="dataPost">
                                <label for="file">File</label>
                                <input type="file">
                            </div>
                        </div>
                        <div class="status-group">
                            <label for="sendTo">Untuk:</label>
                            <select name="sendTo" id="sendTo">
                                <option value="Bayu">Bayu</option>
                                <option value="Anggi">Anggi</option>
                                <option value="Malik">Malik</option>
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
