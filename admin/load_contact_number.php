<?php
include_once "../user/includes/dbh.php";

$patient_id = $_POST['patient_id'];
$sql_query = "SELECT * FROM patient WHERE Patient_ID = $patient_id;";
$result = mysqli_query($conn, $sql_query);
$row = mysqli_fetch_assoc($result);
?>

Patient Contact Number <br>
<input type="text" placeholder="e.g. 999-9999999" name="contact-number" id="contact-number" class="remove_id" value="<?php echo $row['Contact_number']; ?>">
<i class="fas fa-check-circle"></i>
<i class="fas fa-exclamation-circle"></i>
<small></small>

<?php
mysqli_close($conn);
?>