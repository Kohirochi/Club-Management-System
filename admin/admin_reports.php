<?php
include_once "includes/header.php";
?>
<main id="main">
    <h1 class="title">Reports</h1>
    <br>
    <hr>
    <article id="reports">
        <div class="content-container">
            <form method="post" class="report-container" onsubmit="return validate_admin_report();">
                <ul class="flex-container">
                    <li class="flex-item">
                        <?php $report_category_list = ['Students', 'Clubs', 'Events']; ?>
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
                        <select name="report-list" id="report-list">
                            <option value="" selected disabled hidden>Select category to continue</option>
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
            <form action="export_report.php" id="report-form" method="post" target="_blank">
                <input type="hidden" name="report-content" id="report-content">
                <div id="export-container">
                    <button type="button" class="submit-btn" name="export" id="export-button">Export</button>
                </div>
            </form>

            <div id="report-container">
            </div>
        </div>
    </article>
</main>

<script defer src="scripts/add_report_selection.js"></script>

<!-- Google Chart Script -->
<script defer type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- When Generate button clicked -->
<?php if (isset($_POST['generate'])) : ?>
<?php
    $report_category = trim($_POST['report-category']);
    $report_list = trim($_POST['report-list']);
    ?>
<script>
$(document).ready(function() {
    var report_category = "<?php echo $report_category ?>";
    var report_list = "<?php echo $report_list ?>";
    $("#report-container").load("generate_report.php", {
        report_category: report_category,
        report_list: report_list
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
include_once "includes/alert_message.php";
include_once "includes/footer.php";
?>