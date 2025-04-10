<!-- Database Connnection for View Club Creation Request -->
<?php
include_once "../user/includes/dbh.php";
include_once "includes/change_time_format.php";
session_start();
$club_creation_id = $_POST['id'];

// SQL Query for View Club Creation Request 
$club_creation_sql = "SELECT * FROM club_creation WHERE Club_creation_ID = $club_creation_id;";
$club_creaton_result = mysqli_query($conn, $club_creation_sql);
$club_creation_row = mysqli_fetch_assoc($club_creaton_result);

$_SESSION['club_creation_id'] = $club_creation_id;

$student_id = $club_creation_row['Student_ID'];
$student_sql = "SELECT * FROM students WHERE Student_ID = '$student_id'";
$student_result = mysqli_query($conn, $student_sql);
$student_row = mysqli_fetch_assoc($student_result);
?>

<!-- HTML Content for View Club Creation Request -->

<!-- Club Image for View Club Creation Request -->
<img src="data:image/jpeg;base64,<?php echo base64_encode($club_creation_row['Club_image']); ?>" alt='club_image'>

<ul class="flex-container">
    <li class="flex-item">
        Club Name <br>
        <input type="text" name="club-name" id="club-name" class="input-disabled"
            value="<?php echo $club_creation_row['Club_name'] ?>" disabled>
    </li>

    <li class="flex-item">
        Club Email <br>
        <input type="text" name="email-address" id="email-address" class="input-disabled"
            value="<?php echo $club_creation_row['Club_email'] ?>" disabled>
    </li>

    <li class="flex-item">
        Club Description<br>
        <textarea name="description" id="description" cols="30" rows="5" class="input-disabled"
            disabled><?php echo $club_creation_row['Club_description']; ?></textarea>
    </li>


    <li class="flex-item">
        Purpose<br>
        <textarea name="purpose" id="purpose" cols="30" rows="5" class="input-disabled"
            disabled><?php echo $club_creation_row['Purpose']; ?></textarea>
    </li>

    <li class="flex-item">
        Club Contact Number <br>
        <input type="tel" name="club-contact-number" id="club-contact-number" class="input-disabled"
            value="<?php echo $club_creation_row['Club_contact_number'] ?>" disabled>
    </li>

    <li class="flex-item subtitle">
        <h3>Student Details</h3>
    </li>

    <li class="flex-item">
        Student Name <br>
        <input type="text" name="student-name" id="student-name" class="input-disabled"
            value="<?php echo $student_row['Student_name'] ?>" disabled>
    </li>

    <li class="flex-item">
        Student Contact Number <br>
        <input type="tel" name="student-contact-number" id="student-contact-number" class="input-disabled"
            value="<?php echo $student_row['Contact_number'] ?>" disabled>
    </li>

    <li class="flex-item">
        TP Number <br>
        <input type="text" name="tp-number" id="tp-number" class="input-disabled"
            value="<?php echo $student_row['TP_number'] ?>" disabled>
    </li>

    <li class="flex-item subtitle">
        <h3>Activity Details</h3>
    </li>

    <li class="flex-item">
        Day <br>
        <input type="text" name="day" id="day" class="input-disabled" value="<?php echo $club_creation_row['Day'] ?>"
            disabled>
    </li>

    <li class="flex-item">
        Start Time <br>
        <input type="text" name="start-time" id="start-time" class="input-disabled"
            value="<?php echo change_time_format($club_creation_row['Start_time']) ?>" disabled>
    </li>

    <li class="flex-item">
        End Time <br>
        <input type="text" name="end-time" id="end-time" class="input-disabled"
            value="<?php echo change_time_format($club_creation_row['End_time']) ?>" disabled>
    </li>

    <li class="flex-item">
        Venue <br>
        <input type="text" name="venue" id="venue" class="input-disabled"
            value="<?php echo $club_creation_row['Venue'] ?>" disabled>
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