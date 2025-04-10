<?php
session_start();
include_once "../user/includes/dbh.php";
if ((isset($_POST['add']))) {
    $club_id = $_SESSION['club_id'];
    $club_sql = "SELECT * FROM clubs WHERE Club_ID = '$club_id';";
    $club_result = mysqli_query($conn, $club_sql);
    $club_row = mysqli_fetch_assoc($club_result);
    $club_name = $club_row['Club_name'];

    // Get data from HTML Form
    $student_id = trim($_POST['student-id']);
    $role = trim($_POST['role']);

    $sql_query = "INSERT INTO joined_clubs (Club_ID, Student_ID, Role) VALUES ('$club_id', '$student_id', '$role');";
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

    mysqli_close($conn);

    header("Location: admin_specific_club.php?club=$club_name #specific-club-member-list");
}