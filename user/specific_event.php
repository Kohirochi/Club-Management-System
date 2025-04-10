<?php
include_once "includes/header.php";
include_once "includes/dbh.php";


$sql = "SELECT * FROM events WHERE Approval_status = 'Approved' ORDER BY Date_posted DESC";
$result = $conn->query($sql);
$result_check = mysqli_num_rows($result);

?>
<main id="specific-event">
    <h1 class="title">Events</h1>
    <div class="grid-container">
        <?php
        $sql = "SELECT * FROM events WHERE Approval_status = 'Approved' ORDER BY Date_posted DESC";
        $result = $conn->query($sql);
        $result_check = mysqli_num_rows($result);
        ?>
        <?php if ($result_check > 0) : ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <a href="specific_event.php?event=<?php echo $row['Event_name']; ?>">
            <div class='grid-item'>
                <img title="<?php echo $row['Event_name']; ?>"
                    src="data:image/jpeg;base64,<?php echo base64_encode($row['Event_image']); ?>" alt='event_image'
                    width="403px" height="244px">
                <div class="caption">
                    <h2><?php echo $row['Event_name']; ?></h2>
                    <p>Posted on <?php echo $row['Date_posted']; ?></p>
                </div>
            </div>
        </a>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>
<?php
include_once "includes/footer.php";
mysqli_close($conn);
?>