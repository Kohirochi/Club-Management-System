<header>
    <nav id="nav" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-!" href="index.php" title="Home"><img src="../images/logo.png" height="60px" width="70px" alt="logo">
                <h1 class="logo-name">ClubExpress</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" id="nav-clubs" aria-current="page" href="index.php">Clubs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-events" href="events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-about-us" href="about_us.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-contact-us" href="contact_us.php">Contact Us</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['student_id'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                My Profile
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="joined_clubs.php">Clubs Joined</a>
                                <a class="dropdown-item" href="user_profile.php">Account Settings</a>
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>

                    <?php } ?>

                </ul>
            </div>
        </div>
    </nav>
</header>