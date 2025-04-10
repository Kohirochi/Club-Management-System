<?php
include_once "includes/header.php";
// Change integer to string datatype
function to_string($int)
{
    if ($int < 10) {
        $int = "0" . strval($int);
    } else {
        $int = strval($int);
    }
    return $int;
}

// Total Clubs
$total_club_sql_query = "SELECT * FROM clubs;";
$total_club_result = mysqli_query($conn, $total_club_sql_query);
$total_club = to_string(mysqli_num_rows($total_club_result));

// Today Total Events
$today = date("Y-m-d");
$today_event_sql_query = "SELECT * FROM events WHERE Date = '$today' AND Approval_status = 'Approved';";
$today_event_result = mysqli_query($conn, $today_event_sql_query);
$today_event = to_string(mysqli_num_rows($today_event_result));

// Total Events
$total_event_sql_query = "SELECT * FROM events WHERE Approval_status = 'Approved';";
$total_event_result = mysqli_query($conn, $total_event_sql_query);
$total_event = to_string(mysqli_num_rows($total_event_result));

// Total Students
$total_student_sql_query = "SELECT * FROM students;";
$total_student_result = mysqli_query($conn, $total_student_sql_query);
$total_student = to_string(mysqli_num_rows($total_student_result));

// Total Club Creation Requests
$total_request_sql_query = "SELECT * FROM club_creation;";
$total_request_result = mysqli_query($conn, $total_request_sql_query);
$total_request = to_string(mysqli_num_rows($total_request_result));

?>
<main id="main">
    <h1 class="title">Dashboard</h1>
    <br>
    <hr>
    <article id="dashboard">
        <div class="flex-container">
            <div class="flex-item">
                <h2>Total Clubs</h2>
                <p><?php echo $total_club; ?></p>
            </div>
            <div class="flex-item">
                <h2>Today Total Events</h2>
                <p><?php echo $today_event; ?></p>
            </div>
            <div class="flex-item">
                <h2>Total Events</h2>
                <p><?php echo $total_event; ?></p>
            </div>
            <div class="flex-item">
                <h2>Total Students</h2>
                <p><?php echo $total_student; ?></p>
            </div>
            <div class="flex-item">
                <h2>Total Club Creation Requests</h2>
                <p><?php echo $total_request; ?></p>
            </div>
        </div>
    </article>
</main>
<?php
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    echo "<script>window.onload = function() {alert('" . $_SESSION['message'] . "')};</script>";
    unset($_SESSION['login']);
    unset($_SESSION['message']);
}
include_once "includes/footer.php";
?>