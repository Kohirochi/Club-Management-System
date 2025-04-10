<?php
session_start();
include_once "./includes/dbh.php";

$club_id = $_SESSION['club_id'];
$club_registration_id = $_SESSION['club_registration_id'];

if (isset($_POST['approve'])) {

    // Insert member data into Joined Club table
    $join_club_sql_query = "INSERT INTO joined_clubs (Student_ID, Club_ID, Role)
        SELECT Student_ID, Club_ID, 'Member'
        FROM `club_registration`
        WHERE `Club_registration_ID` = $club_registration_id;";

    $join_club_result = mysqli_query($conn, $join_club_sql_query);

    // If member added successfully
    if (mysqli_affected_rows($conn) >= 1) {
        $delete_sql_query = "DELETE FROM club_registration WHERE Club_registration_ID = $club_registration_id;";
        $delete_result = mysqli_query($conn, $delete_sql_query);

        $_SESSION['add'] = true;
        $_SESSION['message'] = "Student Successfully Added as Member";
    }

    // If Joined Club SQL fails to run
    if ($join_club_result  == false) {
        $_SESSION['add'] = false;
        $_SESSION['message'] = "Failed to Add Student as Member";
    }
}

if (isset($_POST['reject'])) {
    $delete_sql_query = "DELETE FROM club_registration WHERE Club_registration_ID = $club_registration_id;";
    $delete_result = mysqli_query($conn, $delete_sql_query);

    // If a new club is created
    if (mysqli_affected_rows($conn) >= 1) {
        $_SESSION['delete'] = true;
        $_SESSION['message'] = "Club Registration Request Rejected Successfully";
    }

    // If Joined Club SQL fails to run
    if ($delete_result  == false) {
        $_SESSION['delete'] = false;
        $_SESSION['message'] = "Failed to Reject Club Registration Request";
    }
}

$club_sql_query = "SELECT * FROM clubs WHERE Club_ID = $club_id;";
$club_result = mysqli_query($conn, $club_sql_query);
$club_row = mysqli_fetch_assoc($club_result);

// Close Database Connection
mysqli_close($conn);

header("Location: club_registrations.php?club=" . $club_row['Club_name']);