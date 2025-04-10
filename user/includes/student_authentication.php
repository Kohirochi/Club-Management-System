<?php
if (!isset($_SESSION['student_id'])) {
    $_SESSION['login'] = false;
    $_SESSION['message'] = "Unauthorized access! Please login to continue";
    header("Location: login.php");
}