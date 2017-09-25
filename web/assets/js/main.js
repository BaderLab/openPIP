
$("#new_announcement").on("click", showAnnouncmentForm);
$("#cancel_announcement").on("click", hideAnnouncmentForm);
$(".dataset_request_links").on("click", showDatasetRequestForm);
$("#cancel_dataset_request").on("click", hideDatasetRequestForm);
$(".data_request_links").on("click", showDataRequestForm);
$(".cancel_data_request").on("click", hideDataRequestForm);
$("#download_unpublished_data_link").on("click", hideDataRequestForm);
$("#delete_dataset_button").on("click", showDeleteDatasetForm);
$("#cancel_delete_dataset").on("click", hideDeleteDatasetForm);
$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') ) {
        $(this).collapse('hide');
    }
});

$(".edit_name").on("click", showNameForm);
$(".hide_edit_name").on("click", hideNameForm);
$(".cancel_cy_message").on("click", hideCyMessage);


function showCyMessage(){
	$("#cy_message").removeClass("hidden");
    $(".qtip").addClass("hidden");
    $("body").addClass("noscroll");
}

function hideCyMessage(){

	$("#cy_message").addClass("hidden");
    $("body").removeClass("noscroll");
}

function showAnnouncmentForm(event){
    $("#announcement_upload").removeClass("hidden");
}

function hideAnnouncmentForm(event){
    $("#announcement_upload").addClass("hidden");
}

function showDatasetRequestForm(event){

	if(loggedIn == true){

		$("#data_request_logged_in").removeClass("hidden");
		$("#form_request_dataset").val($(event.target).attr('data'));
	    $("#form_request_file_format").val($(event.target).attr('format'));
		
	}else{

		$("#data_request_logged_out").removeClass("hidden");
		
	}

    $(".qtip").addClass("hidden");
    $("body").addClass("noscroll");
}

function hideDatasetRequestForm(event){
    $("#dataset_request").addClass("hidden");
    $("body").removeClass("noscroll");
}

function hideDeleteDatasetForm(event){

    $("#delete_dataset").addClass("hidden");
    
}

function subDown(event){
    $("#form").submit();    
}

function showDataRequestForm(event){
	if(loggedIn == true){

		$("#data_request_logged_in").removeClass("hidden");
	}else{

		$("#data_request_logged_out").removeClass("hidden");
		
	}

    $("#form_request_interaction_network_data").val($(event.target).attr('data'));
    
    $(".qtip").addClass("hidden");
    $("body").addClass("noscroll");
    
}

function hideDataRequestForm(event){
	$("#data_request_logged_in").addClass("hidden");
	$("#data_request_logged_out").addClass("hidden");
    $("body").removeClass("noscroll");
}

function showDeleteDatasetForm(event){

    var dataset = $( "#form_dataset_to_delete option:selected" ).text();
    
    $("#dataset_to_delete").html(dataset);    
    $("#delete_dataset").removeClass("hidden");

}

function showNameForm(event){

	var networkId = $(event.target).attr('data');
	$("#" + networkId + "_name").addClass("hidden");
	$("#" + networkId + "_name_form").removeClass("hidden");
	$("#" + networkId + "_edit_name").addClass("hidden");
	$("#" + networkId + "_hide_edit_name").removeClass("hidden");
}

function hideNameForm(event){

	var networkId = $(event.target).attr('data');
	$("#" + networkId + "_name").removeClass("hidden");
	$("#" + networkId + "_name_form").addClass("hidden");
	$("#" + networkId + "_edit_name").removeClass("hidden");
	$("#" + networkId + "_hide_edit_name").addClass("hidden");
	
	
}

//left: 37, up: 38, right: 39, down: 40,
//spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
e = e || window.event;
if (e.preventDefault)
 e.preventDefault();
e.returnValue = false;  
}

function preventDefaultForScrollKeys(e) {
if (keys[e.keyCode]) {
   preventDefault(e);
   return false;
}
}

function disableScroll() {

	 window.addEventListener('DOMMouseScroll', preventDefault, false);
	window.onwheel = preventDefault; // modern standard
	window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
	window.ontouchmove  = preventDefault; // mobile
	document.onkeydown  = preventDefaultForScrollKeys;
	}

function enableScroll() {
if (window.removeEventListener)
   window.removeEventListener('DOMMouseScroll', preventDefault, false);
window.onmousewheel = document.onmousewheel = null; 
window.onwheel = null; 
window.ontouchmove = null;  
document.onkeydown = null;  
}




