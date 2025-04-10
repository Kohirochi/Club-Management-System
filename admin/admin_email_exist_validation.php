<?php
session_start();
include_once "../user/includes/dbh.php";

if (isset($_POST['check_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['input_email']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    if ($action == "edit-student") {
        $id = $_SESSION['get_student_id'];
        $email_sql = "SELECT * FROM (
            SELECT Email FROM admin
            UNION
            SELECT Email FROM clubs 
            UNION
            SELECT Email FROM students WHERE Student_ID != '$id'
            ) AS All_email
            WHERE All_email.Email = '$email';";
    } else if ($action == "edit-club") {
        $id = $_SESSION['club_id'];
        $email_sql = "SELECT * FROM (
            SELECT Email FROM admin
            UNION
            SELECT Email FROM clubs WHERE Club_ID != '$id'
            UNION
            SELECT Email FROM students
            ) AS All_email
            WHERE All_email.Email = '$email';";
    } else if ($action == "profile-details") {
        $id = $_SESSION['admin_id'];
        $email_sql = "SELECT * FROM (
            SELECT Email FROM admin WHERE Admin_ID != '$id'
            UNION
            SELECT Email FROM clubs 
            UNION
            SELECT Email FROM students
            ) AS All_email
            WHERE All_email.Email = '$email';";
    } else { // If action is add-club or add-student
        $email_sql = "SELECT * FROM (
            SELECT Email FROM admin
            UNION
            SELECT Email FROM clubs
            UNION
            SELECT Email FROM students
            ) AS All_email
            WHERE All_email.Email = '$email';";
    }
    $result = $conn->query($email_sql);
    $result_check = mysqli_num_rows($result);
    if ($result_check > 0) {
        echo "Email already exists. Please enter another one.";
    } else {
        echo "Email is available.";
    }
}
