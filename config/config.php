<?php
    $conn = mysqli_connect("localhost", "root", "polindra", "myfess");
    if (!$conn) {
        echo "Database connected" . mysqli_connect_error();
    }
