/*  user_reg.js
    Author: Hussam Fetyan
    This file contains the functions required
    to validate user input on the user registration page
 */

function handleUserReg(){
    var username = document.getElementById("username").value;
    var first_name = document.getElementById("first_name").value;
    var last_name = document.getElementById("last_name").value;
    var password = document.getElementById("password").value;
    var street_name = document.getElementById("street_name").value;
    var street_number = document.getElementById("street_number").value;
    var city = document.getElementById("city").value;
    var postal_code = document.getElementById("p_code").value;
    var phone_number = document.getElementById("phone").value;
    var email = document.getElementById("email").value;

    var valid_username = validateUserName(username);
    var valid_first = validateName(first_name);
    var valid_last = validateName(last_name);
    var valid_password = validatePassword(password);
    var valid_street_name = validateName(street_name);
    var valid_street_number = validateNumber(street_number);
    var valid_city = validateName(city);
    var valid_postal = validatePostal(postal_code);
    var valid_phone = validatePhone(phone_number);
    var valid_email = validatePhone(email);
    var message1 = document.getElementById("message1");
    var message2 = document.getElementById("message2");
    var message3 = document.getElementById("message3");
    var message4 = document.getElementById("message4");
    var message5 = document.getElementById("message5");
    var message6 = document.getElementById("message6");
    var message7 = document.getElementById("message7");
    var message8 = document.getElementById("message8");
    var message9 = document.getElementById("message9");
    var message10 = document.getElementById("message10");
    var allow_submit = true;

    if(!valid_username){
        message1.innerHTML = "You have entered an invalid user name!";
        message1.className = "alert_message";
        allow_submit = false;
    }
    else{
        message1.className = "hidden";
    }

    if(!valid_first){
        message2.innerHTML = "You have entered an invalid first name!";
        message2.className = "alert_message";
        allow_submit = false;
    }
    else{
        message2.className = "hidden";
    }

    if(!valid_last){
        message3.innerHTML = "You have entered an invalid last name!";
        message3.className = "alert_message";
        allow_submit = false;
    }
    else{
        message3.className = "hidden";
    }

    if(!valid_password){
        message4.innerHTML = "You have entered an invalid password!";
        message4.className = "alert_message";
        allow_submit = false;
    }
    else{
        message4.className = "hidden";
    }

    if(!valid_street_name){
        message5.innerHTML = "You have entered an invalid street name!";
        message5.className = "alert_message";
        allow_submit = false;
    }
    else{
        message5.className = "hidden";
    }

    if(!valid_street_number){
        message6.innerHTML = "You have entered an invalid street number!";
        message6.className = "alert_message";
        allow_submit = false;
    }
    else{
        message6.className = "hidden";
    }

    if(!valid_city){
        message7.innerHTML = "You have entered an invalid city!";
        message7.className = "alert_message";
        allow_submit = false;
    }
    else{
        message7.className = "hidden";
    }

    if(!valid_postal){
        message8.innerHTML = "You have entered an invalid postal code!";
        message8.className = "alert_message";
        allow_submit = false;
    }
    else{
        message8.className = "hidden";
    }

    if(!valid_phone){
        message9.innerHTML = "You have entered an invalid phone number!";
        message9.className = "alert_message";
        allow_submit = false;
    }
    else{
        message9.className = "hidden";
    }

    if(!valid_email){
        message10.innerHTML = "You have entered an invalid email address!";
        message10.className = "alert_message";
        allow_submit = false;
    }
    else{
        message10.className = "hidden";
    }


    return allow_submit;
}

var form = document.getElementsByTagName("form")[0];
form.onsubmit = handleUserReg;
form.onreset = handleReset;
