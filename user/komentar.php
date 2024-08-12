<?php
session_start();
if(!isset($_SESSION['unique_id'])) {
    header("location: ../login.php");
}
?>

<?php include 'template/head.php' ?>

    <div class="wrapper">
        <section class="komen-area">
            <header>
                <a href="./" class="back-icon">X</a>
                <div class="details">
                    <span>Komentar</span>
                </div>
            </header>
            <div class="komen-box">
                <!-- Komentar akan dimuat di sini -->
            </div>
            <form action="proses/insert_komentar.php" class="typing-area">
                <input type="text" name="id_user_komen" value="<?php echo $_SESSION['unique_id']; ?>" hidden>
                <input type="text" name="post_unique" value="<?php echo isset($_GET['post_unique']) ? $_GET['post_unique'] : ''; ?>" hidden>
                <input type="text" name="isi_komen" class="input-field" placeholder="Ketik komentar disini..">
                <button type="submit"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <script>
        const form = document.querySelector(".typing-area"),
      inputField = form.querySelector(".input-field"),
      sendBtn = form.querySelector("button"),
      komenBox = document.querySelector(".komen-box");

form.onsubmit = (e) => {
    e.preventDefault();
}

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "proses-cerita/insert_komentar.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                inputField.value = "";
                scrollToBottom();
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

komenBox.onmouseenter = () => {
    komenBox.classList.add("active");
}

// komenBox.onmouseleave = () => {
//     komenBox.classList.remove("active");
// }

setInterval(()=> {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "proses-cerita/get_komentar.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let data = xhr.response;
                komenBox.innerHTML = data;
                if (!komenBox.classList.contains("active")) {
                    scrollToBottom();
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}, 300);

function scrollToBottom() {
    if (window.innerWidth > 1000) { // Menambahkan kondisi untuk cek ukuran layar
        komenBox.scrollTop = komenBox.scrollHeight;
    }
}

    </script>
</body>
</html>
