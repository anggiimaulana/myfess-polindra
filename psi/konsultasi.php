<?php 
    require "../config/config.php";
    
    // Jika menerima request AJAX dengan parameter 'status'
    if (isset($_POST['status'])) {
        $status = $_POST['status'];

        // Query untuk mendapatkan data postingan berdasarkan status
        $post_query = "SELECT post.*, users.fname, users.lname, users.nim
                       FROM post 
                       INNER JOIN users ON post.user_post = users.unique_id 
                       WHERE post.status = ?
                       ORDER BY post.post_id DESC";

        // Siapkan statement untuk menghindari SQL Injection
        $stmt = $conn->prepare($post_query);
        $stmt->bind_param("i", $status);
        $stmt->execute();
        $posts = $stmt->get_result();

        // Hasil filter dikirim kembali dalam bentuk HTML
        if ($posts->num_rows > 0) {
            while ($row = $posts->fetch_assoc()) {
                $fname = $row['fname'];
                $lname = $row['lname'];
                $nim = isset($row['nim']) ? $row['nim'] : 'N/A';  // Menambahkan kondisi isset
                $status = $row['status'];

                // Gabungkan fname dan lname, potong jika lebih dari 15 huruf
                $fullname = $fname . ' ' . $lname;
                if (strlen($fullname) > 15) {
                    $fullname = substr($fullname, 0, 15) . '...';
                }

                // Tentukan class status berdasarkan nilai status
                $status_class = ($status == 0) ? 'process' : (($status == 1) ? 'scheduled' : 'completed');
                $status_label = ($status == 0) ? 'Proses' : (($status == 1) ? 'Terjadwal' : 'Selesai');

                // Output hasil filter dalam bentuk row tabel
                echo "<tr>
                        <td>{$fullname}</td>
                        <td>{$nim}</td>
                        <td><span class='status {$status_class}'>{$status_label}</span></td>
                        <td>
                            <button class='button'><a href='r/req.php?id={$row['post_id']}'>Tinjau</a></button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No posts available</td></tr>";
        }
        // Berhenti di sini jika request melalui AJAX untuk mencegah halaman memuat ulang
        exit();
    }

    // Query untuk mendapatkan semua data postingan (jika halaman pertama kali dimuat)
    $post_query = "SELECT post.*, users.fname, users.lname, users.nim
                   FROM post 
                   INNER JOIN users ON post.user_post = users.unique_id 
                   ORDER BY post.post_id DESC";
    $posts = mysqli_query($conn, $post_query);

    // Query untuk menghitung jumlah postingan dengan status 1 (Selesai)
    $finish_query = "SELECT COUNT(*) AS total_publish FROM post WHERE status = 2";
    $finish_result = mysqli_query($conn, $finish_query);
    $finish_count = mysqli_fetch_assoc($finish_result)['total_publish'];

    // Query untuk menghitung jumlah postingan dengan status 0 (Proses)
    $process_query = "SELECT COUNT(*) AS total_process FROM post WHERE status = 0";
    $process_result = mysqli_query($conn, $process_query);
    $process_count = mysqli_fetch_assoc($process_result)['total_process'];

    // Query untuk menghitung jumlah postingan dengan status 2 (Dijadwalkan)
    $terjadwal = "SELECT COUNT(*) AS dijadwalkan FROM post WHERE status = 1";
    $terjadwalkan_result = mysqli_query($conn, $terjadwal);
    $terjadwalkan_count = mysqli_fetch_assoc($terjadwalkan_result)['dijadwalkan'];

    // Jumlahkan semua postingan
    $total_posts = $finish_count + $process_count + $terjadwalkan_count;

?>

<!-- Header -->
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
                    <h1>Permintaan Konsultasi</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Permintaan Konsultasi</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li data-status="2">
                    <i class='bx bx-globe'></i>
                    <span class="text">
                        <h3><?php echo $finish_count; ?></h3>
                        <p>Selesai</p>
                    </span>
                </li>
                <li data-status="0">
                    <i class='bx bx-loader'></i>
                    <span class="text">
                        <h3><?php echo $process_count; ?></h3>
                        <p>Proses</p>
                    </span>
                </li>
				<li data-status="1">
					<i class='bx bx-calendar'></i>
                    <span class="text">
                        <h3><?php echo $terjadwalkan_count; ?></h3>
                        <p>Terjadwal</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Konsultasi Mahasiswa</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(mysqli_num_rows($posts) > 0) {
                                    while($row = mysqli_fetch_assoc($posts)) {
                                        $fname = $row['fname'];
                                        $lname = $row['lname'];
                                        $nim = isset($row['nim']) ? $row['nim'] : 'N/A';  // Menambahkan kondisi isset
                                        $status = $row['status'];

                                        // Gabungan fname dan lname, dan potong jika lebih dari 30 huruf
                                        $fullname = $fname . ' ' . $lname;
                                        if (strlen($fullname) > 30) {
                                            $fullname = substr($fullname, 0, 15) . '...';
                                        }

                                        // Penentuan class status berdasarkan nilai status
                                        $status_class = ($status == 0) ? 'process' : (($status == 1) ? 'scheduled' : 'completed');
                                        $status_label = ($status == 0) ? 'Proses' : (($status == 1) ? 'Terjadwal' : 'Selesai');

                                        echo "<tr>
                                                <td>{$fullname}</td>
                                                <td>{$nim}</td>
                                                <td><span class='status {$status_class}'>{$status_label}</span></td>
                                                <td>
                                                    <button class='button tinjau'><a href='r/req.php?id={$row['post_id']}'>Tinjau</a></button>
                                                    <button class='button hapus'><a href='r/req.php?id={$row['post_id']}'>Hapus</a></button>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No posts available</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
                include "layouts/footer.php";
            ?>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="js/script.js"></script>
    <script>
    document.querySelectorAll('.box-info li').forEach(item => {
        item.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            
            // Mengirim request AJAX ke halaman yang sama
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // Tetap di halaman yang sama
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    // Ganti isi tabel dengan hasil filter
                    document.querySelector('tbody').innerHTML = this.responseText;
                }
            };
            xhr.send('status=' + status); // Kirim data status melalui POST
        });
    });
    </script>
</body>
</html>
