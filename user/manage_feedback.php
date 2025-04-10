<?php
session_start();
include_once "includes/dbh.php";
$club_id = $_SESSION['club_id'];
$club_details_sql = "SELECT * FROM clubs WHERE Club_ID = '$club_id';";
$club_details_result = $conn->query($club_details_sql);
$club_row = mysqli_fetch_assoc($club_details_result);

// Get data from HTML Form
$comment = trim($_POST['comment']);

$sql_query = "INSERT INTO club_feedback (Comment, Club_ID) VALUES ('$comment', '$club_id');";
$result = mysqli_query($conn, $sql_query);

// If database is updated
if (mysqli_affected_rows($conn) >= 1) {
    $_SESSION['add'] = true;
    $_SESSION['message'] = "Feedback Sent Successfully";
}

// If SQL fails to run
if ($result == false) {
    $_SESSION['add'] = false;
    $_SESSION['message'] = "Failed to Send Feedback";
}
mysqli_close($conn);

header("Location: specific_joined_club.php?club=" . $club_row['Club_name']);