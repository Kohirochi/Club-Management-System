<?php
include_once "../user/includes/dbh.php";
include_once "includes/change_time_format.php";
session_start();

$report_category = $_POST['report_category'];
$subject_id = $_POST['report_list'];

$data_array = array();
?>

<!-- Student Report Data -->
<?php if ($report_category == "Students") : ?>
<div id="subject-container">
    <h1>Students Report</h1>

    <?php if ($subject_id == "all-students") : ?>
    <h2>All Students</h2>
</div>
<!-- All Student Table  -->
<div class="table-container" id="student-report">
    <table>
        <tr>
            <th class="padding-left">Student Name</th>
            <th class="padding-left">TP Number</th>
            <th class="padding-left">Gender</th>
            <th class="padding-left">Clubs Joined</th>
            <th class="padding-left">Contact Number</th>
        </tr>
        <?php
            $student_sql = "SELECT * FROM students ORDER BY Student_name ASC";
            $student_result = $conn->query($student_sql);
            $student_result_check = mysqli_num_rows($student_result);
            $student_array = array();
            ?>
        <?php if ($student_result_check > 0) : ?>
        <?php while ($student_row = mysqli_fetch_assoc($student_result)) : ?>
        <?php
                    $joined_club_sql = "SELECT * FROM joined_clubs WHERE Student_ID = " . $student_row['Student_ID'] .  ";";
                    $joined_club_result = $conn->query($joined_club_sql);
                    $joined_club_result_check = mysqli_num_rows($joined_club_result);
                    ?>

        <?php $joined_clubs = "No Clubs Joined" ?>
        <?php if ($joined_club_result_check > 0) : ?>
        <?php $joined_clubs_array = array() ?>
        <?php while ($joined_club_row = mysqli_fetch_assoc($joined_club_result)) : ?>
        <?php
                            $joined_club_id =  $joined_club_row['Club_ID'];
                            $club_sql = "SELECT * FROM Clubs WHERE Club_ID = $joined_club_id;";
                            $club_result = $conn->query($club_sql);
                            $club_row = mysqli_fetch_assoc($club_result);
                            array_push($joined_clubs_array, $club_row['Club_name']);
                            ?>
        <?php endwhile; ?>
        <?php $joined_clubs = join(", ", $joined_clubs_array) ?>
        <?php endif; ?>
        <tr>
            <td class="padding-left"><?php echo $student_row['Student_name']; ?></td>
            <td class="padding-left"><?php echo $student_row['TP_number']; ?></td>
            <td class="padding-left"><?php echo $student_row['Gender']; ?></td>
            <td class="padding-left"><?php echo $joined_clubs ?></td>
            <td class="padding-left"><?php echo $student_row['Contact_number']; ?></td>
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

<?php
            // Obtain Pie Chart Data
            $header = "Student Club Distribution";

            array_push($data_array, ["Club Name", "Total Members"]);

            $club_sql = "SELECT * FROM clubs";
            $club_result = $conn->query($club_sql);
            $club_result_check = mysqli_num_rows($club_result);

            if ($club_result_check > 0) {
                while ($club_row = mysqli_fetch_assoc($club_result)) {
                    $club_id = $club_row['Club_ID'];
                    $club_name = $club_row['Club_name'];
                    $joined_club_sql = "SELECT COUNT(Student_ID) AS total_members FROM joined_clubs WHERE Club_ID = '$club_id'; ";
                    $joined_club_result = $conn->query($joined_club_sql);
                    $joined_club_row = mysqli_fetch_assoc($joined_club_result);
                    $total_member = (int) $joined_club_row['total_members'];

                    // If the total number of club is more than 0
                    if ($total_member != 0) {
                        $student_data = [$club_name, $total_member];
                        array_push($data_array, $student_data);
                    }
                }
            }
    ?>
<?php else : ?>
<!-- All Student in Specific Club Table  -->
<?php
            $club_sql = "SELECT * FROM clubs WHERE Club_ID = '$subject_id';";
            $club_result = $conn->query($club_sql);
            $club_row = mysqli_fetch_assoc($club_result);
    ?>
<h2><?php echo $club_row['Club_name']; ?></h2>
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
            $joined_club_sql = "SELECT * FROM joined_clubs WHERE Club_ID = '$subject_id';";
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
<?php endif; ?>

<!-- All Clubs -->
<?php if ($report_category == "Clubs") : ?>
<div id="subject-container">
    <h1>Clubs Report</h1>
    <h2>All Clubs</h2>
