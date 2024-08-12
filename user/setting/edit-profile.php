<?php 
session_start(); // Memulai session sebelum menggunakan $_SESSION

if(!isset($_SESSION['unique_id'])) {
    header("location: ../../login.php");
    exit();
}

include_once "../../config/config.php"; // Menghubungkan ke database

// Mengambil unique_id dari session
$unique_id = $_SESSION['unique_id'];

// Query untuk mengambil data dari tabel users
$sql = "SELECT * FROM users WHERE unique_id = '$unique_id'";
$result = mysqli_query($conn, $sql);

// Memeriksa apakah data ditemukan
if($result && mysqli_num_rows($result) > 0) {
    // Menampilkan data user
    $user = mysqli_fetch_assoc($result);
    $prodi = $user['prodi'];
    $kelas = $user['kelas'];
    $fname = $user['fname'];
    $lname = $user['lname'];
    $nim = $user['nim'];
    $email = $user['email'];
    // Ambil data lain yang ingin ditampilkan
} else {
    echo "Data tidak ditemukan.";
}

?>

<?php include 'template/head.php' ?>

<div class="wrapper">
    <?php include 'template/header.php' ?>

    <section class="header-profile">
        <header>
            <a href="profile.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <h4>Edit Profile Mahasiswa</h4>
        </header>
    </section>
    <section class="form-isi profile">
        <form action="../proses-setting/proses-edit.php" method="post" enctype="multipart/form-data">
            <div class="list-daftar">
                <div class="name-details">
                    <div class="field input">
                        <label for="first-name">Nama Depan</label>
                        <input type="text" name="fname" id="first-name" value="<?= $fname ?>" required>
                    </div>
                    <div class="field input">
                        <label for="last-name">Nama Belakang</label>
                        <input type="text" name="lname" id="last-name" value="<?= $lname ?>" required>
                    </div>
                </div>
                <div class="field input">
                        <label for="nim">NIM</label>
                        <input type="number" name="nim" id="nim" value="<?= $nim ?>" required>
                </div>
                <div class="field input">
                    <label for="prodi">Prodi</label>
                    <select id="pilihProdi" name="pilihProdi" onchange="updateKelasOptions()">
                        <option disabled selected>Pilih Prodi</option>
                        <option value="D3 Teknik Mesin" <?= $prodi == 'D3 Teknik Mesin' ? 'selected' : '' ?>>D3 Teknik Mesin</option>
                        <option value="D4 Perancangan Manufaktur" <?= $prodi == 'D4 Perancangan Manufaktur' ? 'selected' : '' ?>>D4 Perancangan Manufaktur</option>
                        <option value="D3 Teknik Pendingin dan Tata Udara" <?= $prodi == 'D3 Teknik Pendingin dan Tata Udara' ? 'selected' : '' ?>>D3 Teknik Pendingin dan Tata Udara</option>
                        <option value="D4 Teknologi Rekayasa Instrumentasi dan Kontrol" <?= $prodi == 'D4 Teknologi Rekayasa Instrumentasi dan Kontrol' ? 'selected' : '' ?>>D4 Teknologi Rekayasa Instrumentasi dan Kontrol</option>
                        <option value="D3 Teknik Informatika" <?= $prodi == 'D3 Teknik Informatika' ? 'selected' : '' ?>>D3 Teknik Informatika</option>
                        <option value="D4 Rekayasa Perangkat Lunak" <?= $prodi == 'D4 Rekayasa Perangkat Lunak' ? 'selected' : '' ?>>D4 Rekayasa Perangkat Lunak</option>
                        <option value="D4 Sistem Informasi Kota Cerdas" <?= $prodi == 'D4 Sistem Informasi Kota Cerdas' ? 'selected' : '' ?>>D4 Sistem Informasi Kota Cerdas</option>
                        <option value="D3 Keperawatan" <?= $prodi == 'D3 Keperawatan' ? 'selected' : '' ?>>D3 Keperawatan</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="kelas">Kelas</label>
                    <select name="pilihKelas" id="pilihKelas">
                        <option value="<?= $kelas ?>" selected><?= $kelas ?></option>
                    </select>
                </div>
                <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $email ?>"required>
                    </div>
                    <div class="field image">
                        <label for="photo">Masukkan foto baru (opsional)</label>
                        <input type="file" name="image" id="photo">
                    </div>
                <div class="field button">
                    <input type="submit" value="Submit" name="simpan">
                </div>
                <?php
                    echo "<div class='link'>Ganti password? <a href='ganti-password.php?id=".$unique_id."'>Klik disini!</a></div>";
                ?>
                <div class="link">Cek Khodam? <a href="https://anggiimaulana.github.io/cek-khodam/" target="_blank">Klik disini</a></div>
            </div>
        </form>
    </section>
    <?php include 'template/menu.php' ?>
