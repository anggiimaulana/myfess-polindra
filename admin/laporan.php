<?php 
    require "../config/config.php";

    // Ambil data laporan dari database
    $query = "SELECT * FROM laporan ORDER BY id DESC";
    
    // Siapkan statement
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Ambil hasil query
    $posts = $stmt->get_result();
?>

<!-- header -->
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
                    <h1>Laporan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Laporan</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recent Orders</h3>
                        <button class="laporan"><a href="r/create-report.php">Buat Laporan</a></button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Tanggal</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop untuk menampilkan data laporan
                            while ($row = $posts->fetch_assoc()) {
                                $id_report = $row['id'];
                                $pengirim = $row['userSend'];
                                $tanggal = $row['date'];
                                $file = $row['file'];
                                $status = $row['status'];

                                // Tentukan status teks dan kelas CSS untuk styling
                                $status_text = $status == 0 ? 'Belum Dibaca' : 'Dibaca';
                                $status_class = $status == 0 ? 'pending' : 'completed';

                                // Tampilkan data dalam tabel
                                echo "<tr>
                                        <td>{$pengirim}</td>
                                        <td>{$tanggal}</td>
                                        <td class='file'>
                                            <a href='r/doc/{$file}' target='_blank'>{$file}</a>
                                        </td>
                                        <td><span class='status {$status_class}'>{$status_text}</span></td>
                                        <td>
                                            <button class='button'><a href='r/report.php?id={$id_report}'>Tinjau</a></button>
                                        </td>
                                    </tr>";
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
</body>
</html>
