<?php 
    include "../../config/config.php";

    // Ketika form di-submit
    if(isset($_POST['submit'])){
        // Cek apakah ada file yang di-upload
        if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
            // Tangkap file yang di-upload
            $file = $_FILES['file'];

            // Nama file asli
            $file_name = $file['name'];

            // Ekstensi file yang diizinkan
            $allowed_ext = array('pdf', 'docx');

            // Dapatkan ekstensi file
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Cek apakah ekstensi file diizinkan
            if(in_array($file_ext, $allowed_ext)) {

                // Proses upload, simpan file ke direktori tertentu
                $upload_dir = "doc/";
                $file_tmp = $file['tmp_name'];

                // Generate nama file yang unik menggunakan uniqid()
                $unique_id = uniqid();
                $new_file_name = $unique_id . "_" . $file_name; // Menggunakan uniqid() untuk nama unik

                // Pastikan file tidak terduplikasi di folder tujuan
                if(!file_exists($upload_dir . $new_file_name)) {
                    // Pindahkan file ke folder upload
                    if(move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
                        // Lakukan operasi database, misalnya simpan nama file ke DB
                        $insert_query = "INSERT INTO laporan (date, file) VALUES ('{$_POST['tanggal_laporan']}', '$new_file_name')";

                        // Eksekusi query insert
                        if(mysqli_query($conn, $insert_query)){
                            // Redirect atau tampilkan pesan sukses
                            echo "<script>alert('Laporan berhasil disimpan!'); window.location.href='../laporan.php';</script>";
                        } else {
                            echo "Error inserting record: " . mysqli_error($conn);
                        }
                    } else {
                        echo "<script>alert('Gagal mengupload file.');</script>";
                    }
                } else {
                    echo "<script>alert('File dengan nama yang sama sudah ada.');</script>";
                }
            } else {
                // Jika file tidak valid
                echo "<script>alert('Hanya file .pdf atau .docx yang diizinkan!');</script>";
            }
        } else {
            echo "<script>alert('Tidak ada file yang diupload atau terjadi kesalahan saat upload.');</script>";
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
                    <form method="POST" enctype="multipart/form-data" id="laporanForm">
                        <div class="form-group">
                            <div class="dataPost">
                                <label for="tanggal_laporan">Tanggal:</label>
                                <input type="date" id="tanggal_laporan" name="tanggal_laporan">
                            </div>
                            <div class="dataPost">
                                <label for="file">File</label>
                                <input type="file" name="file" id="file" required>
                                <span id="fileError" style="color:red; display:none; font-size:13px;">Hanya file .pdf atau .docx yang diizinkan!</span>
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
    <script>
        document.getElementById('file').addEventListener('change', function() {
            const fileInput = document.getElementById('file');
            const fileError = document.getElementById('fileError');
            const allowedExtensions = ['pdf', 'docx'];
            const fileName = fileInput.value.split('.').pop().toLowerCase();
            
            if (allowedExtensions.indexOf(fileName) === -1) {
                fileError.style.display = 'block'; // Tampilkan peringatan
                fileInput.value = ''; // Kosongkan input file
            } else {
                fileError.style.display = 'none'; // Sembunyikan peringatan
            }
        });
    </script>
</body>
</html>
