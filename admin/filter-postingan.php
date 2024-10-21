<?php 
	require "../config/config.php";
	
	// Query untuk mendapatkan data postingan yang berelasi dengan mahasiswa melalui unique_id
	$post_query = "SELECT post.*, users.fname, users.lname, users.kelas
				    FROM post 
				    INNER JOIN users ON post.user_post = users.unique_id 
				    ORDER BY post.post_id DESC";
	$posts = mysqli_query($conn, $post_query);
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
					<h1>Filter Postingan</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Admin</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Filter Postingan</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Postingan Mahasiswa</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Nama Lengkap</th>
								<th>Kelas</th>
								<th>Postingan</th>
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
										$postingan = $row['post_content'];
										$kelas = $row['kelas'];
										$status = $row['status'];

										// Pemotongan post_content jika lebih dari 150 huruf
										if (strlen($postingan) > 25) {
											$postingan = substr($postingan, 0, 25) . '...';
										}

										// Gabungan fname dan lname, dan potong jika lebih dari 30 huruf
										$fullname = $fname . ' ' . $lname;
										if (strlen($fullname) > 15) {
											$fullname = substr($fullname, 0, 15) . '...';
										}

										// Penentuan class status berdasarkan nilai status
										$status_class = ($status == 0) ? 'process' : (($status == 1) ? 'completed' : 'pending');
										$status_label = ($status == 0) ? 'Proses' : (($status == 1) ? 'Publish' : 'Ditolak');

										echo "<tr>
												<td>{$fullname}</td>
												<td>{$kelas}</td>
												<td>{$postingan}</td>
												<td><span class='status {$status_class}'>{$status_label}</span></td>
												<td>
													<button class='button'><a href='r/post.php?id={$row['post_id']}'>Tinjau</a></button>
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
</body>
</html>
