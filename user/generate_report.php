<?php
include_once "includes/dbh.php";
include_once "../admin/includes/change_time_format.php";
session_start();

$report_category = $_POST['report_category'];
$club_id = $_POST['id'];

?>

<!-- Student Report Data -->
<?php if ($report_category == "Members") : ?>
<div id="subject-container">
    <h1>Members Report</h1>

    <!-- Members in Specific Club Table  -->
    <?php
        $club_sql = "SELECT * FROM clubs WHERE Club_ID = '$club_id';";
        $club_result = $conn->query($club_sql);
        $club_row = mysqli_fetch_assoc($club_result);
        ?>
    <h3><?php echo $club_row['Club_name']; ?></h3>
</div>
<div class="table-container" id="student-report">
    <table>
        <tr>
            <th class="padding-left">Student Name</th>
            <th class="padding-left">TP Number</th>
            <th class="padding-left">Gender</th>
            <th class="padding-left">Contact Number</th>
            <th class="padding-left">Role</th>
        </tr>
        <?php
            $joined_club_sql = "SELECT * FROM joined_clubs WHERE Club_ID = '$club_id';";
            $joined_club_result = $conn->query($joined_club_sql);
            $joined_club_result_check = mysqli_num_rows($joined_club_result);
            ?>
        <?php if ($joined_club_result_check > 0) : ?>
        <?php while ($joined_club_row = mysqli_fetch_assoc($joined_club_result)) : ?>
        <?php
                    $student_id = $joined_club_row['Student_ID'];
                    $student_sql = "SELECT * FROM students WHERE Student_ID = '$student_id' ORDER BY Student_name ASC";
                    $student_result = $conn->query($student_sql);
                    $student_row = mysqli_fetch_assoc($student_result);
                    ?>
        <tr>
            <td class="padding-left"><?php echo $student_row['Student_name']; ?></td>
            <td class="padding-left"><?php echo $student_row['TP_number']; ?></td>
            <td class="padding-left"><?php echo $student_row['Gender']; ?></td>
            <td class="padding-left"><?php echo $student_row['Contact_number']; ?></td>
            <td class="padding-left"><?php echo $joined_club_row['Role']; ?></td>
        </tr>
        <?php endwhile; ?>
        <?php else : ?>
        <tr>
            <td colspan="5">
                <h2 class="no-record">No Records Found</h2>
            </td>
        </tr>
        <?php endif; ?>
    </table>
</div>
<?php endif; ?>

<?php if ($report_category == "Events") : ?>
<div id="subject-container">
    <h1>Events Report</h1>
    <?php
        $club_sql = "SELECT * FROM clubs WHERE Club_ID = '$club_id';";
        $club_result = $conn->query($club_sql);
        $club_row = mysqli_fetch_assoc($club_result);
        ?>
    <h3><?php echo $club_row['Club_name']; ?></h3>
</div>
<div class="table-container">
    <table>
        <tr>
            <th class="padding-left">Event Name</th>
            <th class="padding-left">Date</th>
            <th class="padding-left">Start Time</th>
            <th class="padding-left">End Time</th>
        </tr>
        <?php
            $event_sql = "SELECT * FROM events WHERE Club_ID = '$club_id'";
            $event_result = $conn->query($event_sql);
            $event_result_check = mysqli_num_rows($event_result);
            ?>
        <?php if ($event_result_check > 0) : ?>
        <?php while ($event_row = mysqli_fetch_assoc($event_result)) : ?>

        <tr>
            <td class="padding-left"><?php echo $event_row['Event_name']; ?></td>
            <td class="padding-left"><?php echo $event_row['Date']; ?></td>
            <td class="padding-left"><?php echo change_time_format($event_row['Start_time']); ?></td>
            <td class="padding-left"><?php echo change_time_format($event_row['End_time']); ?></td>
        </tr>
        <?php endwhile; ?>
        <?php else : ?>
        <tr>
            <td colspan="4">
                <h2 class="no-record">No Records Found</h2>
            </td>
        </tr>
        <?php endif; ?>
    </table>
</div>

<?php endif; ?>