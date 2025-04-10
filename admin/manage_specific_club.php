<?php
session_start();
include_once "../user/includes/dbh.php";

$id = $_SESSION['club_id'];
if (isset($_POST['delete'])) {
    $club_sql_query = "SELECT * FROM clubs WHERE Club_ID = $id;";
    $club_result = mysqli_query($conn, $club_sql_query);
    $row = mysqli_fetch_assoc($club_result);
    $club_name = $row['Club_name'];

    $delete_sql_query = "DELETE FROM clubs WHERE Club_ID = $id;";
    $delete_result = mysqli_query($conn, $delete_sql_query);
    if (mysqli_affected_rows($conn) >= 1) {
        $_SESSION['message'] = "Record Deleted Successfully";
        $_SESSION['delete'] = true;

        unset($_SESSION['club_id']);
        header("Location: admin_clubs.php");
    } else {
        $_SESSION['message'] = "Failed to Delete Record";
        $_SESSION['delete'] = false;

        header("Location: admin_specific_club.php?club=" . $club_name);
    }
}

if (isset($_POST['update'])) {

    // Get data from HTML Form
    $club_name = trim($_POST['club-name']);
    $email_address = trim($_POST['email-address']);
    $contact_number = trim($_POST['contact-number']);
    $club_description = trim($_POST['description']);
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
        SELECT Email FROM clubs WHERE Club_ID != '$id'
        ) AS All_email
        WHERE All_email.Email = '$email_address'";
    $result = $conn->query($email_sql);
    $result_check = mysqli_num_rows($result);

    if ($result_check > 0) {
        $_SESSION['message'] = "Email already exists. Please enter another one.";
        $_SESSION['update'] = false;
        header("Location: admin_specific_club.php?club=" . $club_name);
    } else {
        // if no file was uploaded to the club image field
        if (empty($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
            $sql_query = "UPDATE clubs SET Email = '$email_address', Club_name = '$club_name', Contact_number = '$contact_number', Description = '$club_description', Day = '$day', Start_time = '$start_time', End_time = '$end_time', Venue = '$venue'  WHERE Club_ID = $id";
        } else {
            // if file was uploaded to the club image field
            $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $sql_query = "UPDATE clubs SET Email = '$email_address', Club_name = '$club_name', Contact_number = '$contact_number', Description = '$club_description', Day = '$day', Start_time = '$start_time', End_time = '$end_time', Venue = '$venue', Event_image = '$image' WHERE Club_ID = $id";
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

        unset($_SESSION['club_id']);
    }
    mysqli_close($conn);

    header("Location: admin_specific_club.php?club=" . $club_name);
}