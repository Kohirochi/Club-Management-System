<?php
include_once "includes/header.php";
include_once "includes/dbh.php";

$club_name = $_GET['club'];
$club_sql = "SELECT * FROM clubs WHERE Club_name = '$club_name';";
$club_details = $conn->query($club_sql);
$club_row = mysqli_fetch_assoc($club_details);
$club_id = $club_row['Club_ID'];

include_once "includes/committee_authentication.php";
include_once "includes/sidenav.php";

$_SESSION['club_id'] = $club_id;

$feedback_sql = "SELECT * FROM club_feedback WHERE Club_ID = '$club_id';";
$feedback_result = $conn->query($feedback_sql);
$feedback_result_check = mysqli_num_rows($feedback_result);
?>
<article id="specific-club-feedback-list">
    <div class="logo-container">
        <img title="Club logo" src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>">
    </div>
    <h1 class="title"><?php echo $club_row['Club_name']; ?></h1>
    <div class="title">Club Feedback List</div>
    <div id="club-feedback">
        <?php if ($feedback_result_check > 0) : ?>
        <?php while ($feedback_row = mysqli_fetch_assoc($feedback_result)) : ?>
        <div class="feedback-container">
            <p class="comment"><?php echo $feedback_row['Comment'] ?></p>
        </div>
        <?php endwhile; ?>
        <?php else : ?>
        <p class="record-not-found">No Feedback Given</p>

        <?php endif; ?>
    </div>
</article>

<?php
include_once "./includes/footer.php";
?>