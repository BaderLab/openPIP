Dropzone.autoDiscover = false;
$(document).ready(function() {
    initializeDropzone();
    // var $locationSelect = $('.js-article-form-location');
    // var $specificLocationTarget = $('.js-specific-location-target');
    // $locationSelect.on('change', function(e) {
    //     $.ajax({
    //         url: $locationSelect.data('specific-location-url'),
    //         data: {
    //             location: $locationSelect.val()
    //         },
    //         success: function (html) {
    //             if (!html) {
    //                 $specificLocationTarget.find('select').remove();
    //                 $specificLocationTarget.addClass('d-none');
    //                 return;
    //             }
    //             // Replace the current field and show
    //             $specificLocationTarget
    //                 .html(html)
    //                 .removeClass('d-none')
    //         }
    //     });
    // });
});
function initializeDropzone() {
    var formElement = document.querySelector('.js-reference-dropzone');
    if (!formElement) {
        return;
    }
    var dropzone = new Dropzone(formElement, {
        paramName: 'reference',
        addRemoveLinks: true,   
        init: function () {
            // Set up any event handlers
            this.on('completemultiple', function () {
                location.reload();
            });
        }
    
    });

    dropzone.on("complete", function (file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            // alert('Your action, Refresh your page here. ');
            location.reload();
        }

        // dropzone.removeFile(file);
        //  # remove file from the zone.
    });

}