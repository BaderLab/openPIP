/*  property_reg.js
    Author: Hussam Fetyan
    This file contains the functions required
    to validate user input on the property registration page
 */

function handlePropReg(){
    var street_name = document.getElementById("street_name").value;
    var street_number = document.getElementById("street_number").value;
    var city = document.getElementById("city").value;
    var postal_code = document.getElementById("p_code").value;
    var price = document.getElementById("price").value;
    var date = document.getElementById("date").value;

    var valid_street_name = validateName(street_name);
    var valid_street_number = validateNumber(street_number);
    var valid_city = validateName(city);
    var valid_postal = validatePostal(postal_code);
    var valid_price = validateNumber(price);
    var valid_date = validateDate(date);





    var message1 = document.getElementById("message1");
    var message2 = document.getElementById("message2");
    var message3 = document.getElementById("message3");
    var message4 = document.getElementById("message4");
    var message5 = document.getElementById("message5");
    var message6 = document.getElementById("message6");

    var allow_submit = true;

    if(!valid_street_name){
        message1.innerHTML = "You have entered an invalid street name!";
        message1.className = "alert_message";
        allow_submit = false;
    }
    else{
        message1.className = "hidden";
    }

    if(!valid_street_number){
        message2.innerHTML = "You have entered an invalid street number!";
        message2.className = "alert_message";
        allow_submit = false;
    }
    else{
        message2.className = "hidden";
    }

    if(!valid_city){
        message3.innerHTML = "You have entered an invalid city!";
        message3.className = "alert_message";
        allow_submit = false;
    }
    else{
        message3.className = "hidden";
    }

    if(!valid_postal){
        message4.innerHTML = "You have entered an invalid postal code!";
        message4.className = "alert_message";
        allow_submit = false;
    }
    else{
        message4.className = "hidden";
    }

    if(!valid_price){
        message5.innerHTML = "You have entered an invalid price!";
        message5.className = "alert_message";
        allow_submit = false;
    }
    else{
        message5.className = "hidden";
    }

    if(!valid_date){
        message6.innerHTML = "You have entered an invalid date!";
        message6.className = "alert_message";
        allow_submit = false;
    }
    else{
        message6.className = "hidden";
    }


    return allow_submit;
}


var form = document.getElementsByTagName("form")[0];
form.onsubmit = handlePropReg;
form.onreset = handleReset;
