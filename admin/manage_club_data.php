<!-- Database Connnection for Add Record -->
<?php
include_once "../user/includes/dbh.php";
include_once "includes/change_time_format.php";
?>

<!-- HTML Content for Add Record -->

<ul class="flex-container">
    <li class="flex-item">
        Club Name <br>
        <input type="text" name="club-name" id="name">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Email Address<br>
        <input type="text" name="email-address" id="email-address">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        Contact Number <br>
        <input type="tel" placeholder="e.g. 999-9999999" name="contact-number" id="contact-number">
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

    <!-- Profile Picture for Add Club -->
    <li class="flex-item">
        Club Image <br>
        <input type="file" name="image" id="image" style="border: none; padding-left: 0;">
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
        <input type="text" name="start-time" id="start-time" placeholder="e.g. 17:00">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </li>

    <li class="flex-item">
        End Time <br>
        <input type="text" name="end-time" id="end-time" placeholder="e.g. 17:00">
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

<!-- HTML Content for Add Record -->
<div class="submit-container">
    <input class="submit-btn bg-color-eastern-blue" type="submit" name="add" value="Submit">
</div>

<!-- Validate Email Exist Error Script -->
<script defer src="scripts/admin_email_exist_error.js"></script>

<!-- Close Database Connection -->
<?php
mysqli_close($conn);
?>