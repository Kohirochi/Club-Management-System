<?php
session_start();
include_once "includes/dbh.php";
$club_id = $_SESSION['club_id'];

if (isset($_POST['update']) || (isset($_POST['add']))) {

    // Get data from HTML Form
    $activity_description = trim($_POST['description']);
    $day = trim($_POST['day']);
    $start_time = trim($_POST['start-time']);
    $end_time = trim($_POST['end-time']);
}


if (isset($_POST['update'])) {
    $id = $_SESSION['club_activity_id'];

    if (isset($_POST['update'])) {
        $sql_query = "UPDATE club_activities SET Description = '$activity_description', Day = '$day', Start_time = '$start_time', End_time = '$end_time' WHERE Club_activities_ID = '$id';";
    }
    $result = mysqli_query($conn, $sql_query);
    // If database is updated
    if (mysqli_affected_rows($conn) >= 1) {
        $_SESSION['update'] = true;
        $_SESSION['message'] = "Record Updated Successfully";
    }

    // If SQL fails to run
    if ($result == false) {
        $_SESSION['update'] = false;
        $_SESSION['message'] = "Failed to Update Record";
    }

    unset($_SESSION['club_activity_id']);
}

if (isset($_POST['add'])) {
    $sql_query = "INSERT INTO club_activities (Description, Day, Start_time, End_time, Club_ID) VALUES ('$activity_description', '$day', '$start_time', '$end_time', '$club_id');";
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

$club_sql = "SELECT * FROM clubs WHERE Club_ID = '$club_id';";
$club_details = $conn->query($club_sql);
$club_row = mysqli_fetch_assoc($club_details);

// Close Database Connection
mysqli_close($conn);

header("Location: club_activities.php?club=" . $club_row['Club_name']);