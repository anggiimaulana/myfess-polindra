<?php include_once "header.php"?>
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
            <form action="login-register/daftar-admin.php" enctype="multipart/form-data">
                <div class="list-daftar">
                    <div class="error-txt"></div>
                    <div class="field input">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div class="field input">
                        <label for="nip">NIP</label>
                        <input type="number" name="nip" id="nip" placeholder="Masukkan NIP" required>
                    </div>
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"  placeholder="Masukkan Email" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"  placeholder="Masukkan Password" required>
                    </div>
                    <div class="field image">
                        <label for="photo">Masukkan foto</label>
                        <input type="file" name="image" id="photo" required>
                    </div>
                    <div class="field button">
                        <input type="submit" value="Daftar">
                    </div>
                </div>
                <div class="link">Sudah punya akun? <a href="login.php">Login disini!</a></div>
            </form>
        </section>
    </div>
    <script>
        document.querySelector(".form.signup form").onsubmit = function(e) {
            e.preventDefault(); // Prevent form from submitting in the traditional way

            let formData = new FormData(this);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "login-register/daftar-admin.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let response = xhr.responseText;
                    if (response === "success") {
                        window.location.href = "admin/index.php";
                    } else {
                        document.querySelector(".error-txt").textContent = response;
                    }
                }
            };
            xhr.send(formData);
        }
    </script>
</body>
</html>
