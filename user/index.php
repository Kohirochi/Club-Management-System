<?php
include_once "includes/header.php";
include_once "includes/dbh.php";
?>
<article id="clubs">
    <div class="title">Clubs</div>
    <?php if (isset($_SESSION['student_id'])) : ?>
    <button data-modal-target="#create" title="Create New Club" id="create-button">Create New Club</button>
    <?php endif; ?>
    <div class="grid-container" <?php echo (isset($_SESSION['student_id'])) ?  "" : "style='margin: 30px 80px;'"; ?>>
        <?php $sql = "SELECT * FROM clubs ORDER BY Club_name ASC";
        $result = $conn->query($sql);
        $result_check = mysqli_num_rows($result);
        ?>
        <?php if ($result_check > 0) : ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <a href="specific_club.php?club=<?php echo $row['Club_name']; ?>">
            <div class='grid-item'>
                <div class="img-container">
                    <img title="<?php echo $row['Club_name']; ?>"
                        src="data:image/jpeg;base64,<?php echo base64_encode($row['Club_image']); ?>" alt='club_image'>
                </div>
                <h2><?php echo $row['Club_name']; ?></h2>
            </div>
        </a>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Create New Club -->
    <div class="mymodal" id="create">
        <!-- Modal content -->
        <div class="mymodal-content" id="create-club">
            <button close-button class="close-btn">&times;</button>
            <h1>Create New Club</h1>
            <form action="manage_create_club.php" id="create-form" method="post" enctype="multipart/form-data"
                onsubmit="return validate_create_club();">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</article>

<script>
$(document).ready(function() {
    // Load Create New Club Data When Clicked
    $("#create-button").click(function() {
        $("#create-form").load("manage_create_club_data.php");
    });
});
</script>

<!-- Activate Modal Script -->
<script defer src="scripts/modal.js"></script>
<?php
include_once "../admin/includes/alert_message.php";
include_once "includes/footer.php";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    echo "<script>window.onload = function() {alert('" . $_SESSION['message'] . "')};</script>";
    unset($_SESSION['login']);
    unset($_SESSION['message']);
}

mysqli_close($conn);
?>