<!-- Database Connnection for View Club Creation Request -->
<?php
include_once "includes/dbh.php";
include_once "../admin/includes/change_time_format.php";
session_start();
$student_id = $_SESSION['student_id'];

// SQL Query for View Club Creation Request 
$student_sql = "SELECT * FROM students WHERE Student_ID = '$student_id'";
$student_result = mysqli_query($conn, $student_sql);
$student_row = mysqli_fetch_assoc($student_result);
?>

<!-- HTML Content for View Club Creation Request -->

<ul class="flex-container">
    <li class="flex-item">
        Club Name <br>
        <input type="text" name="club-name" id="name">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Club Email <br>
        <input type="text" name="email-address" id="email-address">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Club Description<br>
        <textarea name="description" id="description" cols="30" rows="5"></textarea>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>


    <li class="flex-item">
        Purpose<br>
        <textarea name="purpose" id="purpose" cols="30" rows="5"></textarea>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Club Contact Number <br>
        <input type="tel" name="club-contact-number" id="contact-number">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Club Image <br>
        <input type="file" name="image" id="image" style="border: none; padding-left: 0;">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item subtitle">
        <h3>Student Details</h3>
    </li>

    <li class="flex-item">
        Student Name <br>
        <input type="text" name="student-name" id="student-name" value="<?php echo $student_row['Student_name'] ?>"
            disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Student Contact Number <br>
        <input type="tel" name="student-contact-number" value="<?php echo $student_row['Contact_number'] ?>"
            id="student-contact-number" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        TP Number <br>
        <input type="text" name="tp-number" id="tp-number" value="<?php echo $student_row['TP_number'] ?>" disabled>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item subtitle">
        <h3>Activity Details</h3>
    </li>

    <li class="flex-item">
        Day <br>
        <?php $day_list = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; ?>
        <select name="day" id="day">
            <option value="" selected disabled hidden>Please select</option>
            <?php foreach ($day_list as $day) : ?>
            <option value="<?php echo $day ?>"><?php echo $day ?></option>
            <?php endforeach; ?>
        </select>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Start Time <br>
        <input type="text" name="start-time" id="start-time">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        End Time <br>
        <input type="text" name="end-time" id="end-time">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Venue <br>
        <input type="text" name="venue" id="venue">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

</ul>

<div class="submit-container">
    <input class="submit-btn bg-color-eastern-blue" name="add" type="submit" value="Submit">
</div>

<!-- Close Database Connection -->
<?php
mysqli_close($conn);
?>