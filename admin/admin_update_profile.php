<?php
session_start();
include_once "../user/includes/dbh.php";


if (isset($_POST['update'])) {
    $id = $_SESSION['admin_id'];

    // Get data from HTML Form
    $admin_name = trim($_POST['admin-name']);
    $tp_number = trim($_POST['tp-number']);
    $email_address = trim($_POST['email-address']);
    $password = trim($_POST['password']);
    $contact_number = trim($_POST['contact-number']);

    // Check if email exist or not
    $email_sql = "SELECT * FROM (
                SELECT Email FROM admin WHERE Admin_ID != '$id'
                UNION
                SELECT Email FROM clubs
                UNION
                SELECT Email FROM students 
                ) AS All_email
                WHERE All_email.Email = '$email_address'";
    $email_result = $conn->query($email_sql);
    $email_result_check = mysqli_num_rows($email_result);

    // Check if tp number exist or not
    $tp_number_sql = "SELECT * FROM (
                SELECT TP_number FROM admin WHERE Admin_ID != '$id'
                UNION
                SELECT TP_number FROM students
                ) AS All_tp_number
                WHERE All_tp_number.TP_number = '$tp_number'";
    $tp_number_result = $conn->query($tp_number_sql);
    $tp_number_result_check = mysqli_num_rows($tp_number_result);

    if ($email_result_check > 0) {
        $_SESSION['message'] = "Email already exists. Please enter another one.";
        $_SESSION['update'] = false;
        header("Location: admin_profile.php");
    } else if ($tp_number_result_check > 0) {
        $_SESSION['message'] = "TP number already exists. Please enter another one.";
        $_SESSION['update'] = false;
        header("Location: admin_profile.php");
    } else {
        $update_sql_query = "UPDATE admin SET Admin_name = '$admin_name', TP_number = '$tp_number', Email = '$email_address', Password = '$password', Contact_number = '$contact_number' WHERE Admin_ID = '$id'";

        $update_result = mysqli_query($conn, $update_sql_query);

        // If database is updated
        if (mysqli_affected_rows($conn) >= 1) {
            $_SESSION['message'] = "Record Updated Successfully";
            $_SESSION['update'] = true;
            $_SESSION['admin_email'] = $email_address;
        }

        // If SQL fails to run
        if ($update_result == false) {
            $_SESSION['message'] = "Failed to Update Record";
            $_SESSION['update'] = false;
        }
        header("Location: admin_profile.php");
    }
}
