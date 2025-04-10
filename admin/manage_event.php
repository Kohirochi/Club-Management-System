<?php
session_start();
include_once "../user/includes/dbh.php";

if (isset($_POST['update']) || (isset($_POST['add']))) {

    // Get data from HTML Form
    $event_name = trim($_POST['event-name']);
    $event_description = trim($_POST['description']);
    $date = trim($_POST['date']);
    $start_time = trim($_POST['start-time']);
    $end_time = trim($_POST['end-time']);
    $link = trim($_POST['link']);
    $approval_status = trim($_POST['approval-status']);
    $club_id = trim($_POST['organizing-club']);
}


if (isset($_POST['update']) || isset($_POST['approve']) || isset($_POST['reject'])) {
    $id = $_SESSION['event_id'];

    if (isset($_POST['approve'])) {
        // Update approval status
        $sql_query = "UPDATE events SET Approval_status = 'Approved' WHERE Event_ID = $id";
    }


    if (isset($_POST['reject'])) {
        // Update approval status
        $sql_query = "UPDATE events SET Approval_status = 'Rejected' WHERE Event_ID = $id";
    }

    if (isset($_POST['update'])) {
        // if no file was uploaded to the event image field
        if (empty($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
            $sql_query = "UPDATE events SET Event_name = '$event_name', Description = '$event_description', Date = '$date', Start_time = '$start_time', End_time = '$end_time', Link = '$link', Approval_status = '$approval_status', Club_ID = '$club_id'  WHERE Event_ID = $id";
        } else {
            // if file was uploaded to the event image field
            $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $sql_query = "UPDATE events SET Event_name = '$event_name', Description = '$event_description', Date = '$date', Start_time = '$start_time', End_time = '$end_time', Link = '$link', Approval_status = '$approval_status', Club_ID = '$club_id', Event_image = '$image' WHERE Event_ID = $id";
        }
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

    unset($_SESSION['event_id']);
}

if (isset($_POST['add'])) {
    $date_posted = date("Y-m-d");

    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $sql_query = "INSERT INTO events (Event_name, Description, Date, Start_time, End_time, Link, Date_posted, Approval_status, Event_image, Admin_ID, Club_ID) VALUES ('$event_name', '$event_description', '$date', '$start_time', '$end_time', '$link', '$date_posted', 'Approved', '$image', 1, '$club_id');";
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

// Close Database Connection
mysqli_close($conn);

header("Location: admin_events.php");