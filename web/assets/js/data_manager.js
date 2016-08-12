/**
 * 
 */

document.getElementById("data_file_data_file").onchange = function () {
	var inputValue = this.value.replace("C:\\fakepath\\", "");
    document.getElementById("uploadFile").value = inputValue;
};