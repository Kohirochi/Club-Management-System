<!-- Promote, Demote, Delete, Add Record -->
<?php
$action = $_POST['action'];

//Database Connnection for Promote, Demote, Delete, Add Record
include_once "../user/includes/dbh.php";

$club_id = $_POST['club_id'];

if ($action == "promote" || $action == "demote" || $action == "delete") {
    session_start();
    $student_id = $_POST['student_id'];
}

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

if ($action == "demote") {
    $demote_sql_query = "UPDATE joined_clubs SET Role = 'Member' WHERE Student_ID = '$student_id' AND Club_ID = '$club_id';";

    $result = mysqli_query($conn, $demote_sql_query);
    // If database is updated
    if (mysqli_affected_rows($conn) >= 1) {
        $_SESSION['update'] = true;
        $_SESSION['message'] = "Record Updated Successfully";
    } else {
        $_SESSION['update'] = false;
        $_SESSION['message'] = "Failed to Update Record";
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

<!-- Add New Club Member -->
<?php if ($action == "add") : ?>
    <?php
    // Get all students and store in an array
    $student_list = array();
    $student_sql_query = "SELECT * FROM students ORDER BY Student_name ASC;";
    $student_result = mysqli_query($conn, $student_sql_query);
    $student_result_check = mysqli_num_rows($student_result);
    if ($student_result_check > 0) {
        while ($student_row = mysqli_fetch_assoc($student_result)) {
            array_push($student_list, $student_row['Student_ID']);
        }
    }

    // Get club members and store in an array
    $club_member_list = array();
    $club_member_sql_query = "SELECT * FROM joined_clubs WHERE Club_ID = '$club_id';";
    $club_member_result = mysqli_query($conn, $club_member_sql_query);
    $club_member_result_check = mysqli_num_rows($club_member_result);
    if ($club_member_result_check > 0) {
        while ($club_member_row = mysqli_fetch_assoc($club_member_result)) {
            array_push($club_member_list, $club_member_row['Student_ID']);
        }
    }

    // Compare both array and get the students that 
    $available_student_list = array_diff($student_list, $club_member_list);
    ?>

    <?php if (empty($available_student_list)) : ?>
        <script>
            // Close opened modals
            var modals = document.querySelectorAll('.modal.active');
            modals.forEach(modal => {
                close_modal(modal)
            })

            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            async function delay() {
                await sleep(200);
                alert("No available students to be added");
            }

            delay();
        </script>
    <?php else : ?>

        <ul class="flex-container">
            <li class="flex-item">
                Student Name <br>
                <select name="student-id" id="student-name">
                    <option value="" selected disabled hidden>Please select a student</option>

                    <?php if (!empty($available_student_list)) : ?>
                        <?php foreach ($available_student_list as $available_student_id) : ?>
                            <?php
                            $available_student_sql_query = "SELECT * FROM students WHERE Student_ID = '$available_student_id';";
                            $available_student_result = mysqli_query($conn, $available_student_sql_query);
                            $available_student_row = mysqli_fetch_assoc($available_student_result);
                            ?>
                            <option value="<?php echo $available_student_id; ?>">
                                <?php echo $available_student_row['Student_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </li>

            <li class="flex-item">
                Role<br>
                <select name="role" id="role">
                    <option value="" selected disabled hidden>Please select a role</option>
                    <option value="Member">
                        Member
                    </option>
                    <option value="Committee">
                        Committee
                    </option>
                </select>
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </li>
        </ul>
        <div class="submit-container">
            <input class="submit-btn bg-color-eastern-blue" type="submit" name="add" value="Submit">
        </div>
    <?php endif; ?>
<?php endif; ?>