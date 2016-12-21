/**
 * 
 */

document.getElementById("data_file_data_file").onchange = function () {
	var inputValue = this.value.replace("C:\\fakepath\\", "");
    document.getElementById("uploadFile").value = inputValue;
};

function hideDeleteDatasetForm(event){

    $("#delete_dataset").addClass("hidden");
    
}

function showDeleteDatasetForm(event){

    var dataset = $( "#form_dataset_to_delete" ).val();
    $("#dataset_to_delete").innerHTML('dataset');
    $("#delete_dataset").removeClass("hidden");
}

$("#delete_dataset_button").on("click", showDeleteDatasetForm);
$("#cancel_delete_dataset").on("click", hideDeleteDatasetForm);



