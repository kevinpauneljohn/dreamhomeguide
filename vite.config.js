import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/properties.css',
                'resources/css/dashboard.css',

                //pages
                'resources/js/app.js',
                'resources/js/dashboard/app.js',
                'resources/js/dashboard/permission-table.js',
                'resources/js/property-gallery.js',

                'resources/js/pages/search-property-full-form.js',
                'resources/js/pages/list-my-property.js',

                ///dashboard properties
                'resources/js/dashboard/properties/properties.js',
                'resources/js/dashboard/properties/add-property.js',
                'resources/js/dashboard/properties/edit-property.js',
                'resources/js/dashboard/properties/property-gallery.js',
                'resources/js/dashboard/properties/property-image-gallery-counter.js',
                'resources/js/dashboard/properties/get-property-images.js',
                'resources/js/dashboard/properties/EditImageModal.js',

                'resources/js/dashboard/dashboard.js',

                'resources/js/dashboard/Slugify.js',

                //users
                'resources/js/dashboard/users/create.js',
                'resources/js/dashboard/users/edit.js',
                'resources/js/dashboard/users/user-table.js',

                //leads
                'resources/js/dashboard/leads/create.js',
                'resources/js/dashboard/leads/crmIndex.js',
                'resources/js/dashboard/leads/appointment.js',
                'resources/js/dashboard/leads/edit.js',

                //notes
                'resources/js/dashboard/notes/create.js',
                'resources/js/dashboard/notes/notesTable.js',
                'resources/js/dashboard/notes/editNote.js',

                //contact forms
                'resources/js/contactForms/contact-form.js',

                //blogs dashboard
                'resources/js/dashboard/blogs/create.js',
                'resources/js/dashboard/blogs/index.js',
                'resources/js/dashboard/blogs/edit.js',

                //blog post
                'resources/js/pages/blog-post.js',

                //mortgage calculator
                'resources/js/pages/mortgage-calculator.js',

                //component
                'resources/js/component/appointment/calendar.js',
                'resources/js/component/notifications/notifications-mark-read.js',
                'resources/js/component/notifications/get-notifications.js',

                //activity logs
                'resources/js/component/activities/logs.js',

                //roles and permissions
                'resources/js/dashboard/roles/roles-table.js',

            ],
            refresh: true,
        }),
    ],
});
