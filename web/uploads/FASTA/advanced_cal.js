/*
    advanced_cal.js
    Author: Hussam Fetyan
*/

/*
    The following are four helper functions that are used to create
    HTML elements so that they can be added to the DOM upon
    clicking on the button "Sci"
*/
function createButtonCell(value, id){
    var new_button = document.createElement("input");
    new_button.type = "button";
    new_button.value = value;
    new_button.id = id;

    var new_cell = document.createElement("td");
    new_cell.appendChild(new_button);

    return new_cell;
}

function createTextBoxCell(id){
    var new_box = document.createElement("input");
    new_box.id = id;
    new_box.type = "text";
    new_box.size = 10;
    new_box.maxLength = 25;
    var new_cell = document.createElement("td");
    new_cell.appendChild(new_box);

    return new_cell;
}

function createSelectCell(){

    var options = ["length", "time", "mass"];
    var option_text = ["Kilometers to meters, meters to kilometers",
        "Minutes to seconds, seconds to minutes",
        "Kilograms to grams, grams to kilograms"];
    var temp_option;

    var selection = document.createElement("select");
    selection.id = "list";

    for (var i = 0; i < 3; i++){
        temp_option = document.createElement("option");
        temp_option.value = options[i];
        temp_option.innerHTML = option_text[i];
        selection.appendChild(temp_option);
    }

    var new_cell = document.createElement("td");
    new_cell.colSpan = 5;
    new_cell.appendChild(selection);

    return new_cell;
}

function createCell(content, id){
    var new_cell = document.createElement("td");
    new_cell.id = id;
    new_cell.innerHTML = content;

    return new_cell;
}


//Function validateBoxInput takes a string as a parameter
//and checks if the string can be converted to a number, returns boolean
function validateBoxInput(value){
    var valid_input = true;

    //The number constructor converts a string to a number
    //if the string has characters at the end, it returns NaN
    //but if the string is empty, it gives 0
    var numeric_value = Number(value);

    //The parseFloat function returns NaN for the empty string
    //but it returns any numeric value found at the beginning
    //of the string even if the string has non digits at the end
    var float_value = parseFloat(value);

    //So we need to check both cases:
    if(isNaN(numeric_value) || isNaN(float_value)){
        valid_input = false;
    }

    return valid_input;
}


//Function handleMath is an event handler which takes an event
//as a parameter, computes and displays the result of applying
//a specific math function
function handleMath(event){
    var clicked_but_id = event.target.id;
    var math_function = clicked_but_id.substring(0, clicked_but_id.indexOf("_"));
    var input = document.getElementById(math_function + "_box").value;
    var output;
    var display = document.getElementById(math_function + "_result");
    var input_valid = validateBoxInput(input);

    if (input_valid){
        switch(math_function){
            case "sin":
                output = Math.sin(input * Math.PI / 180);
                break;
            case "cos":
                output = Math.cos(input * Math.PI / 180);
                break;
            case "log":
                output = Math.log10(input);
                break;
            case "root":
                output = Math.sqrt(input);
                break;
        }

        if (!isNaN(output) && isFinite(output)) {
            display.innerHTML = output.toFixed(5);
        }
        else{
            display.innerHTML = "Math error";
        }
    }
    else{
        display.innerHTML = "Syntax error";
    }

    event.preventDefault();

}


//Function handleConversion is an event handler which takes an event
//as a parameter, computes and displays the result of the conversion
//between the two text boxes
function handleConversion(event){

    var box_id = event.target.id;
    var selected_option = document.getElementById("list").value;
    var input = document.getElementById(box_id).value;
    var unit_1 = document.getElementById("conv_unit_1");
    var unit_2 = document.getElementById("conv_unit_2");
    var conversion_factor;
    var output;
    var display;

    var input_valid = validateBoxInput(input);

    switch(selected_option){
        case "length":
            conversion_factor = 1000;
            break;
        case "time":
            conversion_factor = 60;
            break;
        case "mass":
            conversion_factor = 1000;
            break;
    }

    if (box_id == "conv_box_1"){
        output = input * conversion_factor;
        display = document.getElementById("conv_box_2");
    }
    else{
        output = input / conversion_factor;
        display = document.getElementById("conv_box_1");
    }

    if (input_valid){
        if (!isNaN(output) && isFinite(output)) {
            display.value = output;
        }
        else{
            display.value = "Math error";
        }
    }
    else{
        display.value = "Syntax error";
    }

    event.preventDefault();
}


