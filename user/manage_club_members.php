<!-- Promote, Delete Record -->
<?php
$action = $_POST['action'];

//Database Connnection for Promote, Delete Record
include_once "includes/dbh.php";

$club_id = $_POST['club_id'];

session_start();
$student_id = $_POST['student_id'];

?>

<?php
if ($action == "promote") {
    $promote_sql_query = "UPDATE joined_clubs SET Role = 'Committee' WHERE Student_ID = '$student_id' AND Club_ID = '$club_id';";

    $result = mysqli_query($conn, $promote_sql_query);
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
}

// SQL Query for Delete Record
if ($action == "delete") {

    $delete_sql_query = "DELETE FROM joined_clubs WHERE Student_ID = '$student_id' AND Club_ID = '$club_id';";
    $delete_result = mysqli_query($conn, $delete_sql_query);
    if (mysqli_affected_rows($conn) >= 1) {
        $_SESSION['message'] = "Record Deleted Successfully";
        $_SESSION['delete'] = true;
    } else {
        $_SESSION['message'] = "Failed to Delete Record";
        $_SESSION['delete'] = false;
    }
}
?>