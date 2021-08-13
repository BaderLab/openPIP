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

    // var dataset = $( "#form_dataset_to_delete" ).val();
    // $("#dataset_to_delete").innerHTML('dataset');
    $("#delete_dataset").removeClass("hidden");
    console.log('hi there');
}


function hideInsertDatabaseForm(event){

    $("#insert_database").addClass("hidden");
    
}

function showInsertDatabaseForm(event){

    // var e = $( "#form_files_to_insert" );
    var e = document.getElementById("form_files_to_insert");
    var strUser = e.options[e.selectedIndex].text;
    console.log(strUser);

    $("#file_to_insert").text(strUser);
    $("#insert_database").removeClass("hidden");
}

$("#delete_dataset_button").on("click", showDeleteDatasetForm);
$("#cancel_delete_dataset").on("click", hideDeleteDatasetForm);

$("#insert_into_database").on("click", showInsertDatabaseForm);
$("#cancel_database_insert").on("click", hideInsertDatabaseForm);