</div>
<div class="table-container">
    <table>
        <tr>
            <th class="padding-left">Club Name</th>
            <th class="padding-left">Email</th>
            <th class="padding-left">Contact Number</th>
        </tr>
        <?php
            $club_sql = "SELECT * FROM clubs";
            $club_result = $conn->query($club_sql);
            $club_result_check = mysqli_num_rows($club_result);
            ?>
        <?php if ($club_result_check > 0) : ?>
        <?php while ($club_row = mysqli_fetch_assoc($club_result)) : ?>

        <tr>
            <td class="padding-left"><?php echo $club_row['Club_name']; ?></td>
            <td class="padding-left"><?php echo $club_row['Email']; ?></td>
            <td class="padding-left"><?php echo $club_row['Contact_number']; ?></td>
        </tr>
        <?php endwhile; ?>
        <?php else : ?>
        <tr>
            <td colspan="3">
                <h2 class="no-record">No Records Found</h2>
            </td>
        </tr>
        <?php endif; ?>
    </table>
</div>

<?php endif; ?>

<!-- All events -->
<?php if ($report_category == "Events") : ?>
<div id="subject-container">
    <h1>Events Report</h1>
    <h2>All Events</h2>
</div>
<div class="table-container">
    <table>
        <tr>
            <th class="padding-left">Event Name</th>
            <th class="padding-left">Organizing Club</th>
            <th class="padding-left">Date</th>
            <th class="padding-left">Start Time</th>
            <th class="padding-left">End Time</th>
        </tr>
        <?php
            $event_sql = "SELECT C.*, E.* FROM events AS E JOIN clubs AS C ON E.Club_ID = C.Club_ID;";
            $event_result = $conn->query($event_sql);
            $event_result_check = mysqli_num_rows($event_result);
            ?>
        <?php if ($event_result_check > 0) : ?>
        <?php while ($event_row = mysqli_fetch_assoc($event_result)) : ?>

        <tr>
            <td class="padding-left"><?php echo $event_row['Event_name']; ?></td>
            <td class="padding-left"><?php echo $event_row['Club_name']; ?></td>
            <td class="padding-left"><?php echo $event_row['Date']; ?></td>
            <td class="padding-left"><?php echo change_time_format($event_row['Start_time']); ?></td>
            <td class="padding-left"><?php echo change_time_format($event_row['End_time']); ?></td>
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

<?php
    // pie chart
    $header = "Club Event Distribution";

    array_push($data_array, ["Club Name", "Total Events"]);

    $club_sql = "SELECT * FROM clubs";
    $club_result = $conn->query($club_sql);
    $club_result_check = mysqli_num_rows($club_result);

    if ($club_result_check > 0) {
        while ($club_row = mysqli_fetch_assoc($club_result)) {
            $club_id = $club_row['Club_ID'];
            $club_name = $club_row['Club_name'];
            $event_sql = "SELECT COUNT(Event_ID) AS total_events FROM events WHERE Club_ID = '$club_id'; ";
            $event_sql_result = $conn->query($event_sql);
            $event_row = mysqli_fetch_assoc($event_sql_result);
            $total_events = (int) $event_row['total_events'];


            if ($total_events != 0) {
                $event_data = [$club_name, $total_events];
                array_push($data_array, $event_data);
            }
        }
    }
    ?>
<?php endif; ?>

<!-- Load Pie Chart Data -->
<?php if ($subject_id == "all-students" || $subject_id == "all-events") : ?>

<!-- Pie Chart -->
<div id="chart-container">
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <div id="piechart-png" style="width: 900px; height: 500px;"></div>
</div>
<script type="text/javascript">
google.charts.load('current', {
    'packages': ['corechart']
});

google.charts.setOnLoadCallback(function() {
    drawChart("<?php echo $header; ?>", <?php echo json_encode($data_array); ?>);
});


function drawChart(header, data_array) {

    var data = google.visualization.arrayToDataTable(data_array);

    var options = {
        title: header,
        is3D: true
    };

    // Display Chart in interactive format
    var chart_area = document.getElementById('piechart');
    var chart = new google.visualization.PieChart(chart_area);

    // Display Chart in PNG format
    var chart_png_area = document.getElementById('piechart-png');
    var chart_png = new google.visualization.PieChart(chart_png_area);

    google.visualization.events.addListener(chart_png, 'ready', function() {
        chart_png_area.innerHTML = '<img src="' + chart_png.getImageURI() + '" >';
    });

    chart_png.draw(data, options);
    chart.draw(data, options);
}
</script>
<?php endif; ?>