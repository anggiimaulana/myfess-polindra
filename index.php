<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>
                <div class="intro">
                    <h3>My<span>fess</span></h3>
                    <p>Platform Konseling Mahasiswa Polindra</p>
                </div>
                <div class="daftarkan">
                    <p>Yuk Buat Akun Dulu!</p>
                </div>
            </header>
            <form action="login-register/daftar-user.php" method="POST" enctype="multipart/form-data">
                <div class="list-daftar">
                    <div class="error-txt"></div>
                    <div class="name-details">
                        <div class="field input">
                            <label for="first-name">Nama Depan</label>
                            <input type="text" name="fname" id="first-name" placeholder="Nama Depan" required>
                        </div>
                        <div class="field input">
                            <label for="last-name">Nama Belakang</label>
                            <input type="text" name="lname" id="last-name" placeholder="Nama Belakang" required>
                        </div>
                    </div>
                    <div class="field input">
                        <label for="nim">NIM</label>
                        <input type="number" name="nim" id="nim" placeholder="Masukkan NIM" required>
                    </div>
                    <div class="field input">
                        <label for="prodi">Prodi</label>
                        <select id="pilihanProdi" name="pilihanProdi" onchange="updateKelasOptions()">
                            <option disabled selected>Pilih Prodi</option>
                            <option value="D3 Teknik Mesin">D3 Teknik Mesin</option>
                            <option value="D4 Perancangan Manufaktur">D4 Perancangan Manufaktur</option>
                            <option value="D3 Teknik Pendingin dan Tata Udara">D3 Teknik Pendingin dan Tata Udara</option>
                            <option value="D4 Teknologi Rekayasa Instrumentasi dan Kontrol">D4 Teknologi Rekayasa Instrumentasi dan Kontrol</option>
                            <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                            <option value="D4 Rekayasa Perangkat Lunak">D4 Rekayasa Perangkat Lunak</option>
                            <option value="D4 Sistem Informasi Kota Cerdas">D4 Sistem Informasi Kota Cerdas</option>
                            <option value="D3 Keperawatan">D3 Keperawatan</option>
                        </select>
                    </div>
                    <div class="field input">
                        <label for="kelas">Kelas</label>
                        <select name="pilihanKelas" id="pilihanKelas"></select>
                    </div>
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan Email" required>
                    </div>
                    <div class="field input">
                        <label for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
                    </div>
                    <div class="field image">
                        <label for="photo">Masukkan foto</label>
                        <input type="file" name="image" id="photo" required>
                    </div>
                    <div class="field button">
                        <input type="submit" value="Daftar">
                    </div>
                </div>
            </form>
            <div class="link">Sudah punya akun? <a href="login.php">Login disini!</a></div>
        </section>
    </div>
    <script>
        function updateKelasOptions() {
            var prodi = document.getElementById("pilihanProdi").value;
            var kelasSelect = document.getElementById("pilihanKelas");
            kelasSelect.innerHTML = "";

            var kelasOptions = {
                "D3 Teknik Mesin": ["D3TM1A", "D3TM1B", "D3TM1C", "D3TM2A", "D3TM2B", "D3TM2C", "D3TM3A", "D3TM3B", "D3TM3C"],
                "D4 Perancangan Manufaktur": ["D4PM1A", "D4PM1B", "D4PM1C", "D4PM2A", "D4PM2B", "D4PM2C", "D4PM3A", "D4PM3B", "D4PM3C", "D4PM4A", "D4PM4B", "D4PM4C"],
                "D3 Teknik Pendingin dan Tata Udara": ["D3TP1A", "D3TP1B", "D3TP1C", "D3TP2A", "D3TP2B", "D3TP2C", "D3TP3A", "D3TP3B", "D3TP3C"],
                "D4 Teknologi Rekayasa Instrumentasi dan Kontrol": ["D4TRIK1A"],
                "D3 Teknik Informatika": ["D3TI1A", "D3TI1B", "D3TI1C", "D3TI2A", "D3TI2B", "D3TI2C", "D3TI3A", "D3TI3B", "D3TI3C"],
                "D4 Rekayasa Perangkat Lunak": ["D4RPL1A", "D4RPL1B", "D4RPL1C", "D4RPL2A", "D4RPL2B", "D4RPL2C", "D4RPL3A", "D4RPL3B", "D4RPL3C", "D4RPL4A", "D4RPL4B", "D4RPL4C"],
                "D4 Sistem Informasi Kota Cerdas": ["D4SIKC1A", "D4SIKC1B", "D4SIKC1C", "D4SIKC1D"],
                "D3 Keperawatan": ["D3Kep1A", "D3Kep1B", "D3Kep1C", "D3Kep2A", "D3Kep2B", "D3Kep2C", "D3Kep3A", "D3Kep3B", "D3Kep3C"]
            };

            if (kelasOptions[prodi]) {
                kelasOptions[prodi].forEach(function(kelas) {
                    addOption(kelasSelect, kelas, kelas);
                });
            }
        }

        function addOption(selectElement, text, value) {
            var option = document.createElement("option");
            option.text = text;
            option.value = value;
            selectElement.add(option);
        }

        document.querySelector(".form.signup form").onsubmit = function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "login-register/daftar-user.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let response = xhr.responseText;
                    if (response === "success") {
                        window.location.href = "user/home.php";
                    } else {
                        document.querySelector(".error-txt").textContent = response;
                    }
                } else {
                    document.querySelector(".error-txt").textContent = "Terjadi kesalahan. Silakan coba lagi.";
                }
            };
            xhr.send(formData);
        }
    </script>
</body>
</html>
