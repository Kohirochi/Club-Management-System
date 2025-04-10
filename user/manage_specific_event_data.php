<?php
include_once "includes/dbh.php";
include_once "../admin/includes/change_time_format.php";
$id = $_POST['id'];

// Get Event Details
$event_sql_query = "SELECT * FROM events WHERE Event_ID = $id;";
$event_result = mysqli_query($conn, $event_sql_query);
$event_row = mysqli_fetch_assoc($event_result);

// Get Club Name
$club_id = $event_row['Club_ID'];
$club_sql_query = "SELECT * FROM clubs WHERE Club_ID = $club_id";
$club_result = mysqli_query($conn, $club_sql_query);
$club_row = mysqli_fetch_assoc($club_result);
?>
<div id="event-content">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($event_row['Event_image']); ?>" alt='event_image'>
    <div id="event-details">
        <h1><?php echo $event_row['Event_name'] ?></h1>
        <p id="description">
            <?php echo $event_row['Description'] ?>
        </p>
        <p>
            <img src="../images/date.png" class="icon" alt="date-icon">
            Date: <span><?php echo $event_row['Date']; ?></span>
        </p>
        <p>
            <img src="../images/time.png" class="icon" alt="time-icon">
            Start Time:
            <span><?php echo change_time_format($event_row['Start_time']); ?>
                (GMT +8)</span>
        </p>
        <p>
            <img src="../images/time.png" class="icon" alt="time-icon">
            End Time:
            <span><?php echo change_time_format($event_row['End_time']); ?> (GMT
                +8)</span>
        </p>
        <p>
            <img src="../images/club.png" class="icon" alt="Organizer-icon">
            Organized By: <span><?php echo $club_row['Club_name']; ?></span>
        </p>
        <p>
            Contact Details
            <br>
            <img src="../images/email.png" class="icon" alt="email-icon">
            Email address: <span><?php echo $club_row['Email']; ?></span>
            <br>
            <img src="../images/phone.png" class="icon">
            Phone number: <span><?php echo $club_row['Contact_number']; ?></span>
        </p>
        <p>
            Registration Link : <a href="<?php echo $event_row['Link']; ?>"
                target="_blank"><?php echo $event_row['Link']; ?></a>
        </p>
    </div>
</div>

<script>
// Scroll to top when user open the modal
$('#view-form').scrollTop(0);
</script>