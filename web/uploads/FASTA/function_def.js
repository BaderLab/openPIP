/*  function_def.js
    Author: Hussam Fetyan
    This file contains helper functions that will
    be used to validate user input
*/


function validateUserName(str){
    var valid_username = false;

    if(str.search(/^[a-z][a-z0-9_\.-]+$/) == 0){
        valid_username = true;
    }

    return valid_username;
}


function validatePassword(str){
    var valid_password = false;

    if(str.search(/^[A-Za-z0-9@\*$]{6}$/) == 0){
        valid_password = true;
    }

    return valid_password;
}


function validateName(str){
    var valid_name = false;

    if(str.search(/^[A-Z][a-z]+$/) == 0){
        valid_name = true;
    }

    return valid_name;
}

function validateNumber(str){
    var valid_number = false;

    if(str.search(/^[1-9][0-9]*$/) == 0 && Number(str) > 0 && Number(str) <= 99999){
        valid_number = true;
    }

    return valid_number;
}

function validatePostal(str){
    var valid_postal = false;

    if(str.search(/^([A-Za-z][0-9]){3}$/) == 0){
        valid_postal = true;
    }

    return valid_postal;
}


function validatePhone(str){
    var valid_phone = false;

    if(str.search(/^[1-9][0-9]{2}-\d{3}-\d{4}$/) == 0){
        valid_phone = true;
    }

    return valid_phone;
}


function validateEmail(str){
    var valid_email = false;

    if(str.search(/^[a-z][a-z0-9_\.-]*@[a-z]*\.[a-z]{2}[a-z]?$/) == 0){
        valid_email = true;
    }

    return valid_email;
}

function validateDate(str){
    var valid_date = false;

    if(str.search(/^([0-9]{2}\/){2}[0-9]{4}$/) == 0){
        valid_date = true;
    }

    return valid_date;
}


function handleReset(){

    var messages = document.getElementsByClassName("alert_message");

    for (ind in messages){
        messages[ind].className = "hidden";
    }

}