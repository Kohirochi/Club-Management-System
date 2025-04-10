<?php
$student_id = $_SESSION['student_id'];
$joined_club_sql = "SELECT * FROM joined_clubs WHERE Student_ID = '$student_id' AND Club_ID = '$club_id';";
$joined_club_result = $conn->query($joined_club_sql);
$joined_club_row = mysqli_fetch_assoc($joined_club_result);

// Check if the role of member
if ($joined_club_row['Role'] != "Committee") {
    $_SESSION['access'] = false;
    $_SESSION['message'] = "Unauthorized access!";
    mysqli_close($conn);

    header("Location: specific_joined_club.php?club=" . $club_row['Club_name']);
}