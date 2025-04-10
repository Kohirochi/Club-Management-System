<?php
include_once "includes/header.php";
include_once "includes/change_time_format.php";

$club_name = $_GET['club'];
$club_sql = "SELECT * FROM clubs WHERE Club_name = '$club_name';";
$club_details = $conn->query($club_sql);
$club_row = mysqli_fetch_assoc($club_details);
$club_id = $club_row['Club_ID'];
$_SESSION['club_id'] = $club_id;
?>

<main id="main">
    <h1 class="title"><?php echo $club_row['Club_name'] ?></h1>
    <br>
    <hr>
    <article id="specific-club">
        <div class="content-container" id="specific-club-details">
            <div class="title-container">
                <h2>Club Settings</h2>
                <form action="manage_specific_club.php" method="post" onsubmit="return delete_confirmation();">
                    <button title="Delete" name="delete" type="submit" id="delete-button">
                        <i class="fas fa-trash-alt"></i>Delete
                    </button>
                </form>
                <button title="Edit" id="edit-button">
                    <i class="fas fa-edit"></i>Edit
                </button>
            </div>
            <form action="manage_specific_club.php" method="post" enctype="multipart/form-data"
                onsubmit="return validate_edit_club();">
                <img id="club-image" src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>"
                    alt='club_image'>
                <ul class="flex-container">
                    <li class="flex-item">
                        Club Name <br>
                        <input type="text" name="club-name" id="name" class="input-disabled"
                            value="<?php echo $club_row['Club_name'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item">
                        Email Address<br>
                        <input type="text" name="email-address" id="email-address" class="input-disabled"
                            value="<?php echo $club_row['Email'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item">
                        Contact Number <br>
                        <input type="tel" placeholder="e.g. 999-9999999" name="contact-number" id="contact-number"
                            class="input-disabled" value="<?php echo $club_row['Contact_number'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item">
                        Club Description<br>
                        <textarea name="description" id="description" cols="30" rows="5" class="input-disabled"
                            disabled><?php echo $club_row['Description']; ?></textarea>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item" id="edit-club-image">
                        Club Image <br>
                        <input type="file" name="image" class="input-disabled" id="image"
                            style="border: none; padding-left: 0;">
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item activity-details">
                        <h3>Activity Details</h3>
                    </li>

                    <li class="flex-item">
                        Day <br>
                        <?php $day_list = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; ?>
                        <select name="day" id="day" class="input-disabled" disabled>
                            <?php foreach ($day_list as $day) : ?>
                            <option value="<?php echo $day ?>"
                                <?php echo ($club_row['Day'] == $day) ? "selected" : ""; ?>><?php echo $day ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item">
                        Start Time <br>
                        <input type="text" name="start-time" id="start-time" class="input-disabled"
                            placeholder="e.g. 17:00" value="<?php echo change_time_format($club_row['Start_time']) ?> "
                            disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item">
                        End Time <br>
                        <input type="text" name="end-time" id="end-time" class="input-disabled" placeholder="e.g. 17:00"
                            value="<?php echo change_time_format($club_row['End_time']) ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>

                    <li class="flex-item">
                        Venue <br>
                        <input type="text" name="venue" id="venue" class="input-disabled"
                            value="<?php echo $club_row['Venue'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>
                </ul>
                <div class="submit-container">
                    <input class="submit-btn bg-color-light-green" name="update" id="update-button" type="submit"
                        value="Update">
                </div>
            </form>
        </div>
    </article>

    <article id="specific-club-member-list">
        <div class="content-container">
            <h2>Club Member List</h2>
            <form action="" method="post" onsubmit="window.location.href = '#specific-club-member-list'">
                <div class="search-container">
                    <input type="text" name="search-field" id="search-field" placeholder="Student Name">
                    <input class="submit-btn" name="search" id="search-button" type="submit" value="Search">
                </div>
            </form>
            <button data-modal-target="#add" title="Add Member" id="add-button">Add Member</button>
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
                            <?php else : ?>
                            <a href="#specific-club-member-list" onclick="return window.location.reload()">
                                <i title="Demote to Member" class="fas fa-angle-double-down"
                                    id="demote-button-<?php echo $student_ID; ?>"></i></a>
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

    <!-- Add Club Member -->
    <div class="modal" id="add">
        <!-- Modal content -->
        <div class="modal-content" id="add-club-member">
            <button close-button class="close">&times;</button>
            <h1>Add New Member</h1>
            <form action="manage_add_club_member.php" id="add-form" method="post"
                onsubmit="return validate_add_club_member();">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</main>

<script>
// Get various elements by id
var editButton = document.getElementById("edit-button");
var updateButton = document.getElementById("update-button");
var clubImage = document.getElementById("club-image");
var editClubImage = document.getElementById("edit-club-image");
var clubContainer = document.getElementById("specific-club-details");

// When the user clicks on the edit button,
editButton.onclick = function() {
    updateButton.style.display = "block";
    editButton.style.display = "none";
    editClubImage.style.display = "block";
    clubImage.style.display = "none";
    clubContainer.style.height = "820px";
    $("input[class='input-disabled']").prop('disabled', false);
    $("textarea[class='input-disabled']").prop('disabled', false);
    $("select[class='input-disabled']").prop('disabled', false);
}

// Alert message if record updated
<?php if (isset($_SESSION['update']) && isset($_SESSION['message'])) : ?>
window.onload = function() {
    alert("<?php echo $_SESSION['message'] ?>");
}
<?php
        unset($_SESSION['update']);
        unset($_SESSION['message']);
    endif;
    ?>


// Action Controller
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

            $(window).load("manage_specific_club_member.php", {
                student_id: student_id,
                club_id: club_id,
                action: action
            });
        }
    });

    <?php else : ?>

    //Load Demote Club Committee When Clicked
    $("#demote-button-S<?php echo $student_id; ?>").click(function() {
        if (confirm(
                "Are you sure you want to demote <?php echo $specific_student_row['Student_name'] ?> to member?"
            )) {
            var student_id = "<?php echo $student_id; ?>";
            var action = "demote";
            $(window).load("manage_specific_club_member.php", {
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
            $(window).load("manage_specific_club_member.php", {
                student_id: student_id,
                club_id: club_id,
                action: action
            });
        }
    });

    <?php endwhile; ?>
    <?php endif; ?>

    // Load Add Club Data When Clicked
    $("#add-button").click(function() {
        var action = "add";
        $("#add-form").load("manage_specific_club_member.php", {
            club_id: club_id,
            action: action
        });
    });
});
</script>
<!-- Validate Email Exist Error Script -->
<script defer src="scripts/admin_email_exist_error.js"></script>


<?php
include_once "includes/alert_message.php";
include_once "includes/footer.php";
?>