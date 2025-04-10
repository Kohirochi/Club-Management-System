<?php
session_start();
include_once "../user/includes/dbh.php";

if (isset($_POST['check_btn'])) {
    $tp_number = mysqli_real_escape_string($conn, $_POST['input_tp_number']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    if ($action == "edit-student") {
        $id = $_SESSION['get_student_id'];
        $tp_number_sql = "SELECT * FROM (
            SELECT TP_number FROM admin
            UNION
            SELECT TP_number FROM students WHERE Student_ID != '$id'
            ) AS All_tp_number
            WHERE All_tp_number.TP_number = '$tp_number';";
    } else if ($action == "profile-details") {
        $id = $_SESSION['admin_id'];
        $tp_number_sql = "SELECT * FROM (
            SELECT TP_number FROM admin WHERE Admin_ID != '$id'
            UNION
            SELECT TP_number FROM students
            ) AS All_tp_number
            WHERE All_tp_number.TP_number = '$tp_number';";
    } else { // If action is add-student
        $tp_number_sql = "SELECT * FROM (
            SELECT TP_number FROM admin
            UNION
            SELECT TP_number FROM students
            ) AS All_tp_number
            WHERE All_tp_number.TP_number = '$tp_number';";
    }
    $result = $conn->query($tp_number_sql);
    $result_check = mysqli_num_rows($result);
    if ($result_check > 0) {
        echo "TP number already exists. Please enter another one.";
    } else {
        echo "TP number is available.";
    }
}
