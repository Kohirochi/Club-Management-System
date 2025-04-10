<?php
include_once "includes/header.php";
include_once "includes/student_authentication.php";
include_once "includes/dbh.php";
?>
<article id="joined-clubs">
    <h1 class="title">Joined Clubs</h1>
    <div class="grid-container">
        <?php
        $id = $_SESSION['student_id'];
        $sql = "SELECT C.*, J.* FROM clubs AS C JOIN joined_clubs AS J ON C.Club_ID = J.Club_ID WHERE J.Student_ID = '$id' ORDER BY C.Club_name ASC";
        $result = $conn->query($sql);
        $result_check = mysqli_num_rows($result);
        ?>
        <?php if ($result_check > 0) : ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <a href="specific_joined_club.php?club=<?php echo $row['Club_name']; ?>">
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
</article>

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