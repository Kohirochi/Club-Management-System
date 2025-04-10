<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ClubExpress</title>
    <?php
    include_once "includes/links.php";
    include_once "includes/scripts.php";
    ?>
</head>

<body id="login-page">
    <section class="entry-form">
        <form name="login" action="manage_login.php" method="post" class="text-center" onsubmit="return validate_login();">
            <a href="index.php"><img title="Home" class="entry-logo" src="../images/logo.png" alt="logo"></a>
            <br>
            <h1>ClubExpress Account Login</h1>
            <ul>
                <li id="tp-number-box">
                    <input type="text" name="tp-number" id="tp-number" placeholder="TP Number">
                    <br>
                    <div id="tp-number-error"></div>
                </li>
                <li id="password-box">
                    <input type="password" name="password" id="password" placeholder="Password">
                    <br>
                    <div id="password-error"></div>
                </li>
            </ul>
            <input type="submit" name="login-btn" value="Log In">
        </form>
    </section>

    <script>
        $(document).ready(function() {
            <?php if (isset($_SESSION['login']) && $_SESSION['login'] == false) {
                echo "window.onload = function() {
                    alert('" . $_SESSION['message'] . "')
                }";
                unset($_SESSION['login']);
                unset($_SESSION['message']);
            }
            ?>

            // Alert message if appointment booked
            <?php if (isset($_SESSION['register']) && isset($_SESSION['message'])) : ?>
                window.onload = function() {
                    alert("<?php echo $_SESSION['message'] ?>")
                };
            <?php
                unset($_SESSION['register']);
                unset($_SESSION['message']);
            endif;
            ?>
        });
    </script>

</body>

</html>