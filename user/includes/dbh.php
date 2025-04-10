<?php
    $db_server_name = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "clubexpress";

    $conn = mysqli_connect($db_server_name, $db_username, $db_password, $db_name);
    if ($conn -> connect_error) {
        die("Connection failed: " . $conn -> connect_error);
    }
?>