<?php 
    session_start();
    if(!isset($_SESSION['unique_id'])) {
        header("location: ../login.php");
        exit(); 
    }
?>

<?php include 'template/head.php' ?>
<div class="wrapper">
    <?php include 'template/header.php' ?>
    <?php include 'template/konsultasi/index.php' ?>
    <section class="users" id="usersSection">
        <div class="search">
            <span class="text">Cari dan pilih user</span>
            <input type="text" placeholder="Cari nama user">
            <button><i class="fas fa-search"></i></button>
        </div>
        <hr style="margin-bottom: 15px;">
        <div class="users-list">
            <!-- Daftar pengguna -->
        </div>
    </section>
    <?php include 'template/menu.php' ?>
</div>
<script src="javascript/script.js"></script>
</body>
</html>