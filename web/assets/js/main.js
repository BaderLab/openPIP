function showAnnouncmentForm(event){
    $("#announcement_upload").removeClass("hidden");
}

function hideAnnouncmentForm(event){
    $("#announcement_upload").addClass("hidden");
}

$("#new_announcement").on("click", showAnnouncmentForm);
$("#cancel_announcement").on("click", hideAnnouncmentForm);