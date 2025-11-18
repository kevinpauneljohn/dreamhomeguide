import "summernote/dist/summernote-lite.js";
import "summernote/dist/summernote-lite.css";

document.getElementById('thumbnailInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if (file) {
        document.getElementById('thumbnailPreview').src = URL.createObjectURL(file);
    }
});

// Initialize summernote
$(document).ready(function () {
    $('#description').summernote({
        height: 250,
        placeholder: 'Write a detailed description here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture','table', 'hr']],
            ['view', ['codeview','help']],
        ]
    });
});

/**
 * MULTIPLE GALLERY IMAGE PREVIEW
 */
document.getElementById('galleryInput').addEventListener('change', function (e) {
    const container = document.getElementById('galleryPreview');
    container.innerHTML = ""; // Clear old previews

    const files = e.target.files;

    [...files].forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (event) {
            const wrapper = document.createElement('div');
            wrapper.classList.add("position-relative");

            wrapper.innerHTML = `
                <img src="${event.target.result}" class="rounded border" width="120" height="90" style="object-fit: cover;">
                <button type="button" data-index="${index}" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-gallery-image"
                        style="transform: translate(50%, -50%); border-radius: 50%;">
                    ✕
                </button>
            `;

            container.appendChild(wrapper);
        };

        reader.readAsDataURL(file);
    });
});

// OPTIONAL: Allow removing preview before uploading
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-gallery-image")) {
        const index = e.target.dataset.index;

        // Remove preview
        e.target.parentElement.remove();

        // Remove from input file list
        let input = document.getElementById("galleryInput");
        let dt = new DataTransfer();

        let { files } = input;

        [...files].forEach((file, i) => {
            if (i != index) dt.items.add(file);
        })

        input.files = dt.files;
    }
});

