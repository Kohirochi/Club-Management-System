<?php
session_start();
include_once "includes/dbh.php";

if (isset($_POST['add'])) {

    // Get data from HTML Form
    $event_name = trim($_POST['event-name']);
    $event_description = trim($_POST['description']);
    $date = trim($_POST['date']);
    $start_time = trim($_POST['start-time']);
    $end_time = trim($_POST['end-time']);
    $link = trim($_POST['link']);
    $club_id = $_SESSION['club_id'];
    $date_posted = date("Y-m-d");
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $sql_query = "INSERT INTO events (Event_name, Description, Date, Start_time, End_time, Link, Date_posted, Approval_status, Event_image, Admin_ID, Club_ID) VALUES ('$event_name', '$event_description', '$date', '$start_time', '$end_time', '$link', '$date_posted', 'Pending', '$image', 1, '$club_id');";
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

    $club_sql_query = "SELECT * FROM clubs WHERE Club_ID = $club_id;";
    $club_result = mysqli_query($conn, $club_sql_query);
    $club_row = mysqli_fetch_assoc($club_result);
}

// Close Database Connection
mysqli_close($conn);

header("Location: club_events.php?club=" . $club_row['Club_name']);