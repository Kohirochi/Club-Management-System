<?php
include ("./includes/dbh.php");

session_start();
$student_id = $_SESSION['student_id'];
 
if(isset($_POST['updateRecord'])){
        // get the value from the form and store in a variable
        $Student_name = trim($_POST['txtName']);
        $Gender = trim($_POST['txtGender']);
        $Password = trim($_POST['txtPassword']);
        $Contact_number = trim($_POST['txtContact']);

        //create update sql
        $query = "UPDATE `students` SET `Student_name`='$Student_name', `Gender`='$Gender', `Password`='$Password', `Contact_number`='$Contact_number'  WHERE student_id='$student_id'";
        // if query is executed successfully
        $result = mysqli_query($conn, $query);

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

        echo "<script> window.location.href='user_profile.php';</script>";
        mysqli_close($conn);

    }
?>