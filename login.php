<?php
session_start();
include_once "config/config.php";

if (isset($_SESSION['unique_id'])) {
    // Cek apakah pengguna adalah admin atau mahasiswa
    $unique_id = $_SESSION['unique_id'];

    // Query untuk memeriksa apakah pengguna adalah admin
    $admin_check_sql = mysqli_query($conn, "SELECT * FROM admin WHERE unique_id = '{$unique_id}'");
    if (mysqli_num_rows($admin_check_sql) > 0) {
        // Jika pengguna adalah admin
        header("Location: ../admin/index.php");
        exit();
    }

    // Query untuk memeriksa apakah pengguna adalah mahasiswa
    $user_check_sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
    if (mysqli_num_rows($user_check_sql) > 0) {
        // Jika pengguna adalah mahasiswa
        header("Location: ../user/home.php");
        exit();
    }
}
?>
<?php include_once "header.php"?>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>
                <div class="intro">
                    <h3>My<span>fess</span></h3>
                    <p>Platform Konseling Mahasiswa Polindra</p>
                </div>
                <div class="daftarkan">
                    <p>Yuk Login Dulu!</p>
                </div>
            </header>
            <form action="#">
                <div class="error-txt"></div>
                <div class="field input">
                    <label for="identifier">NIM atau NIP</label>
                    <input type="text" id="identifier" name="identifier" placeholder="Masukkan NIM atau NIP" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>
                <div class="field button">
                    <input type="submit" value="Login" class="rotate-on-hover">
                </div>
            </form>
            <div class="link">Belum punya akun? <a href="index.php">Daftar disini!</a></div>
        </section>
    </div>

    <script>
        const form = document.querySelector(".login form"),
            continueBtn = form.querySelector(".button input"),
            errorText = form.querySelector(".error-txt");

        form.onsubmit = (e) => {
            e.preventDefault();
        }

        continueBtn.onclick = () => {
            // ajax
            let xhr = new XMLHttpRequest(); //membuat xml objek
            xhr.open("POST", "login-register/login.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if (data === "mahasiswa_success") {
                            location.href = "user/";
                        } else if (data === "admin_success") {
                            location.href = "admin/";
                        } else {
                            errorText.style.display = "block";
                            errorText.textContent = data;
                        }
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
        }
    </script>
</body>
</html>
