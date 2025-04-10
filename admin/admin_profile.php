<?php
include_once "includes/header.php";

$id = $_SESSION['admin_id'];
$sql_query = "SELECT * FROM admin WHERE Admin_ID = '$id';";
$result = mysqli_query($conn, $sql_query);
$row = mysqli_fetch_assoc($result);

?>
<main id="main">
    <h1 class="title">Profile</h1>
    <br>
    <hr>
    <article id="profile">
        <div class="content-container" id="profile-details">
            <div class="title-container">
                <h2>Profile Settings</h2>
                <button title="Edit" id="edit-button">
                    <i class="fas fa-user-edit"></i>Edit
                </button>
            </div>
            <form action="admin_update_profile.php" method="post" onsubmit="return validate_admin_profile();">
                <ul class="flex-container">
                    <li class="flex-item">
                        Admin Name <br>
                        <input type="text" name="admin-name" id="user-name" class="input-disabled"
                            value="<?php echo $row['Admin_name'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>
                    <li class="flex-item">
                        TP Number <br>
                        <input type="text" name="tp-number" id="tp-number" class="input-disabled"
                            value="<?php echo $row['TP_number'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>
                    <li class="flex-item">
                        Email Address <br>
                        <input type="text" name="email-address" id="email-address" class="input-disabled"
                            value="<?php echo $row['Email'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>
                    <li class="flex-item">
                        Password <br>
                        <input type="text" name="password" id="password" class="input-disabled"
                            value="<?php echo $row['Password'] ?>" disabled>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </li>
                    <li class="flex-item">
                        Contact Number <br>
                        <input type="tel" name="contact-number" id="contact-number" class="input-disabled"
                            value="<?php echo $row['Contact_number'] ?>" disabled>
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
</main>
<script>
// Get edit and update button
var editButton = document.getElementById("edit-button");
var updateButton = document.getElementById("update-button");

// When the user clicks on the edit button,
editButton.onclick = function() {
    updateButton.style.display = "block";
    editButton.style.display = "none";
    $("input[class='input-disabled']").prop('disabled', false);
}
</script>

<!-- Validate Email Exist Error Script -->
<script defer src="scripts/admin_email_exist_error.js"></script>

<!-- Validate TP Number Exist Error Script -->
<script defer src="scripts/tp_exist_error.js"></script>

<?php
include_once "includes/alert_message.php";
include_once "includes/footer.php";
?>