<!-- View, Add, Edit, Delete Record -->
<?php $action = $_POST['action']; ?>

<!-- Database Connnection for View, Edit, Delete Record -->
<?php
if ($action == "view" || $action == "edit" || $action == "delete" || $action == "add") {
    include_once "includes/dbh.php";
    include_once "../admin/includes/change_time_format.php";

    if ($action == "view" || $action == "edit" || $action == "delete") {
        session_start();
        $id = $_POST['id'];
        $club_id = $_SESSION['club_id'];
    }
}
?>

<!-- SQL Query for View , Edit and Add Record -->
<?php
if ($action == "view" || $action == "edit" || $action == "add") {
    if ($action == "view" || $action == "edit") {
        $club_activity_sql = "SELECT * FROM club_activities WHERE Club_ID = '$club_id';";
        $club_activity_result = mysqli_query($conn, $club_activity_sql);
        $club_activity_row = mysqli_fetch_assoc($club_activity_result);
    }
}
?>



<!-- SQL Query for Delete Record -->
<?php
if ($action == "delete") {
    $delete_sql_query = "DELETE FROM club_activities WHERE Club_activities_ID = '$id';";
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
        Activity Description<br>
        <textarea name="description" id="description" cols="30" rows="5" class="input-disabled"
            disabled><?php echo $club_activity_row['Description']; ?></textarea>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Day <br>
        <?php $day_list = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; ?>
        <select name="day" id="day" class="input-disabled" disabled>
            <?php if ($action == "add") : ?>
            <option value="" selected disabled hidden>Click to select day</option>
            <?php endif; ?>

            <?php foreach ($day_list as $day) : ?>
            <option value="<?php echo $day; ?>" <?php if ($action == "edit" || $action == "view") {
                                                            echo ($club_activity_row['Day'] == $day) ? "selected" : "";
                                                        } ?>>
                <?php echo $day; ?></option>
            <?php endforeach; ?>
        </select>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Start Time <br>
        <input type="text" name="start-time" id="start-time" class="input-disabled"
            value="<?php echo change_time_format($club_activity_row['Start_time']) ?>" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        End Time <br>
        <input type="text" name="end-time" id="end-time" class="input-disabled"
            value="<?php echo change_time_format($club_activity_row['End_time']) ?>" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

</ul>
<?php endif; ?>

<!-- HTML Content for View Record -->
<?php if ($action == "view") : ?>
<?php $_SESSION['club_activity_id'] = $club_activity_row['Club_activities_ID']; ?>
<script>
$("#view-form .input-disabled").removeAttr('id');
$("#edit-form .input-disabled").removeAttr('id');
$("#add-form .input-disabled").removeAttr('id');
</script>
<?php endif; ?>

<!-- HTML Content for Edit Record -->
<?php if ($action == "edit") : ?>
<?php $_SESSION['club_activity_id'] = $club_activity_row['Club_activities_ID']; ?>
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
document.getElementById("description").value = "";
</script>


<div class="submit-container">
    <input class="submit-btn bg-color-eastern-blue" type="submit" name="add" value="Submit">
</div>
<?php endif; ?>


<?php if ($action == "add") : ?>

<!-- Date limit script -->
<script defer src="../admin/scripts/date_limit.js"></script>
<?php endif; ?>

<!-- Validate Email Exist Error Script -->
<script defer src="../admin/scripts/admin_email_exist_error.js"></script>

<!-- Close Database Connection -->
<?php
if ($action == "view" || $action == "edit" || $action == "delete" || $action == "add") {
    mysqli_close($conn);
}
?>