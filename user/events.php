<?php
include_once "includes/header.php";
include_once "includes/dbh.php";
?>
<article id="event-content-wrapper">
    <div class="title">Events</div>
    <div class="grid-container">
        <?php
        $sql = "SELECT * FROM events WHERE Approval_status = 'Approved' ORDER BY Date_posted DESC";
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
        <?php endif; ?>
    </div>

    <!-- Edit Event -->
    <div class="event-modal" id="specific-event">
        <!-- Modal content -->
        <div class="event-modal-content" id="edit-event">
            <div class="modal-title-container">
                <h1 id="title">Event Details</h1>
                <button close-event-button class="close-button">&times;</button>
            </div>
            <form id="view-form" class="event-content-container">
            </form>
        </div>
    </div>


    <div id="overlay"></div>
</article>
<script>
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

<!-- Activate Event Modal Script -->
<script defer src="scripts/event_modal.js"></script>

<?php
include_once "includes/footer.php";
mysqli_close($conn);
?>