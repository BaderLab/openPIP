function showAnnouncmentForm(event){
    $("#announcement_upload").removeClass("hidden");
}

function hideAnnouncmentForm(event){
    $("#announcement_upload").addClass("hidden");
}

$("#new_announcement").on("click", showAnnouncmentForm);
$("#cancel_announcement").on("click", hideAnnouncmentForm);

document.getElementById("data_file_data_file").onchange = function () {
	var inputValue = this.value.replace("C:\\fakepath\\", "");
    document.getElementById("uploadFile").value = inputValue;
};
