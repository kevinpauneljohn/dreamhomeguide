import "summernote/dist/summernote-lite.js";
import "summernote/dist/summernote-lite.css";
import Swal from "sweetalert2";
import {slugify} from '../Slugify.js';
// Initialize summernote
$(document).ready(function () {

    $('#blog_content').summernote({
        height: 650,
        lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
        disableDragAndDrop: true,
        codeviewFilter: false,
        codeviewIframeFilter: true,
        placeholder: 'Write a detailed description here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture','table', 'hr', 'picture', 'video']],
            ['view', ['codeview','help']],
        ],
    });

    const title = $('#title');

    title.on('input', function () {
        $('#slug').val(slugify(title.val()));
    })

});

$(document).on('submit', '#create-blog-form', function (e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    saveBlog(formData);
})

const createBlogForm = $('#create-blog-form');
const saveBlog = (formData) => {
    $.ajax({
        url: '/blog',
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function(){
            createBlogForm.find('.is-invalid').removeClass('is-invalid');
            createBlogForm.find('.invalid-feedback').remove();

            createBlogForm.find('input, select, textarea').attr('disabled', true);
            createBlogForm.find('.save-blog-btn').attr('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Publishing...</span>`);
        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1300
            }).then((result) => {
                window.location.replace('/blog/'+response.slug);
            });

        }
    }).fail(function (xhr) {
        console.log(xhr);
        $.each(xhr.responseJSON.errors, function (key, value) {
            console.log(key, value);
            createBlogForm.find('#' + key).addClass('is-invalid');
            createBlogForm.find('.' + key).append(`<p class="invalid-feedback error">${value}</p>`);
        });
    }).always(function () {
        createBlogForm.find('input, select, textarea').attr('disabled', false);
        createBlogForm.find('.save-blog-btn').attr('disabled', false)
            .html(`<i class="bi bi-save"></i> Publish Blog`);
    })
}



