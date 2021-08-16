/**
 * 
 */

document.getElementById("data_file_data_file").onchange = function () {
	var inputValue = this.value.replace("C:\\fakepath\\", "");
    document.getElementById("uploadFile").value = inputValue;
};


// Functions to implement data upload check boxes, info and validation

function hideDeleteDatasetForm(event){

    $("#delete_dataset").addClass("hidden");
    
}
function showDeleteDatasetForm(event){

    // var dataset = $( "#form_dataset_to_delete" ).val();
    // $("#dataset_to_delete").innerHTML('dataset');
    $("#delete_dataset").removeClass("hidden");
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


// Function call to implement data upload info and validation

$("#delete_dataset_button").on("click", showDeleteDatasetForm);
$("#cancel_delete_dataset").on("click", hideDeleteDatasetForm);

$("#insert_into_database").on("click", showInsertDatabaseForm);
$("#cancel_database_insert").on("click", hideInsertDatabaseForm);
$("#cancel_database_insert_next").on("click", hideInsertDatabaseFormNext);

$("#continue_anyway").on("click", continueAnyway);
$("#cancel_continue_anyway").on("click", cancleContinueAnyway);

// Protein hide and show
function showProtein(event){
    $("#protein_s").removeClass("hidden");
    $("#show_protein").addClass("hidden");
    $("#hide_protein").removeClass("hidden");
}
function hideProtein(event){
    $("#protein_s").addClass("hidden");
    $("#show_protein").removeClass("hidden");
    $("#hide_protein").addClass("hidden");

}
$("#show_protein").on("click", showProtein);
$("#hide_protein").on("click", hideProtein);




// Protein search button redirection
function search_selected_protein(event){

    var e = document.getElementById("form_Proteins_Inserted");
    var selected_protein = e.options[e.selectedIndex].text;
    // console.log(selected_protein);
    url=Url+"app.php/search/"+selected_protein;
    window.location.href = url;

}
$("#search_protein").on("click", search_selected_protein);



// This ajax request fetches number of rows the choosen file has

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

        var btimestamp= Math.floor(20*2*1.1);
        var bhours = Math.floor(btimestamp / 60 / 60);
        var bminutes = Math.floor(btimestamp / 60) - (bhours * 60);
        var bformatted = bhours + ':' + bminutes + '  (HH:MM)';

        TIME_LIMIT=btimestamp;
        var text_v='There are '+ data + ' interactions in the file. \n Estimate time of completion is: ' + bformatted;
        $("#file_to_insert_next").text(text_v);
        $("#insert_interaction").text(data);
        $("#insert_est").text(bformatted);

        $("#insert_database_next").removeClass("hidden");

    }
});

var start_time=null;
var request_time = null;

// This ajax request uploads data

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
                    startTimer();
                    start_time = new Date().getTime();
                },
        async: true,
        error: function() {
                    alert('Error');
                },
        'success' : function(data) {
            // alert('yay');
            // location.reload();
            request_time = new Date().getTime() - start_time;
            request_time= Math.floor(request_time/1000);
            console.log("time taken is: "+request_time+ " seconds");
            start_time=null;
            request_time=null;

        },
        complete:function(data){
            // Hide image container
            // $("#loader").hide();
            $("#insert_database_next_loading").addClass("hidden");

        }
    });
});




// These function implement timer at loading
// Credit: Mateusz Rybczonec

const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "orange",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "red",
    threshold: ALERT_THRESHOLD
  }
};

let TIME_LIMIT = 20;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;

document.getElementById("app").innerHTML = `
<div class="base-timer">
  <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
      <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
      <path
        id="base-timer-path-remaining"
        stroke-dasharray="283"
        class="base-timer__path-remaining ${remainingPathColor}"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </g>
  </svg>
  <span id="base-timer-label" class="base-timer__label">${formatTime(
    timeLeft
  )}</span>
</div>
`;

// startTimer();

function onTimesUp() {
  clearInterval(timerInterval);
}

function startTimer() {
  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(timeLeft);

    if (timeLeft === 0) {
      onTimesUp();
    }
  }, 1000);
}

function formatTime(time) {
  const hour = Math.floor(time / (60*60));
  const minutes = Math.floor(time / 60) - hour*60;
  let seconds = time % 60;
//   console.log(time + " " + hour + " " + minutes + " " + seconds);
  if (seconds < 10) {
    seconds = `0${seconds}`;
  }

  return `${hour}:${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const { alert, warning, info } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(warning.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(alert.color);
  } else if (timeLeft <= warning.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(info.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(warning.color);
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
  document
    .getElementById("base-timer-path-remaining")
    .setAttribute("stroke-dasharray", circleDasharray);
}

