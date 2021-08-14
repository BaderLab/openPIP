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

function hideInsertDatabaseFormNext(event){

    $("#insert_database_next").addClass("hidden");  
}

function continueAnyway(event){

    $("#not_psi").addClass("hidden");  
    
    var e = document.getElementById("form_files_to_insert");
    var strUser = e.options[e.selectedIndex].text;
    var myarr_temp = strUser.split("::");
    var v_file=myarr_temp[1];
    var myarr_temp2 = strUser.split(".");
    var ext = myarr_temp2[myarr_temp2.length-1];
    console.log(ext);
        $("#file_to_insert").text(strUser);
        $("#insert_database").removeClass("hidden");
 
}
function cancleContinueAnyway(event){

    $("#not_psi").addClass("hidden");  
}

function showInsertDatabaseForm(event){

    // var e = $( "#form_files_to_insert" );
    var e = document.getElementById("form_files_to_insert");
    var strUser = e.options[e.selectedIndex].text;
    var myarr_temp = strUser.split("::");
    var v_file=myarr_temp[1];
    var myarr_temp2 = strUser.split(".");
    var ext = myarr_temp2[myarr_temp2.length-1];
    console.log(ext);
    if(ext=='psi'){
        $("#file_to_insert").text(strUser);
        $("#insert_database").removeClass("hidden");
    }else{
        $("#not_psi").removeClass("hidden");
    }

   
}

$("#delete_dataset_button").on("click", showDeleteDatasetForm);
$("#cancel_delete_dataset").on("click", hideDeleteDatasetForm);

$("#insert_into_database").on("click", showInsertDatabaseForm);
$("#cancel_database_insert").on("click", hideInsertDatabaseForm);
$("#cancel_database_insert_next").on("click", hideInsertDatabaseFormNext);

$("#continue_anyway").on("click", continueAnyway);
$("#cancel_continue_anyway").on("click", cancleContinueAnyway);



$('#get_lines').click(function() {
    // alert("hiii");
    var e = document.getElementById("form_files_to_insert");
    var strUser = e.options[e.selectedIndex].text;
    var myarr = strUser.split("::");
    var v_folder=myarr[0];
    var v_file=myarr[1];
    // var Url="{{url}}";
    // console.log(Url);
    var path_getLine = Url + 'app.php/admin/data_manager/' + v_folder + '/' + v_file;
    console.log(path_getLine);

    $.ajax({
        'url' : path_getLine,
        'type' : 'GET',
        beforeSend: function() {
                    // alert(1);
                },
        error: function() {
                    alert('Error');
                },
        'success' : function(data) {
            next(data);
        }
    });

    function next(data){
        console.log(data);
        $("#insert_database").addClass("hidden");

        var timestamp= data*2*1.5;
        var hours = Math.floor(timestamp / 60 / 60);
        var minutes = Math.floor(timestamp / 60) - (hours * 60);
        var formatted = hours + ':' + minutes + '  (hour:minute)';

        var text_v='There are '+ data + ' interactions in the file. \n Estimate time of completion is: ' + formatted;
        $("#file_to_insert_next").text(text_v);
        $("#insert_database_next").removeClass("hidden");

    }
});


$('#final_upload_button').click(function() {
    // alert("hiii");
    var e = document.getElementById("form_files_to_insert");
    var strUser = e.options[e.selectedIndex].text;
    var myarr = strUser.split("::");
    var v_folder=myarr[0];
    var v_file=myarr[1];
    // var Url="{{url}}";
    // console.log(Url);
    var path_getLine = Url + 'app.php/admin/data_manager/insert_data/' + v_folder + '/' + v_file;
    console.log(path_getLine);
    $("#insert_database_next").addClass("hidden");
    $("#insert_database_next_loading").removeClass("hidden");
    $.ajax({
        'url' : path_getLine,
        'type' : 'GET',
        beforeSend: function() {
                    // alert(1);
                },
        error: function() {
                    alert('Error');
                },
        'success' : function(data) {
            // alert('yay');
            location.reload();
        },
        complete:function(data){
            // Hide image container
            // $("#loader").hide();
            $("#insert_database_next_loading").addClass("hidden");

        }
    });
});