//Function handleUnits is an event handler which takes an event
//as a parameter, changes and displays the units of the conversion
//based on what option is chosen from the selection list
function handleUnits(event){

    var selected_option = document.getElementById(event.target.id).value;
    var unit_1 = document.getElementById("conv_unit_1");
    var unit_2 = document.getElementById("conv_unit_2");

    switch(selected_option){
        case "length":
            unit_1.innerHTML = "Km = ";
            unit_2.innerHTML = "m";
            break;
        case "time":
            unit_1.innerHTML = "minute = ";
            unit_2.innerHTML = "second";
            break;
        case "mass":
            unit_1.innerHTML = "Kg = ";
            unit_2.innerHTML = "g";
            break;
    }

    event.preventDefault();
}



//Function toggleView takes the current value of the button
//and toggles the view based on that value
function toggleView(current_view){

    var toggler = document.getElementById("toggle_btn");
    var location = document.getElementsByTagName("tbody")[0];
    var btn_label = ["sin", "cos", "log", "\u221A"];
    var ids = ["sin", "cos", "log", "root"];
    var cell_content = ["deg = ", "deg = ", " = ", " = "];
    var temp_elem;

    switch(current_view) {
        case "Sci":
            location = location.firstElementChild;
            location = location.nextElementSibling;

            for (var i = 0; i < 4; i++) {
                temp_elem = createButtonCell(btn_label[i], ids[i] + "_btn");
                temp_elem.addEventListener("click", handleMath, false);
                location.appendChild(temp_elem);

                temp_elem = createTextBoxCell(ids[i] + "_box");
                location.appendChild(temp_elem);

                temp_elem = createCell(cell_content[i], ids[i] + "_equal");
                location.appendChild(temp_elem);

                temp_elem = createCell("", ids[i] + "_result");
                location.appendChild(temp_elem);

                location = location.nextElementSibling;
            }

            toggler.value = "CONV";
            break;

        case "CONV":
            var last_row = document.createElement("tr");
            location.appendChild(last_row);
            location = location.lastElementChild;

            temp_elem = createSelectCell();
            temp_elem.firstElementChild.addEventListener("change", handleUnits, false);
            location.appendChild(temp_elem);

            temp_elem = createTextBoxCell("conv_box_1");
            temp_elem.addEventListener("change", handleConversion, false);
            location.appendChild(temp_elem);

            temp_elem = createCell("Km = ", "conv_unit_1");
            location.appendChild(temp_elem);

            temp_elem = createTextBoxCell("conv_box_2");
            temp_elem.addEventListener("change", handleConversion, false);
            location.appendChild(temp_elem);

            temp_elem = createCell("m", "conv_unit_2");
            location.appendChild(temp_elem);

            toggler.value = "STAND";
            break;

        case "STAND":
            temp_elem = location.lastElementChild;
            location.removeChild(temp_elem);

            location = location.firstElementChild;
            location = location.nextElementSibling;

            for (var i = 0; i < 4; i++) {
                temp_elem = document.getElementById(ids[i] + "_btn");
                temp_elem = temp_elem.parentNode;
                location.removeChild(temp_elem);

                temp_elem = document.getElementById(ids[i] + "_box");
                temp_elem = temp_elem.parentNode;
                location.removeChild(temp_elem);

                temp_elem = document.getElementById(ids[i] + "_equal");
                location.removeChild(temp_elem);

                temp_elem = document.getElementById(ids[i] + "_result");
                location.removeChild(temp_elem);

                location = location.nextElementSibling;
            }

            toggler.value = "Sci";
            break;

    }
}