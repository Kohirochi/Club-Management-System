<div id="mySidenav" class="sidenav" onmouseleave="close_nav()">
    <a href="specific_joined_club.php?club=<?php echo $club_row['Club_name'] ?>">Dashboard</a>
    <a href="club_members.php?club=<?php echo $club_row['Club_name'] ?>">Members</a>
    <a href="club_events.php?club=<?php echo $club_row['Club_name'] ?>">Events</a>
    <a href="club_activities.php?club=<?php echo $club_row['Club_name'] ?>">Activities</a>
    <a href="club_registrations.php?club=<?php echo $club_row['Club_name'] ?>">Registration Approvals</a>
    <a href="club_feedbacks.php?club=<?php echo $club_row['Club_name'] ?>">Feedback</a>
    <a href="club_reports.php?club=<?php echo $club_row['Club_name'] ?>">Report</a>
</div>

<div onmouseover="open_nav()"><i class="fas fa-chevron-right"></i></div>

<script>
/* Set the width of the side navigation to 250px */
function open_nav() {
    document.getElementById("mySidenav").style.width = "220px";
}

/* Set the width of the side navigation to 0 */
function close_nav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>