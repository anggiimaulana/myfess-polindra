<?php 
    require "../config/config.php";

    // Query data mahasiswa
    $mahasiswa = "SELECT * FROM users ORDER BY user_id DESC";
    $queryMahasiswa = mysqli_query($conn, $mahasiswa);

    // Query untuk menghitung jumlah mahasiswa di tabel users
    $sqlUsers = "SELECT COUNT(user_id) AS total_users FROM users";
    $queryUsers = mysqli_query($conn, $sqlUsers);
    $dataUsers = mysqli_fetch_assoc($queryUsers);
    $totalUsers = $dataUsers['total_users'];

    // Query untuk menghitung jumlah postingan di tabel post
    $sqlPosts = "SELECT COUNT(post_id) AS total_posts FROM post";
    $queryPosts = mysqli_query($conn, $sqlPosts);
    $dataPosts = mysqli_fetch_assoc($queryPosts);
    $totalPosts = $dataPosts['total_posts'];

    // Query untuk menghitung jumlah mahasiswa berdasarkan program studi
    $sqlProdi = "SELECT prodi, COUNT(prodi) AS total_prodi FROM users GROUP BY prodi";
    $queryProdi = mysqli_query($conn, $sqlProdi);

    // Array untuk menyimpan data
    $dataProdiRaw = [];
    
    // Konversi nama prodi ke singkatan dan menghitung jumlah mahasiswa per prodi
    while ($row = mysqli_fetch_assoc($queryProdi)) {
        $prodi = $row['prodi'];
        $totalProdi = $row['total_prodi'];

        // Mengganti nama prodi dengan singkatan dan menyimpan ke array
        switch ($prodi) {
            case 'D4 Rekayasa Perangkat Lunak':
                $dataProdiRaw['RPL'] = $totalProdi;
                break;
            case 'D4 Perancangan Manufaktur':
                $dataProdiRaw['PM'] = $totalProdi;
                break;
            case 'D4 Sistem Informasi Kota Cerdas':
                $dataProdiRaw['SIKC'] = $totalProdi;
                break;
            case 'D4 Teknologi Rekayasa Instrumentasi dan Kontrol':
                $dataProdiRaw['TRIK'] = $totalProdi;
                break;
            case 'D3 Teknik Informatika':
                $dataProdiRaw['TI'] = $totalProdi;
                break;
            case 'D3 Teknik Mesin':
                $dataProdiRaw['TM'] = $totalProdi;
                break;
            case 'D3 Teknik Pendingin dan Tata Udara':
                $dataProdiRaw['TPTU'] = $totalProdi;
                break;
            case 'D3 Keperawatan':
                $dataProdiRaw['KP'] = $totalProdi;
                break;
        }
    }

    // Menyusun urutan label dan dataProdi secara konsisten
    $labels = ['RPL', 'PM', 'SIKC', 'TRIK', 'TI', 'TM', 'TPTU', 'KP'];
    $dataProdi = [];

    foreach ($labels as $label) {
        $dataProdi[] = isset($dataProdiRaw[$label]) ? $dataProdiRaw[$label] : 0;
    }
?>

<!-- HTML Section -->
<?php include "layouts/header.php"; ?>
<body>
    <?php include "layouts/sidebar.php"; ?>
    <section id="content">
        <?php include "layouts/nav.php"; ?>
        <main>
        <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
            <ul class="box-info">
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo $totalUsers; ?></h3>
                        <p>Mahasiswa</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">
                        <h3><?php echo $totalPosts; ?></h3>
                        <p>Postingan</p>
                    </span>
                </li>
				<li>
					<i class='bx bxs-report' ></i>
					<span class="text">
						<h3>4</h3>
						<p>Laporan</p>
					</span>
				</li>
            </ul>

            <div class="table-data">
                <div class="order">
					<div class="head">
						<h3>Mahasiswa</h3>
						<div class="filter-dropdown">
							<i class='bx bx-filter' onclick="toggleDropdown()"></i>
							<select id="prodiFilter" onchange="filterData()">
								<option value="">Pilih Program Studi</option>
								<option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
								<option value="D4 Rekayasa Perangkat Lunak">D4 Rekayasa Perangkat Lunak</option>
								<option value="D4 Sistem Informasi Kota Cerdas">D4 Sistem Informasi Kota Cerdas</option>
								<option value="D3 Teknik Mesin">D3 Teknik Mesin</option>
								<option value="D4 Perancangan Manufaktur">D4 Perancangan Manufaktur</option>
								<option value="D3 Teknik Pendingin dan Tata Udara">D3 Teknik Pendingin dan Tata Udara</option>
								<option value="D4 Teknologi Rekayasa Instrumentasi dan Kontrol">D4 Teknologi Rekayasa Instrumentasi dan Kontrol</option>
								<option value="D3 Keperawatan">D3 Keperawatan</option>
							</select>
						</div>
						<input type="text" id="searchInput" placeholder="Cari nama mahasiswa...">
					</div>

                    <table>
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while ($mhs = mysqli_fetch_assoc($queryMahasiswa)) {
                                    $fullName = $mhs['fname'] . " " . $mhs['lname'];
                                    echo "<tr>";
                                        echo "<td>{$fullName}</td>";
                                        echo "<td>{$mhs['nim']}</td>";
                                        echo "<td>{$mhs['prodi']}</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="todo">
                    <div class="head">
                        <h3>Statistik</h3>
                    </div>
                    <!-- Canvas for the chart -->
                    <canvas id="prodiChart"></canvas>
                </div>
            </div>
			<?php
				include "layouts/footer.php";
			?>
        </main>
    </section>

    <!-- Tambahkan script Chart.js -->
	<script src="js/script.js"></script>
	<script src="js/filter.js"></script>
	<script src="js/search.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
        // Data dari PHP
        const labels = <?php echo json_encode($labels); ?>;
        const dataProdi = <?php echo json_encode($dataProdi); ?>;

        // Debugging untuk memeriksa apakah data sesuai
        console.log(labels);
        console.log(dataProdi);

        var prodiChart;
        function createChart() {
            if (prodiChart) {
                prodiChart.destroy();
            }

            // Konfigurasi data untuk Chart.js
            const data = {
                labels: labels,  
                datasets: [{
                    label: 'Jumlah Mahasiswa: ',
                    data: dataProdi, 
                    backgroundColor: [
                        '#FFEB3B', // RPL
                        '#1976D2', // PM
                        '#FFD54F', // SIKC
                        '#B0BEC5', // TRIK
                        '#FF9800', // TI
                        '#2196F3', // TM
                        '#F44336', // TPTU
                        '#4CAF50'  // KP
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            };

            // Konfigurasi Chart
            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Mahasiswa Berdasarkan Program Studi'
                        }
                    }
                },
            };

            // Render Chart
            prodiChart = new Chart(
                document.getElementById('prodiChart'),
                config
            );
        }

        // Buat chart pertama kali
        createChart();
    </script>
</body>
</html>
