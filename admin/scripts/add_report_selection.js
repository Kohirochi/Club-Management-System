const report_category = document.getElementById("report-category");
report_category.addEventListener("change", function(e) {
    var report_type = report_category.value;
    $("#report-list").load("load_report_list.php", {
        report_type: report_type
    });
});
