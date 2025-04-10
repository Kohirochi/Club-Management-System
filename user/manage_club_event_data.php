<!-- View, Add Record -->
<?php $action = $_POST['action']; ?>

<!-- Database Connnection for View, Add Record -->
<?php
if ($action == "view" || $action == "add") {
    include_once "includes/dbh.php";
    include_once "../admin/includes/change_time_format.php";

    if ($action == "view") {
        session_start();
        $id = $_POST['id'];
    }
}
?>

<!-- SQL Query for View Record -->
<?php
if ($action == "view") {
    $event_sql_query = "SELECT * FROM events WHERE Event_ID = $id;";
    $event_result = mysqli_query($conn, $event_sql_query);
    $event_row = mysqli_fetch_assoc($event_result);

    $club_sql_query = "SELECT * FROM clubs";
    $club_result = mysqli_query($conn, $club_sql_query);
    $club_check = mysqli_num_rows($club_result);
}
?>

<!-- HTML Content for View, Add Record -->
<?php if ($action == "view" || $action == "add") : ?>

<!-- Event Image for View Event -->
<?php if ($action == "view") : ?>
<img src="data:image/jpeg;base64,<?php echo base64_encode($event_row['Event_image']); ?>" alt='event_image'>
<?php endif; ?>

<ul class="flex-container">
    <li class="flex-item">
        Event Name <br>
        <input type="text" name="event-name" id="name" class="input-disabled"
            value="<?php echo $event_row['Event_name'] ?>" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <!-- Profile Picture for Edit and Add Event -->
    <?php if ($action == "add") : ?>
    <li class="flex-item">
        Event Image <br>
        <input type="file" name="image" class="input-disabled" id="image" style="border: none; padding-left: 0;">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>
    <?php endif; ?>

    <li class="flex-item">
        Event Description<br>
        <textarea name="description" id="description" cols="30" rows="5" class="input-disabled"
            disabled><?php echo $event_row['Description']; ?></textarea>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Date <br>
        <input type="date" name="date" id="date" class="input-disabled" value="<?php echo $event_row['Date'] ?>"
            disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <?php if ($action == "view" || $action == "edit") : ?>
    <li class="flex-item">
        Date Posted <br>
        <input type="date" name="date-posted" id="posted-date" value="<?php echo $event_row['Date_posted'] ?>" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>
    <?php endif; ?>

    <li class="flex-item">
        Start Time <br>
        <input type="text" name="start-time" id="start-time" class="input-disabled"
            value="<?php echo change_time_format($event_row['Start_time']) ?>" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        End Time <br>
        <input type="text" name="end-time" id="end-time" class="input-disabled"
            value="<?php echo change_time_format($event_row['End_time']) ?>" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Registration Link <br>
        <input type="text" name="link" id="link" class="input-disabled" value="<?php echo $event_row['Link'] ?>"
            disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <?php if ($action == "view") : ?>
    <li class="flex-item">
        Approval Status <br>
        <?php $status_list = ['Pending', 'Approved', 'Rejected']; ?>
        <select name="approval-status" id="approval-status" class="input-disabled" disabled>
            <?php foreach ($status_list as $status) : ?>
            <option value="<?php echo $status ?>"
                <?php echo ($event_row['Approval_status'] == $status) ? "selected" : ""; ?>>
                <?php echo $status ?>
            </option>
            <?php endforeach; ?>
        </select>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>
    <?php endif; ?>

</ul>
<?php endif; ?>

<!-- HTML Content for View Record -->
<?php if ($action == "view") : ?>

<?php $_SESSION['event_id'] = $event_row['Event_ID']; ?>
<script>
$("#view-form .input-disabled").removeAttr('id');
$("#edit-form .input-disabled").removeAttr('id');
$("#add-form .input-disabled").removeAttr('id');
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
if ($action == "view" || $action == "add") {
    mysqli_close($conn);
}
?>