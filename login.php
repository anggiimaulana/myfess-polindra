<?php
    session_start();
    if (isset($_SESSION['unique_id'])) {
        header("location: home.php");
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
                    <label for="nim">NIM atau Username</label>
                    <input type="text" id="nim" name="nim" placeholder="Masukkan NIM atau Username">
                </div>
                <div class="field input">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password">
                    <!-- <i class="fas fa-eye"></i> -->
                </div>
                <div class="field button">
                    <input type="submit" value="Login">
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
            xhr.open("POST", "php/login.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        let data = xhr.response;
                        console.log(data)
                        if(data == "success") {
                            location.href = "home.php";
                        } else {
                            errorText.style.display = "block";
                            errorText.textContent = data;
                            console.log(errorText)
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
