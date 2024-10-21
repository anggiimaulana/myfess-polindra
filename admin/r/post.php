<?php 
	include "header.php";
?>
<body>


	<!-- SIDEBAR -->
	<?php 
		include "../layouts/sidebar.php";
	?>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php 
			include "../layouts/nav.php";
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
						<h3>Postingan #</h3>
					</div>
                    <div class="dataPost">
                        <label for="namaMhs">Nama:</label>
                        <input type="text" id="namaMhs" name="namaMhs">
                    </div>
                    <div class="dataPost">
                        <label for="kelas">Kelas:</label>
                        <input type="text" id="kelas" name="kelas">
                    </div>
                    <div class="dataPost">
                        <label for="post">Isi Postingan:</label>
                        <textarea name="post" id="post"></textarea>
                    </div>
                    <div class="dataPost">
                        <label for="status">Status:</label>
                        <input type="text" id="status" name="status">
                    </div>
                    <div class="dataPost">
                        <input type="submit" name="submit" id="submit">
                    </div>
				</div>
			</div>
            <?php
				include "../layouts/footer.php";
			?>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>