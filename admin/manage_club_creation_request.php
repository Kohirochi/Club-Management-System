<?php
session_start();
include_once "../user/includes/dbh.php";

$club_creation_id = $_SESSION['club_creation_id'];

if (isset($_POST['approve'])) {

    // Insert club data into Clubs table
    $club_sql_query = "INSERT INTO clubs (Email, Club_name, Contact_number, Description, Day, Start_time, End_time, Venue, Club_image, Admin_ID)
        SELECT Club_email, Club_name, Club_contact_number, Club_description, Day, Start_time, End_time, Venue, Club_image, 1
        FROM `club_creation`
        WHERE `Club_creation_ID` = $club_creation_id;";

    $club_result = mysqli_query($conn, $club_sql_query);

    // If a new club is created
    if (mysqli_affected_rows($conn) >= 1) {

        // Update joined club table with new committee when a new club is created
        $joined_club_sql_query = "INSERT INTO joined_clubs (Student_ID, Club_ID, Role)
            SELECT Student_ID, (SELECT Club_ID FROM `clubs` WHERE `Email` = (SELECT Club_email FROM `club_creation` WHERE `Club_creation_ID` = $club_creation_id)), 'Committee'
            FROM `club_creation`
            WHERE `Club_creation_ID` = $club_creation_id;";

        $joined_club_result = mysqli_query($conn, $joined_club_sql_query);

        // If joined club table is updated successfully
        if (mysqli_affected_rows($conn) >= 1) {
            $_SESSION['add'] = true;
            $_SESSION['message'] = "Record Added Successfully";
        }

        // If Joined Club SQL fails to run
        if ($joined_club_result  == false) {
            $_SESSION['add'] = false;
            $_SESSION['message'] = "Failed to Add Record into Joined Clubs Table";
        }
    }

    // If Club SQL fails to run
    if ($club_result  == false) {
        $_SESSION['add'] = false;
        $_SESSION['message'] = "Failed to Add Record into Clubs Table";
    }
}

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $delete_sql_query = "DELETE FROM club_creation WHERE Club_creation_ID = $club_creation_id;";
    $delete_result = mysqli_query($conn, $delete_sql_query);

    // Close Database Connection
    mysqli_close($conn);

    header("Location: admin_club_creation_requests.php");
}