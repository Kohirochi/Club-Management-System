<?php
include_once "includes/header.php";
include_once "includes/student_authentication.php";
include_once "includes/dbh.php";

// get the user's id from the URL
$student_id = $_SESSION['student_id'];
// sql query to retrieve user's data from the database based on the user's id
$sql_query = "SELECT * FROM students WHERE student_id = '$student_id'";
// store the result of sql query in a variable
$result = mysqli_query($conn, $sql_query);
// fetch a row of data as an associative array
$row = mysqli_fetch_assoc($result);

// if submit button is clicked
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<main id="user-profile">
    <form action="manage_user_profile.php" method="post" onsubmit="return validate_student_profile();">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                        <span class="font-weight-bold">Welcome To Your Profile Page!</span>
                        <span class="text-black-50">You May Edit Your Personal Details Here!</span><span></span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">My Profile</h4>
                        </div>
                        <div class="form-group">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="flex-item">
                                        <label for="user-name " class="labels">Full Name</label>
                                        <input type="text" class="form-control" id="user-name" name="txtName"
                                            value="<?php echo $row['Student_name'] ?>">
                                        <i class="fas fa-check-circle"></i>
                                        <i class="fas fa-exclamation-circle"></i>
                                        <small>Error message</small>
                                        <br>
                                    </div>

                                    <label class="labels" for="tp-number">TP Number</label>
                                    <input type="text" class="form-control" id="tp-number" name='txtTpnumber'
                                        value="<?php echo $row['TP_number'] ?>" disabled>
                                    <br>

                                    <div class="flex-item">
                                        <label class="labels" for="gender">Gender</label>
                                        <select class="form-control form-select" id="gender" name="txtGender">
                                            <option value="Male"
                                                <?php echo ($row['Gender'] == "Male") ? "selected" : ""; ?>>
                                                Male
                                            </option>
                                            <option value="Female"
                                                <?php echo ($row['Gender'] == "Female") ? "selected" : ""; ?>>Female
                                            </option>
                                        </select>
                                        <i class="fas fa-check-circle"></i>
                                        <i class="fas fa-exclamation-circle"></i>
                                        <small>Error message</small>
                                        <br>
                                    </div>

                                    <label class="labels" for="email-address">Email Address</label>
                                    <input type="email" class="form-control" id="email-address" name='txtEmail'
                                        value="<?php echo $row['Email'] ?>" disabled>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center experience"><span>Edit
                                Security</span></div><br>
                        <div class="col-md-12">
                            <div class="flex-item">
                                <label class="labels" for="password">Password</label>
                                <input type="text" class="form-control" value="<?php echo $row['Password'] ?>"
                                    id="password" name="txtPassword">
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                        </div>
                        <br>

                        <div class="col-md-12">
                            <div class="flex-item">
                                <label class="labels" for="contact-number">Contact Number</label>
                                <input type="text" class="form-control" value="<?php echo $row['Contact_number'] ?>"
                                    id="contact-number" name="txtContact">
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                        </div>
                        <br>

                        <button type="submit" name="updateRecord" value="Update Record"
                            class="btn btn-outline-primary">Update Record</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<?php include_once "../admin/includes/alert_message.php"; ?>

<script defer src="../admin/scripts/form_validation.js"></script>
<?php include_once "./includes/footer.php"; ?>
<?php mysqli_close($conn); ?>