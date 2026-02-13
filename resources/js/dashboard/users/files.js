import {Toast} from "@/toast.js";
import Dropzone from "dropzone";

const userId = document.getElementById('commission-form').dataset.userId;

// DropzoneJS Demo Code Start
Dropzone.autoDiscover = false

// Get the template HTML and remove it from the document template HTML and remove it from the document
let previewNode = document.querySelector("#template")
previewNode.id = ""
let previewTemplate = previewNode.parentNode.innerHTML
previewNode.parentNode.removeChild(previewNode)


const myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: `/users/${userId}/files/upload`, // Set the url
    method: 'post',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
    success: function (file, response) {
        // console.log(file)
        console.log(response)
        if(response.success === true)
        {
            Toast.fire({
                icon: "success",
                title: response.message
            });
            // propertyImagesTable.ajax.reload(null, false);
            setTimeout(function(){
                $('.dz-complete').fadeOut();
            },2500)
        }
    },
    error: function (file, error) {
        console.log(error)
        Toast.fire({
            icon: "error",
            title: error.message
        });
    }
})

myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() {
        myDropzone.enqueueFile(file)
        // console.log(file)
    }
})

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
})

myDropzone.on("sending", function(file, xhr, data) {
    data.append('user_id', userId);
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
})

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
})

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    // console.log(myDropzone)
}
document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
}
// DropzoneJS Demo Code End
