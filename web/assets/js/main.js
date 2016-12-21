function showAnnouncmentForm(event){
    $("#announcement_upload").removeClass("hidden");
}

function hideAnnouncmentForm(event){
    $("#announcement_upload").addClass("hidden");
}

$("#new_announcement").on("click", showAnnouncmentForm);
$("#cancel_announcement").on("click", hideAnnouncmentForm);


function showDatasetRequestForm(event){

    $("#dataset_request").removeClass("hidden");
    
    
    $("#form_dataset").val(event.target.id);
    $(".qtip").addClass("hidden");
    
}

function hideDatasetRequestForm(event){
    $("#dataset_request").addClass("hidden");
    
}

$(".dataset_request_links").on("click", showDatasetRequestForm);
$("#cancel_dataset_request").on("click", hideDatasetRequestForm);

function hideDeleteDatasetForm(event){

    $("#delete_dataset").addClass("hidden");
    
}

function subDown(event){
	$("#download_dataset").click();	
    $("#form").submit();
    
}

$("#down_data").on("click", subDown);




function showDeleteDatasetForm(event){

    var dataset = $( "#form_dataset_to_delete option:selected" ).text();
    
    
    $("#dataset_to_delete").html(dataset);    
    $("#delete_dataset").removeClass("hidden");

}

$("#delete_dataset_button").on("click", showDeleteDatasetForm);
$("#cancel_delete_dataset").on("click", hideDeleteDatasetForm);

$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') ) {
        $(this).collapse('hide');
    }
});


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
if (window.addEventListener) // older FF
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

disableScroll();
$(window).load(function() {
	// Animate loader off screen
	$(".se-pre-con").fadeOut("slow");
	enableScroll();
});



