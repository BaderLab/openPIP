var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
url: "/app.php/_uploader/gallery/upload", // Set the url
maxFilesize: 209715200,
timeout: 18000000,
thumbnailWidth: 80,
thumbnailHeight: 80,
parallelUploads: 20,
previewTemplate: previewTemplate,
autoQueue: false, // Make sure the files aren't queued until manually added
previewsContainer: "#upload_preview", // Define the container to display the previews
clickable: "#upload_panel" // Define the element that should be used as click trigger to select files.
});

myDropzone.on("addedfile", function(file) {
// Hookup the start button
file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
});

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});

// myDropzone.on("sending", function(file) {
// // Show the total progress bar when upload starts
// document.querySelector("#total-progress").style.opacity = "1";
// // And disable the start button
// file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
// });

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
document.querySelector("#total-progress").style.opacity = "0";
});

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
};
document.querySelector("#actions .cancel").onclick = function() {
myDropzone.removeAllFiles(true);
};