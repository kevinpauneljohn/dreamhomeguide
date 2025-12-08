import "summernote/dist/summernote-lite.js";
import "summernote/dist/summernote-lite.css";
import {slugify} from '../Slugify.js';
import {Toast} from "@/toast.js";

let content = $('input[name=content]').val();
let blogEditor = $('#blog_content');
$(function (){
    blogEditor.summernote({
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
        callbacks: {
            onInit: function () {
                blogEditor.summernote('code', content);
            }
        }
    });

    const title = $('#title');

    title.on('input', function () {
        $('#slug').val(slugify(title.val()));
    })
});

$(document).on('submit', '#edit-blog-form', function (e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    // FIX 1: Add Summernote content manually
    formData.set('blog_content', $('#blog_content').summernote('code'));

    // FIX 2: Spoof PUT METHOD for Laravel
    formData.append('_method', 'PUT');
    updateBlog(formData);
})

const editBlogForm = $('#edit-blog-form');
const blog_id = $('#blog_id').val();
const updateBlog = (formData) => {
    $.ajax({
        url: '/blog/'+blog_id,
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function(){
            editBlogForm.find('.is-invalid').removeClass('is-invalid');
            editBlogForm.find('.invalid-feedback').remove();

            editBlogForm.find('input, select, textarea').attr('disabled', true);
            editBlogForm.find('.save-blog-btn').attr('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Updating...</span>`);
        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: response.message
            })
            $('#thumbnail').val('')
        }else{
            Toast.fire({
                icon: 'warning',
                title: response.message
            })
        }
    }).fail(function (xhr) {
        console.log(xhr);
        $.each(xhr.responseJSON.errors, function (key, value) {
            console.log(key, value);
            editBlogForm.find('#' + key).addClass('is-invalid');
            editBlogForm.find('.' + key).append(`<p class="invalid-feedback error">${value}</p>`);
        });
    }).always(function () {
        editBlogForm.find('input, select, textarea').attr('disabled', false);
        editBlogForm.find('.save-blog-btn').attr('disabled', false)
            .html(`<i class="bi bi-save"></i> Update Blog`);
    })
}

