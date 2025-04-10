<!-- View, Add, Edit, Delete Record -->
<?php $action = $_POST['action']; ?>

<!-- Database Connnection for View, Edit, Delete Record -->
<?php
if ($action == "view" || $action == "edit" || $action == "delete") {
    include_once "../user/includes/dbh.php";
    session_start();

    $id = $_POST['id'];
}
?>

<!-- SQL Query for View, Edit Record -->
<?php
if ($action == "view" || $action == "edit") {
    $sql_query = "SELECT * FROM students WHERE Student_ID = $id;";
    $result = mysqli_query($conn, $sql_query);
    $row = mysqli_fetch_assoc($result);
}
?>

<!-- SQL Query for Delete Record -->
<?php
if ($action == "delete") {
    $delete_sql_query = "DELETE FROM students WHERE Student_ID = $id;";
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

<!-- HTML Content for View, Add, Edit Record -->
<?php if ($action == "view" || $action == "edit" || $action == "add") : ?>
    <ul class="flex-container">

        <li class="flex-item">
            Student Name <br>
            <input type="text" name="student-name" id="user-name" class="input-disabled" value="<?php echo $row['Student_name'] ?>" disabled>
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
        </li>

        <li class="flex-item">
            TP Number <br>
            <input type="text" name="tp-number" id="tp-number" class="input-disabled" value="<?php echo $row['TP_number'] ?>" disabled>
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
        </li>

        <li class="flex-item">
            Gender <br>
            <select name="gender" id="gender" class="input-disabled" disabled>
                <?php if ($action == "add") : ?>
                    <option value="" selected disabled hidden>Please select</option>
                <?php endif; ?>
                <option value="Male" <?php if ($action == "edit" || $action == "view") {
                                            echo ($row['Gender'] == "Male") ? "selected" : "";
                                        } ?>>Male
                </option>
                <option value="Female" <?php if ($action == "edit" || $action == "view") {
                                            echo ($row['Gender'] == "Female") ? "selected" : "";
                                        } ?>>Female
                </option>
            </select>
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
        </li>

        <li class="flex-item">
            Email Address <br>
            <input type="text" name="email-address" id="email-address" class="input-disabled" value="<?php echo $row['Email'] ?>" disabled>
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
        </li>

        <li class="flex-item">
            Password <br>
            <input type="text" name="password" id="password" class="input-disabled" value="<?php echo $row['Password'] ?>" disabled>
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
        </li>

        <li class="flex-item">
            Contact Number <br>
            <input type="tel" name="contact-number" id="contact-number" class="input-disabled" placeholder="e.g. 999-9999999" value="<?php echo $row['Contact_number'] ?>" disabled>
            <i class="fas fa-check-circle"></i>
            <i class="fas fa-exclamation-circle"></i>
            <small>Error message</small>
        </li>

    </ul>
<?php endif; ?>

<!-- HTML Content for View Record -->
<?php if ($action == "view") : ?>
    <script>
        $("#view-form .input-disabled").removeAttr("placeholder");
        $("#view-form .input-disabled").removeAttr('id');
        $("#edit-form .input-disabled").removeAttr('id');
        $("#add-form .input-disabled").removeAttr('id');
    </script>
<?php endif; ?>

<!-- HTML Content for Edit Record -->
<?php if ($action == "edit") : ?>
    <?php $_SESSION['get_student_id'] = $row['Student_ID']; ?>
    <div class="submit-container">
        <input class="submit-btn bg-color-light-green" type="submit" name="update" value="Update">
    </div>
    <script>
        $("#view-form .input-disabled").removeAttr('id');
        $("#add-form .input-disabled").removeAttr('id');
        $("#edit-form .input-disabled").prop('disabled', false);
    </script>
<?php endif; ?>

<!-- HTML Content for Add Record -->
<?php if ($action == "add") : ?>
    <script>
        $("#view-form .input-disabled").removeAttr('id');
        $("#edit-form .input-disabled").removeAttr('id');
        $("#add-form .input-disabled").prop('disabled', false);
        $("#add-form .input-disabled").removeAttr("value");
    </script>
    <div class="submit-container">
        <input class="submit-btn bg-color-eastern-blue" name="add" type="submit" value="Submit">
    </div>
<?php endif; ?>

<!-- Validate Email Exist Error Script -->
<script defer src="scripts/admin_email_exist_error.js"></script>

<!-- Validate TP Number Exist Error Script -->
<script defer src="scripts/tp_exist_error.js"></script>

<!-- Close Database Connection -->
<?php
if ($action == "view" || $action == "edit" || $action == "delete") {
    mysqli_close($conn);
}
?>