<?php
include_once "includes/header.php";
?>
<main id="main">
    <h1 class="title">Clubs</h1>
    <br>
    <hr>
    <article id="clubs">
        <button data-modal-target="#add" title="Add Club" id="add-button">Add Club</button>
        <div class="grid-container">
            <?php $sql = "SELECT * FROM clubs ORDER BY Club_name ASC";
                $result = $conn->query($sql);
                $result_check = mysqli_num_rows($result);
                ?>
            <?php if ($result_check > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <a href="admin_specific_club.php?club=<?php echo $row['Club_name']; ?>">
                <div class='grid-item'>
                    <div class="img-container">
                        <img title="<?php echo $row['Club_name']; ?>"
                            src="data:image/jpeg;base64,<?php echo base64_encode($row['Club_image']); ?>"
                            alt='club_image'>
                    </div>
                    <h2><?php echo $row['Club_name']; ?></h2>
                </div>
            </a>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </article>

    <!-- Add Club -->
    <div class="modal" id="add">
        <!-- Modal content -->
        <div class="modal-content" id="add-club">
            <button close-button class="close">&times;</button>
            <h1>Add New Club</h1>
            <form action="manage_club.php" id="add-form" method="post" enctype="multipart/form-data"
                onsubmit="return validate_add_club();">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</main>

<script>
$(document).ready(function() {

    // Load Add Club Data When Clicked
    $("#add-button").click(function() {
        $("#add-form").load("manage_club_data.php");
    });
});
</script>

<?php
include_once "includes/alert_message.php";
include_once "includes/footer.php";
?>