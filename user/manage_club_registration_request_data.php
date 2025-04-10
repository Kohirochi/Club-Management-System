<?php
include_once "./includes/dbh.php";
session_start();
$club_registration_id = $_POST['id'];

// SQL Query for View Club Creation Request 
$club_registration_sql = "SELECT C.*, S.* FROM club_registration AS C JOIN students AS S ON C.Student_ID = S.Student_ID WHERE C.Club_registration_ID = '$club_registration_id'";
$club_registration_result = $conn->query($club_registration_sql);
$club_registration_row = mysqli_fetch_assoc($club_registration_result);

$_SESSION['club_registration_id'] = $club_registration_id;
?>

<ul class="flex-container">
    <li class="flex-item">
        Student Name <br>
        <input type="text" name="student-name" id="student-name" class="input-disabled"
            value="<?php echo $club_registration_row['Student_name'] ?>" disabled>
    </li>

    <li class="flex-item">
        TP Number <br>
        <input type="text" name="tp-number" id="tp-number" class="input-disabled"
            value="<?php echo $club_registration_row['TP_number'] ?>" disabled>
    </li>

    <li class="flex-item">
        Email Address <br>
        <input type="text" name="email-address" id="email-address" class="input-disabled"
            value="<?php echo $club_registration_row['Email'] ?>" disabled>
    </li>

    <li class="flex-item">
        Student Contact Number <br>
        <input type="tel" name="student-contact-number" id="student-contact-number" class="input-disabled"
            value="<?php echo $club_registration_row['Contact_number'] ?>" disabled>
    </li>
</ul>

<div class="submit-container">
    <input id="approve-btn" class="submit-btn" type="submit" name="approve" value="Approve">
    <input id="reject-btn" class="submit-btn" type="submit" name="reject" value="Reject">
</div>

<!-- Close Database Connection -->
<?php
mysqli_close($conn);
?>