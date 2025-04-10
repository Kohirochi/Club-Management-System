<?php
include_once "includes/header.php";
?>
<main id="main">
    <h1 class="title">Students</h1>
    <br>
    <hr>
    <article id="students">
        <div class="content-container">
            <form action="" method="post">
                <div class="search-container">
                    <input type="text" name="search-field" id="search-field" placeholder="Student Name">
                    <input class="submit-btn" name="search" id="search-button" type="submit" value="Search">
                </div>
            </form>
            <button data-modal-target="#add" title="Add Student" id="add-button">Add Student</button>
            <div class="table-container">
                <table>
                    <tr>
                        <th class="padding-left">Student Name</th>
                        <th class="padding-left">TP Number</th>
                        <th class="padding-left">Gender</th>
                        <th class="padding-left">Clubs Joined</th>
                        <th class="padding-left">Contact Number</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                    <?php
                    if (isset($_POST['search']) && !empty(trim($_POST['search-field']))) {
                        $search = trim($_POST['search-field']);
                        $student_sql = "SELECT * FROM students WHERE Student_name LIKE '%$search%' ORDER BY Student_name ASC";
                    } else {
                        $student_sql = "SELECT * FROM students ORDER BY Student_name ASC";
                    }
                    
                    $student_result = $conn->query($student_sql);
                    $student_result_check = mysqli_num_rows($student_result);
                    $student_array = array();
                    ?>
                    <?php if ($student_result_check > 0) : ?>
                    <?php while ($student_row = mysqli_fetch_assoc($student_result)) : ?>
                    <?php
                            $student_ID = "S" . $student_row['Student_ID'];
                            array_push($student_array, $student_ID);

                            $joined_club_sql = "SELECT * FROM joined_clubs WHERE Student_ID = " . $student_row['Student_ID'] .  ";";
                            $joined_club_result = $conn->query($joined_club_sql);
                            $joined_club_result_check = mysqli_num_rows($joined_club_result);
                            ?>

                    <?php $joined_clubs = "No Clubs Joined" ?>
                    <?php if ($joined_club_result_check > 0) : ?>
                    <?php $joined_clubs_array = array() ?>
                    <?php while ($joined_club_row = mysqli_fetch_assoc($joined_club_result)) : ?>
                    <?php
                                    $joined_club_id =  $joined_club_row['Club_ID'];
                                    $club_sql = "SELECT * FROM Clubs WHERE Club_ID = $joined_club_id;";
                                    $club_result = $conn->query($club_sql);
                                    $club_row = mysqli_fetch_assoc($club_result);
                                    array_push($joined_clubs_array, $club_row['Club_name']);
                                    ?>
                    <?php endwhile; ?>
                    <?php $joined_clubs = join(", ", $joined_clubs_array) ?>
                    <?php endif; ?>
                    <tr>
                        <td class="padding-left"><?php echo $student_row['Student_name']; ?></td>
                        <td class="padding-left"><?php echo $student_row['TP_number']; ?></td>
                        <td class="padding-left"><?php echo $student_row['Gender']; ?></td>
                        <td class="padding-left"><?php echo $joined_clubs ?></td>
                        <td class="padding-left"><?php echo $student_row['Contact_number']; ?></td>
                        <td style="text-align: center;">
                            <i data-modal-target="#view" title="View" class="fas fa-eye"
                                id="view-button-<?php echo $student_ID; ?>"></i>
                            <i data-modal-target="#edit" title="Edit" class="fas fa-edit"
                                id="edit-button-<?php echo $student_ID; ?>"></i>
                            <a href="admin_students.php"><i title="Delete" class="fas fa-trash-alt"
                                    id="delete-button-<?php echo $student_ID; ?>"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="7">
                            <h2 class="no-record">No Records Found</h2>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </article>

    <!-- View Student -->
    <div class="modal" id="view">
        <!-- Modal content -->
        <div class="modal-content" id="view-student">
            <button close-button class="close">&times;</button>
            <h1>View Student Details</h1>
            <form id="view-form">
            </form>
        </div>
    </div>

    <!-- Edit Student -->
    <div class="modal" id="edit">
        <!-- Modal content -->
        <div class="modal-content" id="edit-student">
            <button close-button class="close">&times;</button>
            <h1>Edit Student Details</h1>
            <form action="manage_student.php" id="edit-form" method="post" onsubmit="return validate_student();">
            </form>
        </div>
    </div>

    <!-- Add Student -->
    <div class="modal" id="add">
        <!-- Modal content -->
        <div class="modal-content" id="add-student">
            <button close-button class="close">&times;</button>
            <h1>Add New Student</h1>
            <form action="manage_student.php" id="add-form" method="post" onsubmit="return validate_student();">
            </form>
        </div>
    </div>
    <div id="overlay"></div>
</main>

<script>
$(document).ready(function() {
    <?php foreach ($student_array as $student_id) : ?>

    // Load View Student Data When Clicked
    $("#view-button-<?php echo $student_id; ?>").click(function() {
        var id = "<?php echo str_replace("S", "", $student_id) ?>";
        var action = "view";
        $("#view-form").load("manage_student_data.php", {
            id: id,
            action: action
        });
    });

    // Load Edit Student Data When Clicked
    $("#edit-button-<?php echo $student_id; ?>").click(function() {
        var id = "<?php echo str_replace("S", "", $student_id) ?>";
        var action = "edit";
        $("#edit-form").load("manage_student_data.php", {
            id: id,
            action: action
        });
    });

    // Load Delete Student Data When Clicked
    $("#delete-button-<?php echo $student_id; ?>").click(function() {
        if (confirm("Are you sure you want to delete this record?")) {
            var id = "<?php echo str_replace("S", "", $student_id) ?>";
            var action = "delete";
            $(window).load("manage_student_data.php", {
                id: id,
                action: action
            });
        }
    });

    <?php endforeach; ?>

    // Load Add Student Data When Clicked
    $("#add-button").click(function() {
        var action = "add";
        $("#add-form").load("manage_student_data.php", {
            action: action
        });
    });
});
</script>

<?php
include_once "includes/alert_message.php";
include_once "includes/footer.php";
?>