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
?>
<article id="specific-club-member-list">
    <div class="logo-container">
        <img title="Club logo" src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>">
    </div>
    <h1 class="title"><?php echo $club_row['Club_name']; ?></h1>
    <div class="content-container">
        <h2>Club Registration Requests List</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th class="padding-left">Student Name</th>
                    <th class="padding-left">TP Number</th>
                    <th class="padding-left">Email Address</th>
                    <th class="padding-left">Contact Number</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
                <?php
                $club_registration_sql = "SELECT C.*, S.* FROM club_registration AS C JOIN students AS S ON C.Student_ID = S.Student_ID WHERE C.Club_ID = '$club_id' ORDER BY C.Club_registration_ID ASC";
                $club_registration_result = $conn->query($club_registration_sql);
                $club_registration_result_check = mysqli_num_rows($club_registration_result);
                $club_registration_array = array();
                ?>
                <?php if ($club_registration_result_check > 0) : ?>
                <?php while ($club_registration_row = mysqli_fetch_assoc($club_registration_result)) : ?>
                <?php
                        $club_registration_id = "CR" . $club_registration_row['Club_registration_ID'];
                        array_push($club_registration_array, $club_registration_id);
                        ?>
                <tr>
                    <td class="padding-left"><?php echo $club_registration_row['Student_name']; ?></td>
                    <td class="padding-left"><?php echo $club_registration_row['TP_number']; ?></td>
                    <td class="padding-left"><?php echo $club_registration_row['Email']; ?></td>
                    <td class="padding-left"><?php echo $club_registration_row['Contact_number']; ?></td>
                    <td style="text-align: center;">
                        <i data-modal-target="#view" title="View" class="fas fa-eye"
                            id="view-button-<?php echo $club_registration_id; ?>"></i>
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
</article>

<!-- View Club Creation Request -->
<div class="mymodal" id="view">
    <!-- Modal content -->
    <div class="mymodal-content" id="view-club-registration-request">
        <button close-button class="close-btn">&times;</button>
        <h1>View Club Registration Request</h1>
        <form action="manage_club_registration_request.php" id="view-form" method="post">

        </form>
    </div>
</div>
<div id="overlay"></div>
</main>

<script>
$(document).ready(function() {
    <?php foreach ($club_registration_array as $club_registration_id) : ?>

    // Load View Club Creation Request Data When Clicked
    $("#view-button-<?php echo $club_registration_id; ?>").click(function() {
        var id = "<?php echo str_replace("CR", "", $club_registration_id) ?>";
        $("#view-form").load("manage_club_registration_request_data.php", {
            id: id,
        });
    });
    <?php endforeach; ?>
});
</script>

<!-- Activate Modal Script -->
<script defer src="scripts/modal.js"></script>

<?php
include_once "../admin/includes/alert_message.php";
include_once "./includes/footer.php";
?>