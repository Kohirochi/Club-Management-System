<?php
include_once "includes/header.php";
include_once "includes/change_time_format.php";
?>
<main id="main">
    <h1 class="title">Events</h1>
    <br>
    <hr>
    <article id="events">
        <div class="content-container">
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
                        <th class="padding-left">Organizing Club</th>
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
                        $event_sql = "SELECT C.*, E.* FROM events AS E JOIN clubs AS C ON E.Club_ID = C.Club_ID WHERE E.Event_name LIKE '%$search%' ORDER BY CASE WHEN E.Approval_status = 'Pending' THEN 0 ELSE 1 END, E.Approval_status ASC, Date_posted DESC";
                    } else {
                        $event_sql = "SELECT C.*, E.* FROM events AS E JOIN clubs AS C ON E.Club_ID = C.Club_ID ORDER BY CASE WHEN E.Approval_status = 'Pending' THEN 0 ELSE 1 END, E.Approval_status ASC, Date_posted DESC";
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
                        <td class="padding-left"><?php echo $row['Club_name']; ?></td>
                        <td class="padding-left"><?php echo $row['Date']; ?></td>
                        <td class="padding-left"><?php echo change_time_format($row['Start_time']); ?></td>
                        <td class="padding-left"><?php echo change_time_format($row['End_time']); ?></td>
                        <td class="padding-left"><?php echo $row['Approval_status']; ?></td>
                        <td style="text-align: center;">

                            <i data-modal-target="#view" title="View" class="fas fa-eye"
                                id="view-button-<?php echo $event_id; ?>"></i>
                            <!-- If approval status is Approved or Rejected -->
                            <?php if (!($row['Approval_status'] == "Pending")) : ?>
                            <i data-modal-target="#edit" title="Edit" class="fas fa-edit"
                                id="edit-button-<?php echo $event_id; ?>"></i>
                            <?php endif; ?>
                            <a href="admin_events.php"><i title="Delete" class="fas fa-trash-alt"
                                    id="delete-button-<?php echo $event_id; ?>"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="8">
                            <h2 class="no-record">No Records Found</h2>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </article>

    <!-- View Event -->
    <div class="modal" id="view">
        <!-- Modal content -->
        <div class="modal-content" id="view-event">
            <button close-button class="close">&times;</button>
            <h1>View Event Details</h1>
            <form action="manage_event.php" id="view-form" method="post">
            </form>
        </div>
    </div>

    <!-- Edit Event -->
    <div class="modal" id="edit">
        <!-- Modal content -->
        <div class="modal-content" id="edit-event">
            <button close-button class="close">&times;</button>
            <h1>Edit Event Details</h1>
            <form action="manage_event.php" id="edit-form" method="post" enctype="multipart/form-data"
                onsubmit="return validate_edit_event();">
            </form>
        </div>
    </div>

    <!-- Add Event -->
    <div class="modal" id="add">
        <!-- Modal content -->
        <div class="modal-content" id="add-event">
            <button close-button class="close">&times;</button>
            <h1>Add New Event</h1>
            <form action="manage_event.php" id="add-form" method="post" enctype="multipart/form-data"
                onsubmit="return validate_add_event();">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</main>

<script>
$(document).ready(function() {
    <?php foreach ($event_array as $event_id) : ?>

    // Load View Event Data When Clicked
    $("#view-button-<?php echo $event_id; ?>").click(function() {
        var id = "<?php echo str_replace("E", "", $event_id) ?>";
        var action = "view";
        $("#view-form").load("manage_event_data.php", {
            id: id,
            action: action
        });
    });

    // Load Edit Event Data When Clicked
    $("#edit-button-<?php echo $event_id; ?>").click(function() {
        var id = "<?php echo str_replace("E", "", $event_id) ?>";
        var action = "edit";
        $("#edit-form").load("manage_event_data.php", {
            id: id,
            action: action
        });
    });

    // Load Delete Event Data When Clicked
    $("#delete-button-<?php echo $event_id; ?>").click(function() {
        if (confirm("Are you sure you want to delete this record?")) {
            var id = "<?php echo str_replace("E", "", $event_id) ?>";
            var action = "delete";
            $(window).load("manage_event_data.php", {
                id: id,
                action: action
            });
        }
    });

    <?php endforeach; ?>

    // Load Add Event Data When Clicked
    $("#add-button").click(function() {
        var action = "add";
        $("#add-form").load("manage_event_data.php", {
            action: action
        });
    });
});
</script>

<?php
include_once "includes/alert_message.php";
include_once "includes/footer.php";
?>