<?php
session_start();
include_once "includes/dbh.php";

if (isset($_POST['login-btn'])) {
    $tp_number = mysqli_real_escape_string($conn, $_POST['tp-number']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $is_admin_tp_sql = "SELECT * FROM admin WHERE TP_number = '$tp_number';";
    $is_student_tp_sql = "SELECT * FROM students WHERE TP_number = '$tp_number';";
    $admin_result = $conn->query($is_admin_tp_sql);
    $admin_result_check = mysqli_num_rows($admin_result);
    $student_result = $conn->query($is_student_tp_sql);
    $student_result_check = mysqli_num_rows($student_result);

    if ($admin_result_check > 0) {
        // Admin Login
        $row = mysqli_fetch_assoc($admin_result);
        if ($row['Password'] == $password) {
            $_SESSION['message'] = "Welcome back";
            $_SESSION['login'] = true;
            $_SESSION['admin_id'] = $row['Admin_ID'];
            header("Location: ../admin/admin.php");
        } else {
            $_SESSION['message'] = "Wrong password";
            $_SESSION['login'] = false;
            header("Location: ./login.php");
        }
    } else if ($student_result_check > 0) {
        // Student Login
        $row = mysqli_fetch_assoc($student_result);
        if ($row['Password'] == $password) {
            $_SESSION['message'] = "Welcome to ClubExpress";
            $_SESSION['login'] = true;
            $_SESSION['student_id'] = $row['Student_ID'];
            header("Location: ./index.php");
        } else {
            $_SESSION['message'] = "Wrong password";
            $_SESSION['login'] = false;
            header("Location: ./login.php");
        }
    } else {
        $_SESSION['message'] = "TP Number is not found";
        $_SESSION['login'] = false;
        header("Location: ./login.php");
    }
}

mysqli_close($conn);
