<?php
include_once "includes/header.php";
include_once "includes/change_time_format.php";
?>
<main id="main">
    <h1 class="title">Club Creation Requests</h1>
    <br>
    <hr>
    <article id="club-creation-requests">
        <div class="content-container">
            <div class="table-container">
                <table>
                    <tr>
                        <th class="padding-left" style="min-width: 90px; text-align:center;">Club Image</th>
                        <th class="padding-left" style="min-width: 100px;">Club Name</th>
                        <th class="padding-left" style="min-width: 600px;">Club Description</th>
                        <th class="padding-left" style="min-width: 130px;">Student Name</th>
                        <th class="padding-left" style="min-width: 130px; text-align:center;">Student Contact Number
                        </th>
                        <th style="min-width: 70px; text-align: center;">Actions</th>
                    </tr>
                    <?php
                    $club_creation_sql = "SELECT * FROM club_creation ORDER BY Club_creation_ID ASC";
                    $club_creation_result = $conn->query($club_creation_sql);
                    $club_creation_result_check = mysqli_num_rows($club_creation_result);
                    $club_creation_array = array();
                    ?>
                    <?php if ($club_creation_result_check > 0) : ?>
                    <?php while ($club_row = mysqli_fetch_assoc($club_creation_result)) : ?>
                    <?php
                            $club_creation_id = "CC" . $club_row['Club_creation_ID'];
                            array_push($club_creation_array, $club_creation_id);

                            $student_id = $club_row['Student_ID'];
                            $student_sql = "SELECT * FROM students WHERE Student_ID = '$student_id'";
                            $student_result = $conn->query($student_sql);
                            $student_row = mysqli_fetch_assoc($student_result);
                            ?>
                    <tr>
                        <td style="text-align: center;"><img
                                src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>"
                                alt="club_image">
                        </td>
                        <td class="padding-left"><?php echo $club_row['Club_name']; ?></td>
                        <td class="padding-left"><?php echo $club_row['Club_description']; ?></td>
                        <td class="padding-left"><?php echo $student_row['Student_name']; ?></td>
                        <td class="padding-left"><?php echo $student_row['Contact_number']; ?></td>
                        <td style="text-align: center;">
                            <i data-modal-target="#view" title="View" class="fas fa-eye"
                                id="view-button-<?php echo $club_creation_id; ?>"></i>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="6">
                            <h2 class="no-record">No Records Found</h2>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </article>

    <!-- View Club Creation Request -->
    <div class="modal" id="view">
        <!-- Modal content -->
        <div class="modal-content" id="view-club-creation-request">
            <button close-button class="close">&times;</button>
            <h1>View Club Creation Request</h1>
            <form action="manage_club_creation_request.php" id="view-form" method="post">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</main>

<script>
$(document).ready(function() {
    <?php foreach ($club_creation_array as $club_creation_id) : ?>

    // Load View Club Creation Request Data When Clicked
    $("#view-button-<?php echo $club_creation_id; ?>").click(function() {
        var id = "<?php echo str_replace("CC", "", $club_creation_id) ?>";
        $("#view-form").load("manage_club_creation_request_data.php", {
            id: id,
        });
    });
    <?php endforeach; ?>
});
</script>

<?php
include_once "includes/alert_message.php";
include_once "includes/footer.php";
?>