/*  basic_cal.js
    Author: Hussam Fetyan
* */

/*  function displayInput() takes a symbol as a parameter
    and displays that symbol in the display area
    of the calculator
*/
function displayInput(symbol){
    var input = symbol;
    var input_line = document.getElementById("input-line");
    var output_line = document.getElementById("output-line");
    var old_input = input_line.innerHTML;

    //Check if the input line has a <br /> element
    //This is the case when the input line is still empty.
    if (input_line.firstElementChild != null){
        old_input = "";
    }

    //Make sure the input line doesn't exceed the maximum
    //number of characters allowed (25)
    if (old_input.length >= 25){
        output_line.innerHTML = "Max input";
    }
    else {
        var new_input = old_input + input;
        input_line.innerHTML = new_input;
    }
}



/*  function deleteChar() takes no parameters as
    and deletes the last symbol entered in the display area
 */
function deleteChar(){
    var input_line = document.getElementById("input-line");
    var old_input = input_line.innerHTML;
    var new_input;

    //Check if the input line has a <br /> element
    //This is the case when the input line is still empty.
    //We need to delete characters only if the input line is not empty.
    if (input_line.firstElementChild == null){
        if(old_input.length > 1){
            new_input = old_input.substring(0, old_input.length - 1);
        }
        //If the input line contains only one character, we
        //need to make it empty by adding a <br /> placeholder
        else{
            new_input = "<br />";
        }
    }
    else{
        new_input = "<br />";
    }

    input_line.innerHTML = new_input;

    //Delete any error message appearing in the output line
    var output_line = document.getElementById("output-line");
    var output = output_line.innerHTML;
    if (output == "Max input" || output == "Syntax error" || output == "Math error")
    {
        output_line.innerHTML = "<br />";
    }
}



/*  function deleteAll() takes no parameters as
    input and deletes everything from the display area
 */
function deleteAll(){
    var input_line = document.getElementById("input-line");
    input_line.innerHTML = "<br />";
    
    var output_line = document.getElementById("output-line");
    output_line.innerHTML = "<br />";
}


function removeSpecialEntities(str){
    var result = str.replace(/\u00D7/g, "*");
    result = result.replace(/\u00F7/g, "/");
    return result;
}


function validateInput(str){
    var valid_formula = true;

    /*The following conditions may partially overlap. However,
    * this is not a bad thing , and the intention is mainly to
    * make them clearer
    */

    //Make sure the input doesn't start with /, *, or e
    if (str.search(/^[\*\/e]/) == 0){
        valid_formula = false;
    }

    //Make sure the input doesn't end with /, *, +, -, or e
    if (str.search(/.*[\*\/\+e-]$/) == 0){
        valid_formula = false;
    }

    //Additionally:
    //Make sure that no two consecutive  +, - signs fall
    //at the beginning, although doesn't affect calculations but neater
    if (str.search(/^[\+-][\+-]+/) == 0){
        valid_formula = false;
    }

    //Make sure that every e is preceded by a digit or floating point .,
    //followed by a digit or + or -,
    //and no second e or a floating point can exist in the power part
    if (str.search(/[^\d\.]e|e[\*\/\.e]|e[\+-]?\d*[e\.]/) != -1){
        valid_formula = false;
    }

    //Make sure that no floating point . is preceded and
    //followed by non digit at the same time, and no two floating
    //points separated by only digits can occur
    if (str.search(/^\.\D|\D\.\D|\.\d*\./) != -1){
        valid_formula = false;
    }

    //Make sure that no +, -, /, or * is followed by / or *
    if (str.search(/[\*\/\+-][\/\*]+/) != -1){
        valid_formula = false;
    }

    //Make sure that any /, *, +, -, or e is followed by no more
    //than one + or -
    if (str.search(/[\*\/\+e-][\+-][\+-]+/) != -1){
        valid_formula = false;
    }

    return valid_formula;
}


function execute(){
    var input_line = document.getElementById("input-line");
    var output_line = document.getElementById("output-line");

    if (input_line.firstElementChild == null){
        var formula = input_line.innerHTML;
        var clean_formula = removeSpecialEntities(formula);
        var valid_formula = validateInput(clean_formula);

        if(valid_formula){
            var output = parseFloat(eval(clean_formula));

            if (!isNaN(output) && isFinite(output)) {
                output_line.innerHTML = output;
            }
            else{
                output_line.innerHTML = "Math error";
            }
        }
        else{
            output_line.innerHTML = "Syntax error";
        }
    }
}
