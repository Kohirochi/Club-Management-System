$(document).ready(function() {

    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate()+1);
    var month = tomorrow.getMonth() + 1;
    var day = tomorrow.getDate();
    var year = tomorrow.getFullYear();

    // Check if today is the last day of the year
    if (month < 10) {
        month = "0" + month.toString();
    }
    if (day < 10) {
        day = "0" + day.toString();
    }
    
    //Disable previous date
    var minDate = year + "-" + month + "-" + day;
    $("#date").attr("min", minDate);
});