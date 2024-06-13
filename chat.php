<?php
    session_start();
    if(!isset($_SESSION['unique_id'])) {
        header("location: login.php");
    }
?>

<?php include_once "header.php"?> 
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php
                    include_once "php/config.php";
                    $user_id = mysqli_real_escape_string($conn,$_GET['user_id']);
                    include_once "php/config.php";
                    $sql = mysqli_query($conn, "SELECT  * from users where unique_id = {$user_id}");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['img']?>" alt="">
                <div class="details">
                    <span><?php echo $row['fname'] . " " . $row['lname']?></span>
                    <p><?php echo $row['status']?></p>
                </div>
            </header>
            <div class="chat-box">
                
            </div>
            <form action="#" class="typing-area">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id'];?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $user_id;?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Ketik pesan disini..">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <script>
        const form = document.querySelector(".typing-area"),
        inputField = form.querySelector(".input-field"),
        sendBtn = form.querySelector("button"),
        chatBox = document.querySelector(".chat-box");

        form.onsubmit = (e) => {
            e.preventDefault();
        }

        sendBtn.onclick = () => {
            let xhr = new XMLHttpRequest(); //membuat xml objek
            xhr.open("POST", "php/insert-chat.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        inputField.value = "";
                        scrollToBottom();
                    }
                }
            }
            // send data menggunakan ajax ke php
            let formData = new FormData(form);
            xhr.send(formData);

        }

        chatBox.onmouseenter = () => {
            chatBox.classList.add("active");
        }

        chatBox.onmouseleave = () => {
            chatBox.classList.remove("active");
        }

        setInterval(()=> {
            // ajax
            let xhr = new XMLHttpRequest(); //membuat xml objek
            xhr.open("POST", "php/get-chat.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        let data = xhr.response;
                        chatBox.innerHTML = data;
                        if (!chatBox.classList.contains("active")) {
                            scrollToBottom();
                        }
                    }
                }
            }
            // send data menggunakan ajax ke php
            let formData = new FormData(form);
            xhr.send(formData);
        }, 500);

        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
</body>
</html>
