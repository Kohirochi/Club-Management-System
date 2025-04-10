<?php
include_once "../user/includes/dbh.php";

$report_type = $_POST['report_type'];
?>

<?php if ($report_type == "Students") : ?>
<?php
    $club_sql = "SELECT * FROM clubs";
    $club_result = $conn->query($club_sql);
    $club_result_check = mysqli_num_rows($club_result); ?>

<?php if ($club_result_check > 0) : ?>
<?php while ($row = mysqli_fetch_assoc($club_result)) : ?>
<option value='<?php echo $row['Club_ID']; ?>'><?php echo $row['Club_name']; ?></option>

<?php endwhile; ?>
<option value='all-students'>All Students</option>
<?php endif; ?>

<?php elseif ($report_type == "Clubs") : ?>
<option value='all-clubs'>All Clubs</option>

<?php elseif ($report_type == "Events") : ?>
<option value='all-events'>All Events</option>

<?php endif; ?>


<!-- Close Database Connection  -->
<? mysqli_close($conn); ?>