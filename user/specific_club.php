<?php
include_once "includes/header.php";
include_once "includes/dbh.php";
include_once "../admin/includes/change_time_format.php";

$club_name = $_GET['club'];
$club_details_sql = "SELECT * FROM clubs WHERE Club_name = '$club_name';";
$club_details_result = $conn->query($club_details_sql);
$club_row = mysqli_fetch_assoc($club_details_result);
$_SESSION['club_id'] = $club_row['Club_ID'];

?>

<main id="specific-club-content">
    <div class="flex-container">
        <div class="flex-item club-img">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>">
        </div>
        <div class="flex-item club-details">
            <h1><?php echo $club_row['Club_name']; ?></h1>
            <p><?php echo $club_row['Description']; ?></p>
            <ul>
                <li><i class="fas fa-envelope"></i>&nbsp; <?php echo $club_row['Email']; ?></li>
                <li><i class="fas fa-phone-alt"></i>&nbsp; <?php echo $club_row['Contact_number']; ?></li>
            </ul>

            <table border="1">
                <h2>Activity info:</h2>
                <tr>
                    <th style="width: 25%;">Day</th>
                    <td><?php echo $club_row['Day']; ?></td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td><?php echo change_time_format($club_row['Start_time']); ?> -
                        <?php echo change_time_format($club_row['End_time']); ?> </td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><?php echo $club_row['Venue']; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <form action="manage_club_registration.php" method="post">
        <input id="register-button" name="register" type="submit" value="Register Now">
    </form>
</main>

<?php
include_once "../admin/includes/alert_message.php";
include_once "includes/footer.php";
mysqli_close($conn);
?>