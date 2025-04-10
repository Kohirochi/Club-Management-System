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
        <h2>Club Member List</h2>
        <form action="" method="post">
            <div class="search-container">
                <input type="text" name="search-field" id="search-field" placeholder="Student Name">
                <input class="submit-btn" name="search" id="search-button" type="submit" value="Search">
            </div>
        </form>
        <div class="table-container">
            <table>
                <tr>
                    <th class="padding-left">Student Name</th>
                    <th class="padding-left">TP Number</th>
                    <th class="padding-left">Gender</th>
                    <th class="padding-left">Contact Number</th>
                    <th class="padding-left">Role</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
                <?php
                // Get members data that joined the club
                if (isset($_POST['search']) && !empty(trim($_POST['search-field']))) {
                    $search = trim($_POST['search-field']);
                    $joined_club_sql = "SELECT J.*, S.* FROM joined_clubs AS J JOIN students AS S ON J.Student_ID = S.Student_ID WHERE J.Club_ID = '$club_id' AND S.Student_name LIKE '%$search%' ORDER BY Student_name ASC";
                } else {
                    $joined_club_sql = "SELECT * FROM joined_clubs WHERE Club_ID = '$club_id';";
                }
                $joined_club_result = $conn->query($joined_club_sql);
                $joined_club_result_check = mysqli_num_rows($joined_club_result);
                ?>
                <?php if ($joined_club_result_check > 0) : ?>
                <?php while ($joined_club_row = mysqli_fetch_assoc($joined_club_result)) : ?>
                <?php
                        $student_sql = "SELECT * FROM students WHERE Student_ID =" . $joined_club_row['Student_ID'] .  ";";
                        $student_result = $conn->query($student_sql);
                        $student_row = mysqli_fetch_assoc($student_result);

                        $student_ID = "S" . $student_row['Student_ID'];
                        ?>
                <tr>
                    <td class="padding-left"><?php echo $student_row['Student_name']; ?></td>
                    <td class="padding-left"><?php echo $student_row['TP_number']; ?></td>
                    <td class="padding-left"><?php echo $student_row['Gender']; ?></td>
                    <td class="padding-left"><?php echo $student_row['Contact_number']; ?></td>
                    <td class="padding-left"><?php echo $joined_club_row['Role'] ?></td>

                    <td style="text-align: center;">
                        <?php if ($joined_club_row['Role'] == "Member") : ?>
                        <a href="#specific-club-member-list" onclick="return window.location.reload()">
                            <i title="Promote to Committee" class="fas fa-angle-double-up"
                                id="promote-button-<?php echo $student_ID; ?>"></i></a>
                        <?php endif; ?>
                        <a href="#specific-club-member-list" onclick="return window.location.reload()">
                            <i title="Delete" class="fas fa-trash-alt"
                                id="delete-button-<?php echo $student_ID; ?>"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else : ?>
                <tr>
                    <td colspan="6">
                        <h3 class="no-record">No Records Found</h3>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</article>

<script>
$(document).ready(function() {
    var club_id = "<?php echo $club_id; ?>";

    // Get member of the specific club 
    <?php
        $club_member_sql = "SELECT * FROM joined_clubs WHERE Club_ID = '$club_id';";
        $club_member_result = $conn->query($club_member_sql);
        $club_member_result_check = mysqli_num_rows($club_member_result);
        ?>

    // Loop through each member in the club
    <?php if ($club_member_result_check > 0) : ?>
    <?php while ($club_member_row = mysqli_fetch_assoc($club_member_result)) : ?>

    // Get student data using id
    <?php
                $student_id = $club_member_row['Student_ID'];
                $specific_student_sql = "SELECT * FROM students WHERE Student_ID = '$student_id';";
                $specific_student_result = $conn->query($specific_student_sql);
                $specific_student_row = mysqli_fetch_assoc($specific_student_result)
                ?>

    // Get student role in the club
    <?php
                $club_member_details_sql = "SELECT * FROM joined_clubs WHERE Club_ID = '$club_id' AND Student_ID = '$student_id';";
                $club_member_details_result = $conn->query($club_member_details_sql);
                $club_member_details_row = mysqli_fetch_assoc($club_member_details_result);

                // Display different icon based on the role
                if ($club_member_details_row['Role'] == 'Member') :
                ?>


    // Load Promote Club Member When Clicked
    $("#promote-button-S<?php echo $student_id; ?>").click(function() {
        if (confirm(
                "Are you sure you want to promote <?php echo $specific_student_row['Student_name'] ?> to committee?"
            )) {
            var student_id = "<?php echo $student_id; ?>";
            var action = "promote";

            $(window).load("manage_club_members.php", {
                student_id: student_id,
                club_id: club_id,
                action: action
            });
        }
    });

    <?php endif; ?>


    // Load Delete Club Member When Clicked
    $("#delete-button-S<?php echo $student_id; ?>").click(function() {
        if (confirm("Are you sure you want to delete this record?")) {
            var student_id = "<?php echo $student_id; ?>";
            var action = "delete";
            $(window).load("manage_club_members.php", {
                student_id: student_id,
                club_id: club_id,
                action: action
            });
        }
    });

    <?php endwhile; ?>
    <?php endif; ?>

});
</script>

<?php
include_once "../admin/includes/alert_message.php";
include_once "includes/footer.php";
?>