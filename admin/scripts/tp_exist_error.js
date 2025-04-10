// https://www.youtube.com/watch?v=7L0YXnGuH10&t=881s

$(document).ready(function() {
    $('#tp-number').keyup(function(e) {
        var tp_number = $('#tp-number').val(); // store the value of user typed in the tp number box
        const tp_number_input = document.getElementById("tp-number");
        const action = tp_number_input.parentElement.parentElement.parentElement.parentElement.id;
        $.ajax({
            type: "POST",
            url: "tp_exist_validation.php",
            data: {
                "check_btn": 1,
                "input_tp_number": tp_number, //send the world typed in the email box
                "action": action
            },
            success: function(response) { // response from tp_exist_validation.php
                const tp_number_input = document.getElementById("tp-number");
                const form_control = tp_number_input.parentElement;
                const error_field = form_control.querySelector("small");

                // Add error class
                form_control.className = "flex-item tp-exist-validation";

                // Add error message
                error_field.textContent = response;
            }
        });
    });
});