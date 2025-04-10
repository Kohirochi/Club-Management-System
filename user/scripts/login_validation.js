function show_error(input_box, error_column, error_message ,input_column, input_margin_bottom, div_height) {
  document.getElementById(error_column).innerHTML = "<img src='images/error.png' style='width: 20px; position: relative; top:3px;'>" + error_message;
  document.getElementById(input_column).style.border = "2px solid red";
  document.getElementById(input_box).style.marginBottom = `${parseFloat(input_margin_bottom) - parseFloat(div_height) - 2}px`;
  document.getElementById(input_column).focus();
  return false
}

function remove_error(input_box, error_column, input_column) {
  document.getElementById(error_column).innerHTML = "";
  document.getElementById(input_column).style.border = "1px solid black";
  document.getElementById(input_box).style.marginBottom = "";
  return true
}

// validate login  

function validate_login_email() {
  var email = document.getElementById("login-email").value;
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email) == false) {
    return show_error("login-email-box", "email-error", "Enter a valid email!", "login-email", "40", "24");
  }
  return remove_error("login-email-box", "email-error", "login-email");
}


function validate_login_password() {
  var password = document.getElementById("login-password").value;
  if (password == "") {
    return show_error("login-password-box", "password-error", "Please enter password", "login-password", "40", "24");
  }
  return remove_error("login-password-box", "password-error", "login-password");
}

function validate_login() {
  var password = validate_login_password();
  var email = validate_login_email();
  if (email && password) {
    return true;
  }
  return false;
}
