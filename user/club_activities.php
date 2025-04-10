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
<article id="specific-club-activity-list">
    <div class="logo-container">
        <img title="Club logo" src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>">
    </div>
    <h1 class="title"><?php echo $club_row['Club_name']; ?></h1>
    <div class="content-container">
        <h2>Club Activity List</h2>
        <button data-modal-target="#add" title="Add Activity" id="add-button">Add Activity</button>
        <div class="table-container">
            <table>
                <tr>
                    <th class="padding-left">Description</th>
                    <th class="padding-left">Day</th>
                    <th class="padding-left">Start Time</th>
                    <th class="padding-left">End Time</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
                <?php
                $club_activity_sql = "SELECT * FROM club_activities WHERE Club_ID = '$club_id';";
                $club_activity_result = $conn->query($club_activity_sql);

                $club_activity_result_check = mysqli_num_rows($club_activity_result);
                $club_activity_array = array();
                ?>
                <?php if ($club_activity_result_check > 0) : ?>
                <?php while ($club_activity_row = mysqli_fetch_assoc($club_activity_result)) : ?>
                <?php
                        $club_activity_id = "A" . $club_activity_row['Club_activities_ID'];
                        array_push($club_activity_array, $club_activity_id);
                        ?>
                <tr>
                    <td class="padding-left"><?php echo $club_activity_row['Description']; ?></td>
                    <td class="padding-left"><?php echo $club_activity_row['Day']; ?></td>
                    <td class="padding-left"><?php echo change_time_format($club_activity_row['Start_time']); ?></td>
                    <td class="padding-left"><?php echo change_time_format($club_activity_row['End_time']); ?></td>
                    <td style="text-align: center;">

                        <i data-modal-target="#view" title="View" class="fas fa-eye"
                            id="view-button-<?php echo $club_activity_id; ?>"></i>
                        <i data-modal-target="#edit" title="Edit" class="fas fa-edit"
                            id="edit-button-<?php echo $club_activity_id; ?>"></i>
                        <a href="club_activities.php?club=<?php echo $club_row['Club_name'] ?>"><i title="Delete"
                                class="fas fa-trash-alt" id="delete-button-<?php echo $club_activity_id; ?>"></i>
                    </td>
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
    </div>

    <!-- View Activity -->
    <div class="mymodal" id="view">
        <!-- Modal content -->
        <div class="mymodal-content" id="view-activity">
            <button close-button class="close-btn">&times;</button>
            <h1>View Activity Details</h1>
            <form action="manage_club_activity.php" id="view-form" method="post">
            </form>
        </div>
    </div>

    <!-- Edit Activity -->
    <div class="mymodal" id="edit">
        <!-- Modal content -->
        <div class="mymodal-content" id="edit-activity">
            <button close-button class="close-btn">&times;</button>
            <h1>Edit Event Details</h1>
            <form action="manage_club_activity.php" id="edit-form" method="post"
                onsubmit="return validate_club_activity();">
            </form>
        </div>
    </div>

    <!-- Add Activity -->
    <div class="mymodal" id="add">
        <!-- Modal content -->
        <div class="mymodal-content" id="add-activity">
            <button close-button class="close-btn">&times;</button>
            <h1>Add New Activity</h1>
            <form action="manage_club_activity.php" id="add-form" method="post"
                onsubmit="return validate_club_activity();">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</article>

<script>
$(document).ready(function() {
    <?php foreach ($club_activity_array as $club_activity_id) : ?>

    // Load View Event Data When Clicked
    $("#view-button-<?php echo $club_activity_id; ?>").click(function() {
        var id = "<?php echo str_replace("A", "", $club_activity_id) ?>";
        var action = "view";
        $("#view-form").load("manage_club_activity_data.php", {
            id: id,
            action: action
        });
    });

    // Load Edit Event Data When Clicked
    $("#edit-button-<?php echo $club_activity_id; ?>").click(function() {
        var id = "<?php echo str_replace("A", "", $club_activity_id) ?>";
        var action = "edit";
        $("#edit-form").load("manage_club_activity_data.php", {
            id: id,
            action: action
        });
    });

    // Load Delete Event Data When Clicked
    $("#delete-button-<?php echo $club_activity_id; ?>").click(function() {
        if (confirm("Are you sure you want to delete this record?")) {
            var id = "<?php echo str_replace("A", "", $club_activity_id) ?>";
            var action = "delete";
            $(window).load("manage_club_activity_data.php", {
                id: id,
                action: action
            });
        }
    });

    <?php endforeach; ?>

    // Load Add Event Data When Clicked
    $("#add-button").click(function() {
        var action = "add";
        $("#add-form").load("manage_club_activity_data.php", {
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