<?php
session_start();
include_once "../user/includes/dbh.php";

// Admin Account Authentication
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['login'] = false;
    $_SESSION['message'] = "Unauthorized access! Please login to continue";
    header("Location: ../user/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ClubExpress</title>
    <?php
    include_once "includes/links.php";
    include_once "includes/scripts.php";
    ?>
</head>

<body>
    <?php
    include_once "includes/side_nav.php";
    ?>