<?php 
    session_start(); // Memulai session sebelum menggunakan $_SESSION

    if(!isset($_SESSION['unique_id'])) {
        header("location: ../login.php");
    }

    $updateStatus = '';
    if (isset($_SESSION['update_status']) && $_SESSION['update_status'] == 'success') {
        $updateStatus = 'success';
        unset($_SESSION['update_status']); // Hapus status setelah ditampilkan
    }
?>

<?php include 'template/head.php' ?>
    <div class="wrapper">
    <?php include 'template/header.php' ?>

        <section class="header-profile">
            
            <header>
                <a href="../setting.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <h4>Profile Mahasiswa</h4>
                <div class="edit-profile-user-container">
                    <?php 
                        include_once "../../config/config.php";
                        $id_user = $_SESSION['unique_id'];  // Mengambil ID pengguna dari sesi
                        echo "<a href='edit-profile.php?id=" . $id_user . "' class='edit-profile-user'>";
                        echo "<svg xmlns='http://www.w3.org/2000/svg' width='25' height='20' viewBox='0 0 100 100' fill='none'>
                            <path d='M96.8875 12.125C97.4714 12.7108 97.7993 13.5041 97.7993 14.3312C97.7993 15.1584 97.4714 15.9517 96.8875 16.5375L90.3687 23.0625L77.8687 10.5625L84.3875 4.0375C84.9735 3.45165 85.7682 3.12254 86.5969 3.12254C87.4255 3.12254 88.2202 3.45165 88.8062 4.0375L96.8875 12.1188V12.125ZM85.95 27.475L73.45 14.975L30.8688 57.5625C30.5248 57.9064 30.2658 58.3259 30.1125 58.7875L25.0812 73.875C24.99 74.15 24.977 74.4451 25.0438 74.7271C25.1106 75.009 25.2545 75.2669 25.4594 75.4718C25.6643 75.6767 25.9222 75.8206 26.2042 75.8874C26.4862 75.9542 26.7812 75.9412 27.0562 75.85L42.1437 70.8187C42.6048 70.6673 43.0242 70.4105 43.3688 70.0688L85.95 27.475Z' fill='#000000'/>
                            <path fill-rule='evenodd' clip-rule='evenodd' d='M6.25 84.375C6.25 86.8614 7.23772 89.246 8.99587 91.0041C10.754 92.7623 13.1386 93.75 15.625 93.75H84.375C86.8614 93.75 89.246 92.7623 91.0041 91.0041C92.7623 89.246 93.75 86.8614 93.75 84.375V46.875C93.75 46.0462 93.4208 45.2513 92.8347 44.6653C92.2487 44.0792 91.4538 43.75 90.625 43.75C89.7962 43.75 89.0013 44.0792 88.4153 44.6653C87.8292 45.2513 87.5 46.0462 87.5 46.875V84.375C87.5 85.2038 87.1708 85.9987 86.5847 86.5847C85.9987 87.1708 85.2038 87.5 84.375 87.5H15.625C14.7962 87.5 14.0013 87.1708 13.4153 86.5847C12.8292 85.9987 12.5 85.2038 12.5 84.375V15.625C12.5 14.7962 12.8292 14.0013 13.4153 13.4153C14.0013 12.8292 14.7962 12.5 15.625 12.5H56.25C57.0788 12.5 57.8737 12.1708 58.4597 11.5847C59.0458 10.9987 59.375 10.2038 59.375 9.375C59.375 8.5462 59.0458 7.75134 58.4597 7.16529C57.8737 6.57924 57.0788 6.25 56.25 6.25H15.625C13.1386 6.25 10.754 7.23772 8.99587 8.99587C7.23772 10.754 6.25 13.1386 6.25 15.625V84.375Z' fill='#000000'/>
                            </svg>";
                        echo "</a>";
                    ?>
                    <!-- <div class="edit-profile-user-text">Edit Profile User</div> -->
                </div>
            </header>
        </section>
        <section class="form-isi profile">
            <form action="#" enctype="multipart/form-data">
                <?php 
                include_once "../../config/config.php";

                $user_id = $_SESSION['unique_id'];  // Mengambil ID pengguna dari sesi

                // Menggunakan prepared statement untuk mencegah SQL Injection
                $stmt = $conn->prepare("SELECT * FROM users WHERE unique_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    echo "<div class='list-daftar'>";
                        echo "<div class='name-details'>";
                            echo "<img src='../images/" . htmlspecialchars($row["img"]) . "' alt='' class='thumbnail' style='width: 90px; height: 90px; margin-right: auto; margin-left: auto; display: block; margin-bottom: 15px; cursor: pointer' loading='lazy'>";
                        echo "</div>";
                        echo "<div class='name-details'>";
                            echo "<div class='field input'>";
                                echo "<label for='first-name'>Nama Depan</label>";
                                echo "<input type='text' name='fname' id='first-name' value='" . htmlspecialchars($row['fname']) . "' disabled>";
                            echo "</div>";
                            echo "<div class='field input'>";
                                echo "<label for='last-name'>Nama Belakang</label>";
                                echo "<input type='text' name='lname' id='last-name' value='" . htmlspecialchars($row['lname']) . "' disabled>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='field input'>";
                            echo "<label for='nim'>NIM</label>";
                            echo "<input type='number' name='nim' id='nim' value='" . htmlspecialchars($row['nim']) . "' disabled>";
                        echo "</div>";
                        echo "<div class='field input'>";
                            echo "<label for='prodi'>Prodi</label>";
                            echo "<input type='text' name='prodi' value='" . htmlspecialchars($row['prodi']) . "' disabled>";
                        echo "</div>";
                        echo "<div class='field input'>";
                            echo "<label for='kelas'>Kelas</label>";
                            echo "<input type='text' name='kelas' value='" . htmlspecialchars($row['kelas']) . "' disabled>";
                        echo "</div>";
                        echo "<div class='field input'>";
                            echo "<label for='email'>Email</label>";
                            echo "<input class='ini_email' type='email' name='email' id='email' value='" . htmlspecialchars($row['email']) . "' disabled >";
                        echo "</div>";
                    echo "</div>";
                } else {
                echo "Tidak ada data pengguna ditemukan.";
                }
                $stmt->close();
                $conn->close();
            ?>
            </form>

            <!-- Modal structure -->
            <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
                <div id="caption"></div>
            </div>

            <!-- CSS for modal -->
            <style>
            .modal {
                display: none; 
                position: fixed; 
                z-index: 1; 
                padding-top: 100px; 
                left: 0;
                top: 0;
                width: 100%; 
                height: 100%; 
                overflow: auto; 
                background-color: rgb(0,0,0); 
                background-color: rgba(0,0,0,0.9); 
                cursor: pointer;
            }

            .modal-content {
                margin: auto;
                display: block;
                width: 45%;
                max-width: 400px;
            }

            @media screen and (max-width: 450px) {
                .modal-content {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
            }
            }

            #caption {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
                text-align: center;
                color: #ccc;
                padding: 10px 0;
                height: 150px;
            }

            .modal-content, #caption {  
                animation-name: zoom;
                animation-duration: 0.6s;
            }

            @keyframes zoom {
                from {transform: scale(0)} 
                to {transform: scale(1)}
            }

            .close {
                position: absolute;
                top: 15px;
                right: 35px;
                color: #f1f1f1;
                font-size: 40px;
                font-weight: bold;
                transition: 0.3s;
            }

            .close:hover,
            .close:focus {
                color: #bbb;
                text-decoration: none;
                cursor: pointer;
            }
            </style>

        </section>
        <?php include 'template/menu.php' ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var updateStatus = '<?php echo $updateStatus; ?>';
            if (updateStatus === 'success') {
                alert('Data berhasil diperbarui');
            }
        });
        
        // <!-- JavaScript for modal -->
        document.addEventListener('DOMContentLoaded', (event) => {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");

            document.querySelectorAll('.thumbnail').forEach(img => {
                img.onclick = function(){
                    modal.style.display = "block";
                    modal.style.cursor = "pointer";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;
                }
            });

            var span = document.getElementsByClassName("close")[0];
            span.onclick = function() { 
                modal.style.display = "none";
            }
        });
    </script>
</body>
</html>