</div>

    <script>
        function updateKelasOptions() {
            var prodi = document.getElementById("pilihProdi").value;
            var kelasSelect = document.getElementById("pilihKelas");
            kelasSelect.innerHTML = "";

            if (prodi === "D3 Teknik Mesin") {
                addOption(kelasSelect, "D3TM1A", "D3TM1A");
                addOption(kelasSelect, "D3TM1B", "D3TM1B");
                addOption(kelasSelect, "D3TM1C", "D3TM1C");
                addOption(kelasSelect, "D3TM2A", "D3TM2A");
                addOption(kelasSelect, "D3TM2B", "D3TM2B");
                addOption(kelasSelect, "D3TM2C", "D3TM2C");
                addOption(kelasSelect, "D3TM3A", "D3TM3A");
                addOption(kelasSelect, "D3TM3B", "D3TM3B");
                addOption(kelasSelect, "D3TM3C", "D3TM3C");
            } else if (prodi === "D4 Perancangan Manufaktur") {
                addOption(kelasSelect, "D4PM1A", "D4PM1A");
                addOption(kelasSelect, "D4PM1B", "D4PM1B");
                addOption(kelasSelect, "D4PM1C", "D4PM1C");
                addOption(kelasSelect, "D4PM2A", "D4PM2A");
                addOption(kelasSelect, "D4PM2B", "D4PM2B");
                addOption(kelasSelect, "D4PM2C", "D4PM2C");
                addOption(kelasSelect, "D4PM3A", "D4PM3A");
                addOption(kelasSelect, "D4PM3B", "D4PM3B");
                addOption(kelasSelect, "D4PM3C", "D4PM3C");
                addOption(kelasSelect, "D4PM4A", "D4PM4A");
                addOption(kelasSelect, "D4PM4B", "D4PM4B");
                addOption(kelasSelect, "D4PM4C", "D4PM4C");
            } else if (prodi === "D3 Teknik Pendingin dan Tata Udara") {
                addOption(kelasSelect, "D3TP1A", "D3TP1A");
                addOption(kelasSelect, "D3TP1B", "D3TP1B");
                addOption(kelasSelect, "D3TP1C", "D3TP1C");
                addOption(kelasSelect, "D3TP2A", "D3TP2A");
                addOption(kelasSelect, "D3TP2B", "D3TP2B");
                addOption(kelasSelect, "D3TP2C", "D3TP2C");
                addOption(kelasSelect, "D3TP3A", "D3TP3A");
                addOption(kelasSelect, "D3TP3B", "D3TP3B");
                addOption(kelasSelect, "D3TP3C", "D3TP3C");
            } else if (prodi === "D4 Teknologi Rekayasa Instrumentasi dan Kontrol") {
                addOption(kelasSelect, "D4TRIK1A", "D4TRIK1A");
                addOption(kelasSelect, "D4TRIK2A", "D4TRIK2A");
            } else if (prodi === "D3 Teknik Informatika") {
                addOption(kelasSelect, "D3TI1A", "D3TI1A");
                addOption(kelasSelect, "D3TI1B", "D3TI1B");
                addOption(kelasSelect, "D3TI1C", "D3TI1C");
                addOption(kelasSelect, "D3TI2A", "D3TI2A");
                addOption(kelasSelect, "D3TI2B", "D3TI2B");
                addOption(kelasSelect, "D3TI2C", "D3TI2C");
                addOption(kelasSelect, "D3TI3A", "D3TI3A");
                addOption(kelasSelect, "D3TI3B", "D3TI3B");
                addOption(kelasSelect, "D3TI3C", "D3TI3C");
            } else if (prodi === "D4 Rekayasa Perangkat Lunak") {
                addOption(kelasSelect, "D4RPL1A", "D4RPL1A");
                addOption(kelasSelect, "D4RPL1B", "D4RPL1B");
                addOption(kelasSelect, "D4RPL1C", "D4RPL1C");
                addOption(kelasSelect, "D4RPL2A", "D4RPL2A");
                addOption(kelasSelect, "D4RPL2B", "D4RPL2B");
                addOption(kelasSelect, "D4RPL2C", "D4RPL2C");
                addOption(kelasSelect, "D4RPL3A", "D4RPL3A");
                addOption(kelasSelect, "D4RPL3B", "D4RPL3B");
                addOption(kelasSelect, "D4RPL3C", "D4RPL3C");
                addOption(kelasSelect, "D4RPL4A", "D4RPL4A");
                addOption(kelasSelect, "D4RPL4B", "D4RPL4B");
                addOption(kelasSelect, "D4RPL4C", "D4RPL4C");
            } else if (prodi === "D4 Sistem Informasi Kota Cerdas") {
                addOption(kelasSelect, "D4SIKC1A", "D4SIKC1A");
                addOption(kelasSelect, "D4SIKC1B", "D4SIKC1B");
                addOption(kelasSelect, "D4SIKC1C", "D4SIKC1C");
                addOption(kelasSelect, "D4SIKC1D", "D4SIKC1D");
                addOption(kelasSelect, "D4SIKC2A", "D4SIKC2A");
                addOption(kelasSelect, "D4SIKC2B", "D4SIKC2B");
                addOption(kelasSelect, "D4SIKC2C", "D4SIKC2C");
                addOption(kelasSelect, "D4SIKC2D", "D4SIKC2D");
            } else if (prodi === "D3 Keperawatan") {
                addOption(kelasSelect, "D3Kep1A", "D3Kep1A");
                addOption(kelasSelect, "D3Kep1B", "D3Kep1B");
                addOption(kelasSelect, "D3Kep1C", "D3Kep1C");
                addOption(kelasSelect, "D3Kep2A", "D3Kep2A");
                addOption(kelasSelect, "D3Kep2B", "D3Kep2B");
                addOption(kelasSelect, "D3Kep2C", "D3Kep2C");
                addOption(kelasSelect, "D3Kep3A", "D3Kep3A");
                addOption(kelasSelect, "D3Kep3B", "D3Kep3B");
                addOption(kelasSelect, "D3Kep3C", "D3Kep3C");
            }
        }

        function addOption(selectElement, text, value) {
            var option = document.createElement("option");
            option.text = text;
            option.value = value;
            selectElement.add(option);
        }

    </script>
</body>
</html>