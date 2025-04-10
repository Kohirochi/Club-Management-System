<?php
include_once "includes/header.php";
include_once "includes/dbh.php";

$club_name = $_GET['club'];
$club_sql = "SELECT * FROM clubs WHERE Club_name = '$club_name';";
$club_details = $conn->query($club_sql);
$club_row = mysqli_fetch_assoc($club_details);
$club_id = $club_row['Club_ID'];

include_once "includes/sidenav.php";
?>
<article id="reports">
    <div class="logo-container">
        <img title="Club logo" src="data:image/jpeg;base64,<?php echo base64_encode($club_row['Club_image']); ?>">
    </div>
    <h1 class="title"><?php echo $club_row['Club_name']; ?></h1>
    <div class="content-container">
        <h2>Club Report</h2>
        <form method="post" class="report-container" onsubmit="return validate_committee_report();">
            <ul class="flex-container">
                <li class="flex-item">
                    <?php $report_category_list = ['Members', 'Events']; ?>
                    <select name="report-category" id="report-category">
                        <option value="" selected disabled hidden>Please select</option>
                        <?php foreach ($report_category_list as $category) : ?>
                        <option value="<?php echo $category ?>"><?php echo $category ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>
                </li>
                <li class="flex-item">
                    <input class="submit-btn" name="generate" id="generate-button" type="submit" value="Generate">
                </li>
            </ul>
        </form>
        <form action="../admin/export_report.php" id="report-form" method="post" target="_blank">
            <input type="hidden" name="report-content" id="report-content">
            <div id="export-container">
                <button type="button" class="submit-btn" name="export" id="export-button">Export</button>
            </div>
        </form>

        <div id="report-container">
        </div>

    </div>
</article>

<!-- When Generate button is clicked -->
<?php if (isset($_POST['generate'])) : ?>
<?php
    $report_category = trim($_POST['report-category']);
    ?>
<script>
$(document).ready(function() {
    var report_category = "<?php echo $report_category ?>";
    var id = "<?php echo $club_id ?>";
    $("#report-container").load("generate_report.php", {
        report_category: report_category,
        id: id
    });
});

var exportContainer = document.getElementById("export-container");
exportContainer.style.visibility = "visible";
</script>
<?php endif; ?>

<script>
$(document).ready(function() {
    $('#export-button').click(function() {
        $('#report-content').val($('#report-container').html());
        $('#report-form').submit();
    });
});
</script>

<?php
include_once "../admin/includes/alert_message.php";
include_once "includes/footer.php";
?>