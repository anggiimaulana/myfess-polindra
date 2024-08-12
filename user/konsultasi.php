<?php 
    session_start(); // Memulai session sebelum menggunakan $_SESSION

    if(!isset($_SESSION['unique_id'])) {
        header("location: ../login.php");
    }
?>

<?php include 'template/head.php' ?>

    <div class="wrapper">
        <?php include 'template/header.php' ?>
        <section class="users">

            <div class="search">
                <span class="text">Cari dan pilih user</span>
                <input type="text" placeholder="Cari nama user">
                <button><i class="fas fa-search"></i></button>
            </div>
            <hr style="margin-bottom: 15px;">
            <div class="users-list">
                <!-- Repeat the above block for more users -->
            </div>
        </section>
        <?php include 'template/menu.php' ?>

    </div>
    <script>
        const searchBar = document.querySelector(".users .search input"),
        searchBtn = document.querySelector(".users .search button"),
        usersList = document.querySelector(".users .users-list");


        searchBtn.onclick = () => {
            searchBar.classList.toggle("active");
            searchBar.focus();
            searchBtn.classList.toggle("active");
            searchBar.value = "";
        }

        searchBar.onkeyup = () => {
            let searchTerm =searchBar.value;
            if(searchTerm != "") {
                searchBar.classList.add("active");
            } else {
                searchBar.classList.remove("active");
            }

            let xhr = new XMLHttpRequest(); //membuat xml objek
            xhr.open("POST", "proses-konsultasi/search.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        let data = xhr.response;
                        // usersList.innerHTML = data;
                        usersList.innerHTML = data;
                    }
                }
            }
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("searchTerm=" + searchTerm);
        }

        setInterval(()=> {
            // ajax
            let xhr = new XMLHttpRequest(); //membuat xml objek
            xhr.open("GET", "proses-konsultasi/users.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        let data = xhr.response;
                        if (!searchBar.classList.contains("active")) {
                            usersList.innerHTML = data;
                        }
                        
                    }
                }
            }
            xhr.send();
        }, 300);

    </script>
</body>
</html>
