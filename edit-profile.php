<?php 
    session_start(); // Memulai session sebelum menggunakan $_SESSION

    if(!isset($_SESSION['unique_id'])) {
        header("location: login.php");
    }
?>

<?php include_once "header.php" ?>
<body>
    <div class="wrapper">
        <section class="navbar-pengaturan">
            <div class="nav-pengaturan">
                <nav>
                    <ul>
                        <li><p>My<span>fess</span></p></li>
                    </ul>
                </nav>
            </div>
        </section>
        <section class="header-profile">
            <header>
                <a href="profile.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <h4>Edit Profile Mahasiswa</h4>
            </header>
        </section>
        <section class="form-isi profile">
            <form action="php/proses-edit.php" method="post" enctype="multipart/form-data">
                <div class="list-daftar">
                    <div class="field input">
                        <label for="prodi">Prodi</label>
                        <select id="pilihProdi" name="pilihProdi"  onchange="updateKelasOptions()">
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
                        <select name="pilihKelas" id="pilihKelas" ></select>
                    </div>
                    <div class="field button">
                        <input type="submit" value="Submit" name="simpan">
                    </div>
                    <?php
                        include_once "php/config.php";
                        $id_user = $_SESSION['unique_id'];
                        echo "<div class='link'>Ganti password? <a href='ganti-password.php?id=".$id_user."'>Klik disini!</a></div>";
                    ?>
                </div>
            </form>
        </section>
        <section class="menu">
            <div class="menu-user">
                <nav>
                    <ul>
                        <li><a href="home.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 20 22" fill="none">
                                <path d="M7.69231 20.2987V15.199C7.69231 14.8425 8.07692 14.4788 8.46154 14.4788H11.5385C11.9231 14.4788 12.3077 14.8425 12.3077 15.2063V20.2987C12.3077 20.4917 12.3887 20.6767 12.533 20.8131C12.6773 20.9496 12.8729 21.0262 13.0769 21.0262H19.2308C19.4348 21.0262 19.6304 20.9496 19.7747 20.8131C19.919 20.6767 20 20.4917 20 20.2987V10.1139C20.0002 10.0183 19.9804 9.92356 19.9419 9.83519C19.9034 9.74681 19.8468 9.66648 19.7754 9.5988L17.6923 7.63021V2.83895C17.6923 2.64601 17.6113 2.46097 17.467 2.32454C17.3227 2.18811 17.1271 2.11146 16.9231 2.11146H15.3846C15.1806 2.11146 14.9849 2.18811 14.8407 2.32454C14.6964 2.46097 14.6154 2.64601 14.6154 2.83895V4.72024L10.5446 0.86891C10.4732 0.801161 10.3883 0.74741 10.2948 0.710735C10.2014 0.67406 10.1012 0.655182 10 0.655182C9.89882 0.655182 9.79863 0.67406 9.70518 0.710735C9.61172 0.74741 9.52684 0.801161 9.45538 0.86891L0.224617 9.5988C0.153229 9.66648 0.0966475 9.74681 0.0581064 9.83519C0.0195653 9.92356 -0.000179307 10.0183 1.22692e-06 10.1139V20.2987C1.22692e-06 20.4917 0.0810449 20.6767 0.225304 20.8131C0.369562 20.9496 0.565219 21.0262 0.769232 21.0262H6.92308C7.12709 21.0262 7.32275 20.9496 7.46701 20.8131C7.61126 20.6767 7.69231 20.4917 7.69231 20.2987Z" fill="#FF0B0B" fill-opacity="0.75"/>
                            </svg>

                            <p>Home</p></a>
                        </li>
                        <li><a href="users.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 20 20" fill="none">
                                <path d="M0 9.56811C0 4.37206 4.36625 0.525421 10 0.525421C15.6337 0.525421 20 4.37206 20 9.56811C20 14.7642 15.6337 18.6108 10 18.6108C8.9875 18.6108 8.0175 18.4861 7.105 18.2531C6.92805 18.2073 6.73959 18.2196 6.57125 18.288L4.58625 19.1061C4.46636 19.1553 4.33532 19.1764 4.20465 19.1675C4.07397 19.1585 3.94766 19.1198 3.83681 19.0546C3.72596 18.9895 3.63397 18.9 3.56892 18.7939C3.50387 18.6879 3.46775 18.5686 3.46375 18.4465L3.40875 16.7883C3.40488 16.6874 3.37906 16.5882 3.33286 16.4969C3.28667 16.4055 3.22105 16.3239 3.14 16.2569C1.195 14.6348 0 12.2856 0 9.56811ZM6.9325 7.86795L3.995 12.2122C3.71375 12.6293 4.2625 13.099 4.68375 12.8018L7.84 10.5691C7.94381 10.4956 8.07047 10.4556 8.20083 10.4552C8.33119 10.4548 8.45815 10.4939 8.5625 10.5668L10.8987 12.2005C11.0645 12.3164 11.2542 12.399 11.4559 12.4431C11.6577 12.4873 11.867 12.492 12.0707 12.4569C12.2745 12.4219 12.4683 12.3479 12.6398 12.2396C12.8114 12.1313 12.957 11.991 13.0675 11.8276L16.005 7.4834C16.2875 7.06622 15.7375 6.59661 15.3163 6.89376L12.16 9.12646C12.0562 9.19997 11.9295 9.23995 11.7992 9.24037C11.6688 9.24079 11.5419 9.20163 11.4375 9.12879L9.10125 7.49389C8.93549 7.378 8.74577 7.29539 8.54406 7.25126C8.34235 7.20712 8.13301 7.20243 7.92926 7.23746C7.7255 7.27249 7.53174 7.3465 7.36018 7.45481C7.18863 7.56312 7.04301 7.70456 6.9325 7.86795Z" fill="black" fill-opacity="0.75"/>
                            </svg>

                            <p>Konsultasi</p></a></li>
                        <li><a href="cerita.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 25 25" fill="none">
                                <g clip-path="url(#clip0_38_23)">
                                    <path d="M12.5 23.4375C9.59919 23.4375 6.8172 22.2852 4.76602 20.234C2.71484 18.1828 1.5625 15.4008 1.5625 12.5C1.5625 9.59919 2.71484 6.8172 4.76602 4.76602C6.8172 2.71484 9.59919 1.5625 12.5 1.5625C15.4008 1.5625 18.1828 2.71484 20.234 4.76602C22.2852 6.8172 23.4375 9.59919 23.4375 12.5C23.4375 15.4008 22.2852 18.1828 20.234 20.234C18.1828 22.2852 15.4008 23.4375 12.5 23.4375ZM12.5 25C15.8152 25 18.9946 23.683 21.3388 21.3388C23.683 18.9946 25 15.8152 25 12.5C25 9.18479 23.683 6.00537 21.3388 3.66117C18.9946 1.31696 15.8152 0 12.5 0C9.18479 0 6.00537 1.31696 3.66117 3.66117C1.31696 6.00537 0 9.18479 0 12.5C0 15.8152 1.31696 18.9946 3.66117 21.3388C6.00537 23.683 9.18479 25 12.5 25Z" fill="black" fill-opacity="0.75"/>
                                    <path d="M12.5 6.25C12.7072 6.25 12.9059 6.33231 13.0524 6.47882C13.1989 6.62534 13.2812 6.82405 13.2812 7.03125V11.7188H17.9688C18.176 11.7188 18.3747 11.8011 18.5212 11.9476C18.6677 12.0941 18.75 12.2928 18.75 12.5C18.75 12.7072 18.6677 12.9059 18.5212 13.0524C18.3747 13.1989 18.176 13.2812 17.9688 13.2812H13.2812V17.9688C13.2812 18.176 13.1989 18.3747 13.0524 18.5212C12.9059 18.6677 12.7072 18.75 12.5 18.75C12.2928 18.75 12.0941 18.6677 11.9476 18.5212C11.8011 18.3747 11.7188 18.176 11.7188 17.9688V13.2812H7.03125C6.82405 13.2812 6.62534 13.1989 6.47882 13.0524C6.33231 12.9059 6.25 12.7072 6.25 12.5C6.25 12.2928 6.33231 12.0941 6.47882 11.9476C6.62534 11.8011 6.82405 11.7188 7.03125 11.7188H11.7188V7.03125C11.7188 6.82405 11.8011 6.62534 11.9476 6.47882C12.0941 6.33231 12.2928 6.25 12.5 6.25Z" fill="black" fill-opacity="0.75"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_38_23">
                                        <rect width="25" height="25" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>


                            <p>Cerita</p></a></li>
                        <li><a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 20 20" fill="none">
                                <path d="M10 20C10.7578 20 11.4845 19.7366 12.0203 19.2678C12.5561 18.799 12.8571 18.1631 12.8571 17.5001H7.14286C7.14286 18.1631 7.44388 18.799 7.97969 19.2678C8.51551 19.7366 9.24224 20 10 20ZM11.4214 1.37477C11.4414 1.20097 11.4195 1.02545 11.3571 0.859513C11.2947 0.693581 11.1933 0.540926 11.0594 0.411394C10.9255 0.281861 10.762 0.178327 10.5795 0.107468C10.3971 0.0366098 10.1996 0 10 0C9.80036 0 9.60295 0.0366098 9.42048 0.107468C9.238 0.178327 9.07453 0.281861 8.9406 0.411394C8.80667 0.540926 8.70526 0.693581 8.64291 0.859513C8.58055 1.02545 8.55863 1.20097 8.57857 1.37477C6.96364 1.66169 5.51176 2.42835 4.46902 3.54481C3.42628 4.66128 2.85681 6.05886 2.85714 7.50068C2.85714 8.87311 2.14286 15.0003 0 16.2502H20C17.8571 15.0003 17.1429 8.87311 17.1429 7.50068C17.1429 4.47585 14.6857 1.95099 11.4214 1.37477Z" fill="black" fill-opacity="0.75"/>
                            </svg>
                            <p>Notifikasi</p></a>
                        </li>
                        <li><a href="setting.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 20 20" fill="none">
                            <g clip-path="url(#clip0_38_18)">
                                <path d="M11.7562 1.97992C11.24 0.292419 8.76 0.292419 8.24375 1.97992L8.11875 2.38974C8.04161 2.64238 7.90682 2.87516 7.72424 3.07102C7.54166 3.26689 7.31594 3.42086 7.06362 3.52165C6.8113 3.62244 6.53878 3.66749 6.26606 3.65351C5.99333 3.63952 5.72731 3.56684 5.4875 3.44081L5.1 3.2359C3.49625 2.39456 1.7425 4.08568 2.61625 5.63095L2.8275 6.00581C3.385 6.99421 2.85625 8.22487 1.7375 8.54309L1.3125 8.66362C-0.4375 9.16144 -0.4375 11.5529 1.3125 12.0507L1.7375 12.1712C1.99949 12.2456 2.2409 12.3756 2.44402 12.5516C2.64713 12.7277 2.80681 12.9454 2.91133 13.1887C3.01585 13.432 3.06258 13.6948 3.04807 13.9577C3.03356 14.2207 2.9582 14.4772 2.8275 14.7085L2.615 15.0822C1.7425 16.6286 3.49625 18.3197 5.09875 17.4772L5.4875 17.2735C5.72731 17.1475 5.99333 17.0748 6.26606 17.0608C6.53878 17.0468 6.8113 17.0919 7.06362 17.1927C7.31594 17.2934 7.54166 17.4474 7.72424 17.6433C7.90682 17.8391 8.04161 18.0719 8.11875 18.3246L8.24375 18.7344C8.76 20.4219 11.24 20.4219 11.7562 18.7344L11.8813 18.3246C11.9584 18.0719 12.0932 17.8391 12.2758 17.6433C12.4583 17.4474 12.6841 17.2934 12.9364 17.1927C13.1887 17.0919 13.4612 17.0468 13.7339 17.0608C14.0067 17.0748 14.2727 17.1475 14.5125 17.2735L14.9 17.4784C16.5037 18.3197 18.2575 16.6286 17.3837 15.0834L17.1725 14.7085C17.0418 14.4772 16.9664 14.2207 16.9519 13.9577C16.9374 13.6948 16.9841 13.432 17.0887 13.1887C17.1932 12.9454 17.3529 12.7277 17.556 12.5516C17.7591 12.3756 18.0005 12.2456 18.2625 12.1712L18.6875 12.0507C20.4375 11.5529 20.4375 9.16144 18.6875 8.66362L18.2625 8.54309C18.0005 8.46871 17.7591 8.33873 17.556 8.16267C17.3529 7.98661 17.1932 7.76895 17.0887 7.52564C16.9841 7.28233 16.9374 7.01955 16.9519 6.75656C16.9664 6.49358 17.0418 6.23706 17.1725 6.00581L17.385 5.63215C18.2575 4.08568 16.5037 2.39456 14.9012 3.23711L14.5125 3.44081C14.2727 3.56684 14.0067 3.63952 13.7339 3.65351C13.4612 3.66749 13.1887 3.62244 12.9364 3.52165C12.6841 3.42086 12.4583 3.26689 12.2758 3.07102C12.0932 2.87516 11.9584 2.64238 11.8813 2.38974L11.7562 1.97992ZM10 13.8888C9.02864 13.8888 8.09707 13.5168 7.41022 12.8544C6.72337 12.1921 6.3375 11.2938 6.3375 10.3572C6.3375 9.42049 6.72337 8.52219 7.41022 7.85987C8.09707 7.19754 9.02864 6.82546 10 6.82546C10.971 6.82546 11.9023 7.19742 12.5889 7.85951C13.2755 8.52161 13.6613 9.4196 13.6613 10.3559C13.6613 11.2923 13.2755 12.1903 12.5889 12.8524C11.9023 13.5145 10.971 13.8864 10 13.8864V13.8888Z" fill="black" fill-opacity="0.75"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_38_18">
                                <rect width="20" height="19.2857" fill="white" transform="translate(0 0.714294)"/>
                                </clipPath>
                            </defs>
                        </svg>
                            <p>Pengaturan</p></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
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