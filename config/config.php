<?php
    $conn = mysqli_connect("localhost", "root", "", "myfess");
    if (!$conn) {
        echo "Database connected" . mysqli_connect_error();
    }