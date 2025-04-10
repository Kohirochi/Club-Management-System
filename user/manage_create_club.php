<?php
session_start();
include_once "includes/dbh.php";
$id = $_SESSION['student_id'];

// Get data from HTML Form
$club_name = trim($_POST['club-name']);
$email_address = trim($_POST['email-address']);
$club_description = trim($_POST['description']);
$purpose = trim($_POST['purpose']);
$club_contact_number = trim($_POST['club-contact-number']);
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
    $sql_query = "INSERT INTO club_creation (Club_image, Club_name, Club_description, Purpose, Club_email, Club_contact_number, Day, Start_time, End_time, Venue, Admin_ID, Student_ID) VALUES ('$image', '$club_name', '$club_description', '$purpose', '$email_address', '$club_contact_number', '$day', '$start_time', '$end_time', '$venue', 1, '$id');";
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

header("Location: index.php");
