/*  login.js
    Author: Hussam Fetyan
    This file contains the function required
    to validate user input on the login page
*/

function handleLogin(){
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var valid_username = validateUserName(username);
    var valid_password = validatePassword(password);
    var message1 = document.getElementById("message1");
    var message2 = document.getElementById("message2");
    var allow_submit = true;

    if(!valid_username){
        message1.innerHTML = "You have entered an invalid user name!";
        message1.className = "alert_message";
        allow_submit = false;
    }
    else{
        message1.className = "hidden";
    }

    if(!valid_password){
        message2.innerHTML = "You have entered an invalid password!";
        message2.className = "alert_message";
        allow_submit = false;
    }
    else{
        message2.className = "hidden";
    }

    return allow_submit;
}


var form = document.getElementsByTagName("form")[0];
form.onsubmit = handleLogin;