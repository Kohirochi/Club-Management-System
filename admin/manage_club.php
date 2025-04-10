<?php
session_start();
include_once "../user/includes/dbh.php";

// Get data from HTML Form
$club_name = trim($_POST['club-name']);
$email_address = trim($_POST['email-address']);
$contact_number = trim($_POST['contact-number']);
$club_description = trim($_POST['description']);
$day = trim($_POST['day']);
$start_time = trim($_POST['start-time']);
$end_time = trim($_POST['end-time']);
$venue = trim($_POST['venue']);

// Check if email exist or not
$email_sql = "SELECT * FROM (
    SELECT Email FROM admin
    UNION
    SELECT Email FROM students
    UNION
    SELECT Email FROM clubs
    ) AS All_email
    WHERE All_email.Email = '$email_address'";
$result = $conn->query($email_sql);
$result_check = mysqli_num_rows($result);

if ($result_check > 0) {
    $_SESSION['message'] = "Email already exists. Please enter another one.";
    $_SESSION['add'] = false;
    header("Location: admin_clubs.php");
} else {
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $sql_query = "INSERT INTO clubs (Email, Club_name, Contact_number, Description, Day, Start_time, End_time, Venue, Club_image, Admin_ID) VALUES ('$email_address', '$club_name', '$contact_number', '$club_description', '$day', '$start_time', '$end_time', '$venue', '$image', 1);";
    $result = mysqli_query($conn, $sql_query);

    // If database is updated
    if (mysqli_affected_rows($conn) >= 1) {
        $_SESSION['add'] = true;
        $_SESSION['message'] = "Record Added Successfully";
    }

    // If SQL fails to run
    if ($result == false) {
        $_SESSION['add'] = false;
        $_SESSION['message'] = "Failed to Add Record";
    }
}
mysqli_close($conn);

header("Location: admin_clubs.php");