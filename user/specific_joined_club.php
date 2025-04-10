<?php
include_once "includes/header.php";
include_once "includes/dbh.php";
include_once "../admin/includes/change_time_format.php";

// Get Specific Club Details
$club_name = $_GET['club'];
$club_details_sql = "SELECT * FROM clubs WHERE Club_name = '$club_name';";
$club_details_result = $conn->query($club_details_sql);
$club_row = mysqli_fetch_assoc($club_details_result);
$club_id = $club_row['Club_ID'];
$_SESSION['club_id'] = $club_row['Club_ID'];


$student_id = $_SESSION['student_id'];
$joined_club_sql = "SELECT * FROM joined_clubs WHERE Student_ID = '$student_id' AND Club_ID = '$club_id';";
$joined_club_result = $conn->query($joined_club_sql);
$joined_club_row = mysqli_fetch_assoc($joined_club_result);

// Check if the role of member
if ($joined_club_row['Role'] == "Committee") {
    include_once "includes/sidenav.php";
}

// Get all the club activity
$club_activity_sql = "SELECT * FROM club_activities WHERE Club_ID = '$club_id';";
$club_activity_result = $conn->query($club_activity_sql);
$club_activity_check = mysqli_num_rows($club_activity_result);
?>

<article id="specific-joined-club">
    <div class="logo-container">
        <img title="Club logo" src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>">
    </div>
    <h1 class="title"><?php echo $club_row['Club_name']; ?></h1>

    <button data-modal-target="#feedback" title="Give Feedback" id="feedback-button">Give Feedback</button>

    <div class="content-container" id="specific-club-details">
        <div class="title-container">
            <h2>Club Settings</h2>
            <?php if ($joined_club_row['Role'] == "Committee") : ?>
            <button title="Edit" id="edit-button">
                <i class="fas fa-edit"></i>Edit
            </button>
            <?php endif; ?>
        </div>
        <form action="manage_specific_joined_club.php" method="post" enctype="multipart/form-data"
            onsubmit="return validate_edit_joined_club();">
            <ul class="flex-container">
                <li class="flex-item">
                    Email Address<br>
                    <input type="text" name="email-address" id="email-address" class="input-disabled"
                        value="<?php echo $club_row['Email'] ?>" disabled>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>

                <li class="flex-item">
                    Contact Number <br>
                    <input type="tel" placeholder="e.g. 999-9999999" name="contact-number" id="contact-number"
                        class="input-disabled" value="<?php echo $club_row['Contact_number'] ?>" disabled>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>

                <li class="flex-item">
                    Club Description<br>
                    <textarea name="description" id="description" cols="30" rows="5" class="input-disabled"
                        disabled><?php echo $club_row['Description']; ?></textarea>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>

                <li class="flex-item" id="edit-club-image">
                    Club Image <br>
                    <input type="file" name="image" class="input-disabled" id="image"
                        style="border: none; padding-left: 0;">
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>

                <li class="flex-item activity-details">
                    <h3>Weekly Activity Details</h3>
                </li>

                <li class="flex-item">
                    Day <br>
                    <?php $day_list = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; ?>
                    <select name="day" id="day" class="input-disabled" disabled>
                        <?php foreach ($day_list as $day) : ?>
                        <option value="<?php echo $day ?>" <?php echo ($club_row['Day'] == $day) ? "selected" : ""; ?>>
                            <?php echo $day ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>

                <li class="flex-item">
                    Start Time <br>
                    <input type="text" name="start-time" id="start-time" class="input-disabled" placeholder="e.g. 17:00"
                        value="<?php echo change_time_format($club_row['Start_time']) ?> " disabled>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>

                <li class="flex-item">
                    End Time <br>
                    <input type="text" name="end-time" id="end-time" class="input-disabled" placeholder="e.g. 17:00"
                        value="<?php echo change_time_format($club_row['End_time']) ?>" disabled>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>

                <li class="flex-item">
                    Venue <br>
                    <input type="text" name="venue" id="venue" class="input-disabled"
                        value="<?php echo $club_row['Venue'] ?>" disabled>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>
            </ul>
            <div class="submit-container">
                <input class="submit-btn bg-color-light-green" name="update" id="update-button" type="submit"
                    value="Update">
            </div>
        </form>
    </div>
    <div class="title">Club Events</div>
    <div id="event-content-wrapper">
        <div class="grid-container">
            <?php
            $sql = "SELECT * FROM events WHERE Approval_status = 'Approved' AND Club_ID = '$club_id' ORDER BY Date_posted DESC";
            $result = $conn->query($sql);
            $result_check = mysqli_num_rows($result);
            $event_array = array();
            ?>
            <?php if ($result_check > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <?php
                    $event_id = "event-" . $row['Event_ID'];
                    array_push($event_array, $event_id);
                    ?>
            <div data-event-modal-target="#specific-event" class='grid-item' id="<?php echo $event_id ?>">
                <img title="<?php echo $row['Event_name']; ?>"
                    src="data:image/jpeg;base64,<?php echo base64_encode($row['Event_image']); ?>" alt='event_image'
                    width="403px" height="244px">
                <div class="caption">
                    <h2><?php echo $row['Event_name']; ?></h2>
                    <p>Posted on <?php echo $row['Date_posted']; ?></p>
                </div>
            </div>

            <?php endwhile; ?>
            <?php else : ?>
            <p class="record-not-found">No Upcoming Events</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- View Event -->
    <div class="event-modal" id="specific-event">
        <!-- Modal content -->
        <div class="event-modal-content" id="view-specific-event">
            <div class="modal-title-container">
                <h1 id="title">Event Details</h1>
                <button close-event-button class="close-button">&times;</button>
            </div>
            <form id="view-form" class="event-content-container">
            </form>
        </div>
    </div>

    <!-- Give Feedback -->
    <div class="mymodal" id="feedback">
        <!-- Modal content -->
        <div class="mymodal-content" id="give-feedback">
            <button close-button class="close-btn">&times;</button>
            <h1>Give Feedback</h1>
            <form action="manage_feedback.php" id="feedback-form" method="post" onsubmit="return validate_feedback();">
                <ul class="flex-container">
                    <li class="flex-item">
                        Your Comment<br>
                        <textarea name="comment" id="comment" cols="30" rows="5"></textarea>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>
                </ul>

                <!-- Submit button -->
                <div class="submit-container">
                    <input class="submit-btn bg-color-eastern-blue" type="submit" name="add" value="Submit">
                </div>
            </form>
        </div>
    </div>
    <div id="overlay"></div>

    <div class="title">Club Activities</div>
    <div id="club-activities">
        <?php if ($club_activity_check > 0) : ?>
        <?php while ($club_activity_row = mysqli_fetch_assoc($club_activity_result)) : ?>
        <div class="activity-container">
            <p class="activity-description"><?php echo $club_activity_row['Description'] ?></p>
            <hr>
            <p>
                <img src="../images/date.png" class="icon" alt="date-icon">
                Day: <span><?php echo $club_activity_row['Day']; ?></span>
            </p>
            <p>
                <img src="../images/time.png" class="icon" alt="time-icon">
                Start Time:
                <span><?php echo change_time_format($club_activity_row['Start_time']); ?>
                    (GMT +8)</span>
            </p>
            <p>
                <img src="../images/time.png" class="icon" alt="time-icon">
                End Time:
                <span><?php echo change_time_format($club_activity_row['End_time']); ?> (GMT
                    +8)</span>
            </p>
        </div>
        <?php endwhile; ?>
        <?php else : ?>
        <p class="record-not-found">No Activities</p>
        <?php endif; ?>
    </div>
</article>
<script>
<?php if ($joined_club_row['Role'] == "Committee") : ?>
// Get various elements by id
var editButton = document.getElementById("edit-button");
var updateButton = document.getElementById("update-button");
var editClubImage = document.getElementById("edit-club-image");
var clubContainer = document.getElementById("specific-club-details");

// When the committee clicks on the edit button,
editButton.onclick = function() {
    updateButton.style.display = "block";
    editButton.style.display = "none";
    editClubImage.style.display = "block";
    clubContainer.style.height = "770px";
    $("input[class='input-disabled']").prop('disabled', false);
    $("textarea[class='input-disabled']").prop('disabled', false);
    $("select[class='input-disabled']").prop('disabled', false);
}
<?php endif; ?>

// Alert message if record updated
<?php if (isset($_SESSION['update']) && isset($_SESSION['message'])) : ?>
window.onload = function() {
    alert("<?php echo $_SESSION['message'] ?>");
}
<?php
        unset($_SESSION['update']);
        unset($_SESSION['message']);
    endif;
    ?>

// Action Controller
$(document).ready(function() {
    <?php foreach ($event_array as $event_id) : ?>

    // Load View Event Data When Clicked
    $("#<?php echo $event_id; ?>").click(function() {
        <?php $id = str_replace("event-", "", $event_id) ?>
        var id = "<?php echo $id ?>";

        // Display event name on modal
        <?php
                $sql = "SELECT * FROM events WHERE Event_ID = $id;";
                $result = $conn->query($sql);
                $row = mysqli_fetch_assoc($result);
                ?>
        document.getElementById("title").innerText = "<?php echo $row['Event_name']; ?>";

        // Pass id to another file
        $("#view-form").load("manage_specific_event_data.php", {
            id: id
        });
    });
    <?php endforeach; ?>

});
</script>

<!-- Validate Email Exist Error Script -->
<script defer src="scripts/admin_email_exist_error.js"></script>

<!-- Activate Event Modal Script -->
<script defer src="scripts/event_modal.js"></script>

<!-- Activate Modal Script -->
<script defer src="scripts/modal.js"></script>

<script>
$(document).ready(function() {
    <?php if (isset($_SESSION['access']) && $_SESSION['access'] == false) {
            echo "window.onload = function() {
                    alert('" . $_SESSION['message'] . "')
                }";
            unset($_SESSION['access']);
            unset($_SESSION['message']);
        }
        ?>
});
</script>
<?php
include_once "../admin/includes/alert_message.php";
include_once "includes/footer.php";
mysqli_close($conn);
?>