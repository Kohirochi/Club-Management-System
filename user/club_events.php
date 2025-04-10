<?php
include_once "includes/header.php";
include_once "includes/dbh.php";
include_once "../admin/includes/change_time_format.php";

$club_name = $_GET['club'];
$club_sql = "SELECT * FROM clubs WHERE Club_name = '$club_name';";
$club_details = $conn->query($club_sql);
$club_row = mysqli_fetch_assoc($club_details);
$club_id = $club_row['Club_ID'];

include_once "includes/committee_authentication.php";
include_once "includes/sidenav.php";

$_SESSION['club_id'] = $club_id;
?>
<article id="specific-club-event-list">
    <div class="logo-container">
        <img title="Club logo" src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>">
    </div>
    <h1 class="title"><?php echo $club_row['Club_name']; ?></h1>
    <div class="content-container">
        <h2>Club Event List</h2>
        <form action="" method="post">
            <div class="search-container">
                <input type="text" name="search-field" id="search-field" placeholder="Event Name">
                <input class="submit-btn" name="search" id="search-button" type="submit" value="Search">
            </div>
        </form>
        <button data-modal-target="#add" title="Add Event" id="add-button">Add Event</button>
        <div class="table-container">
            <table>
                <tr>
                    <th class="padding-left">Image</th>
                    <th class="padding-left">Event Name</th>
                    <th class="padding-left">Date</th>
                    <th class="padding-left">Start Time</th>
                    <th class="padding-left">End Time</th>
                    <th class="padding-left">Approval Status</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
                <?php
                // Check if search button is clicked and search field is not empty
                if (isset($_POST['search']) && !empty(trim($_POST['search-field']))) {
                    $search = trim($_POST['search-field']);
                    $event_sql = "SELECT C.*, E.* FROM events AS E JOIN clubs AS C ON E.Club_ID = C.Club_ID WHERE E.Event_name LIKE '%$search%' AND C.Club_ID = '$club_id' ORDER BY CASE WHEN E.Approval_status = 'Pending' THEN 0 ELSE 1 END, E.Approval_status ASC, Date_posted DESC";
                } else {
                    $event_sql = "SELECT C.*, E.* FROM events AS E JOIN clubs AS C ON E.Club_ID = C.Club_ID WHERE C.Club_ID = '$club_id' ORDER BY E.Approval_status ASC, Date_posted DESC";
                }
                $event_result = $conn->query($event_sql);
                $event_result_check = mysqli_num_rows($event_result);
                $event_array = array();
                ?>
                <?php if ($event_result_check > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($event_result)) : ?>
                <?php
                        $event_id = "E" . $row['Event_ID'];
                        array_push($event_array, $event_id);
                        ?>
                <tr>
                    <td style="text-align: center;"><img
                            src="data:image/jpeg;base64,<?php echo base64_encode($row['Event_image']); ?>"
                            alt="event_image">
                    </td>
                    <td class="padding-left"><?php echo $row['Event_name']; ?></td>
                    <td class="padding-left"><?php echo $row['Date']; ?></td>
                    <td class="padding-left"><?php echo change_time_format($row['Start_time']); ?></td>
                    <td class="padding-left"><?php echo change_time_format($row['End_time']); ?></td>
                    <td class="padding-left"><?php echo $row['Approval_status']; ?></td>
                    <td style="text-align: center;">

                        <i data-modal-target="#view" title="View" class="fas fa-eye"
                            id="view-button-<?php echo $event_id; ?>"></i>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else : ?>
                <tr>
                    <td colspan="7">
                        <h2 class="no-record">No Records Found</h2>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <!-- View Event -->
    <div class="mymodal" id="view">
        <!-- Modal content -->
        <div class="mymodal-content" id="view-event">
            <button close-button class="close-btn">&times;</button>
            <h1>View Event Details</h1>
            <form action="manage_club_event.php" id="view-form" method="post">
            </form>
        </div>
    </div>

    <!-- Add Event -->
    <div class="mymodal" id="add">
        <!-- Modal content -->
        <div class="mymodal-content" id="add-event">
            <button close-button class="close-btn">&times;</button>
            <h1>Add New Event</h1>
            <form action="manage_club_event.php" id="add-form" method="post" enctype="multipart/form-data"
                onsubmit="return validate_add_club_event();">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</article>

<script>
$(document).ready(function() {
    <?php foreach ($event_array as $event_id) : ?>

    // Load View Event Data When Clicked
    $("#view-button-<?php echo $event_id; ?>").click(function() {
        var id = "<?php echo str_replace("E", "", $event_id) ?>";
        var action = "view";
        $("#view-form").load("manage_club_event_data.php", {
            id: id,
            action: action
        });
    });

    <?php endforeach; ?>

    // Load Add Event Data When Clicked
    $("#add-button").click(function() {
        var action = "add";
        $("#add-form").load("manage_club_event_data.php", {
            action: action
        });
    });
});
</script>

<!-- Activate Modal Script -->
<script defer src="scripts/modal.js"></script>

<?php
include_once "../admin/includes/alert_message.php";
include_once "includes/footer.php";
?>