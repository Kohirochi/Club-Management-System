// https://www.youtube.com/watch?v=7L0YXnGuH10&t=881s

$(document).ready(function() {
    $('#email-address').keyup(function(e) {
        var email = $('#email-address').val(); // store the value of user typed in the email box
        const email_input = document.getElementById("email-address");
        const action = email_input.parentElement.parentElement.parentElement.parentElement.id;
        $.ajax({
            type: "POST",
            url: "admin_email_exist_validation.php",
            data: {
                "check_btn": 1,
                "input_email": email, //send the world typed in the email box
                "action": action
            },
            success: function(response) { // response from admin_email_exist_validation.php
                const email_input = document.getElementById("email-address");
                const form_control = email_input.parentElement;
                const error_field = form_control.querySelector("small");

                // Add error class
                form_control.className = "flex-item email-exist-validation";

                // Add error message
                error_field.textContent = response;
            }
        });
    });
});