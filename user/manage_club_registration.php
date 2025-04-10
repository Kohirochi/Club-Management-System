<?php
session_start();
include_once "includes/dbh.php";

$club_id = $_SESSION['club_id'];

if (isset($_POST['register'])) {
    // Requires login in order to register club
    if (!isset($_SESSION['student_id'])) {
        $_SESSION['register'] = false;
        $_SESSION['message'] = "Please login before registering club";
        header("Location: login.php");
    } else {
        $student_id = $_SESSION['student_id'];

        // Check if the student registered the club
        $registration_sql_query = "SELECT * FROM club_registration WHERE Club_ID = '$club_id' AND Student_ID = '$student_id';";
        $registration_result = mysqli_query($conn, $registration_sql_query);
        $registration_check = mysqli_num_rows($registration_result);

        // Check if the student is a member of the club
        $joined_club_sql_query = "SELECT * FROM joined_clubs WHERE Club_ID = '$club_id' AND Student_ID = '$student_id';";
        $joined_club_result = mysqli_query($conn, $joined_club_sql_query);
        $joined_club_check = mysqli_num_rows($joined_club_result);

        if ($registration_check > 0) {
            $_SESSION['register'] = false;
            $_SESSION['message'] = "You have a pending registration.";
        } else if ($joined_club_check > 0) {
            $_SESSION['register'] = false;
            $_SESSION['message'] = "You are already a member of this club.";
        } else {
            $sql_query = "INSERT INTO club_registration (Student_ID, Club_ID, Admin_ID) VALUES ('$student_id', '$club_id', '1')";
            $result = mysqli_query($conn, $sql_query);
            if (mysqli_affected_rows($conn) >= 1) {
                $_SESSION['register'] = true;
                $_SESSION['message'] = "Registered Succesfully";
            }
            if ($result == false) {
                $_SESSION['register'] = false;
                $_SESSION['message'] = "Failed to Registered";
            }
        }

        unset($_SESSION['club_id']);

        $club_sql_query = "SELECT * FROM clubs WHERE Club_ID = '$club_id';";
        $club_result = mysqli_query($conn, $club_sql_query);
        $club_row = mysqli_fetch_assoc($club_result);

        header("Location: specific_club.php?club=" . $club_row['Club_name']);
    }
}

mysqli_close($conn);