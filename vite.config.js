import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/properties.css',
                'resources/css/dashboard.css',

                // pages
                'resources/js/app.js',
                'resources/js/dashboard/app.js',
                'resources/js/dashboard/permission-table.js',
                'resources/js/property-gallery.js',

                'resources/js/pages/search-property-full-form.js',
                'resources/js/pages/list-my-property.js',

                // dashboard properties
                'resources/js/dashboard/properties/properties.js',
                'resources/js/dashboard/properties/add-property.js',
                'resources/js/dashboard/properties/edit-property.js',
                'resources/js/dashboard/properties/property-gallery.js',
                'resources/js/dashboard/properties/property-image-gallery-counter.js',
                'resources/js/dashboard/properties/get-property-images.js',
                'resources/js/dashboard/properties/EditImageModal.js',

                'resources/js/dashboard/dashboard.js',
                'resources/js/dashboard/Slugify.js',
                'resources/css/dashboard/dashboard.css',

                // users
                'resources/js/dashboard/users/create.js',
                'resources/js/dashboard/users/edit.js',
                'resources/js/dashboard/users/user-table.js',

                // leads
                'resources/js/dashboard/leads/create.js',
                'resources/js/dashboard/leads/crmIndex.js',
                'resources/js/dashboard/leads/appointment.js',
                'resources/js/dashboard/leads/edit.js',

                // notes
                'resources/js/dashboard/notes/create.js',
                'resources/js/dashboard/notes/notesTable.js',
                'resources/js/dashboard/notes/editNote.js',

                // contact forms
                'resources/js/contactForms/contact-form.js',

                // blogs dashboard
                'resources/js/dashboard/blogs/create.js',
                'resources/js/dashboard/blogs/index.js',
                'resources/js/dashboard/blogs/edit.js',

                // blog post
                'resources/js/pages/blog-post.js',

                // mortgage calculator
                'resources/js/pages/mortgage-calculator.js',
                'resources/js/component/floatingTools/calculator.js',
                'resources/js/component/floatingTools/apec-homes-pagibig-calculator.js',
                'resources/js/component/floatingTools/apec-homes-inhouse-calculator.js',
                'resources/js/component/floatingTools/hausland-inhouse-calculator.js',
                'resources/js/component/floatingTools/formatPeso.js',
                'resources/js/component/floatingTools/plural.js',

                // components
                'resources/css/appointment/my-calendar.css',
                'resources/js/component/appointment/calendar.js',
                'resources/js/component/appointment/my-calendar.js',
                'resources/js/component/notifications/notifications-mark-read.js',
                'resources/js/component/notifications/get-notifications.js',

                // activity logs
                'resources/js/component/activities/logs.js',

                // roles and permissions
                'resources/js/dashboard/roles/roles-table.js',
                'resources/js/dashboard/permissions/permissions-table.js',

                // profile
                'resources/js/dashboard/profile/update-profile.js',

                //tasks
                //js
                'resources/js/dashboard/tasks/dashboard.js',
                'resources/js/dashboard/tasks/tasks-table.js',
                'resources/js/dashboard/tasks/create.js',
                'resources/js/dashboard/tasks/show.js',
                'resources/js/dashboard/tasks/edit.js',
                'resources/js/dashboard/tasks/enable-status-completion.js',

                //task activities
                'resources/css/task/show.css',
                'resources/js/dashboard/task-activities/task-activity-table.js',
                //end ot task activities

                //css
                'resources/css/task/task.css',
                //edn of tasks

                //projects
                'resources/js/dashboard/projects/main.js',
                'resources/js/dashboard/projects/create.js',
                'resources/js/dashboard/projects/show.js',
                'resources/js/dashboard/projects/edit.js',
                'resources/js/dashboard/projects/delete.js',
                'resources/js/dashboard/projects/project-table.js',
                'resources/js/dashboard/projects/mode.js',
                'resources/js/dashboard/projects/submitProject.js',
                //end of projects

                //model units
                'resources/js/dashboard/modelUnits/model-unit-table.js',
                'resources/js/dashboard/modelUnits/add.js',
                'resources/js/dashboard/modelUnits/edit.js',
                'resources/js/dashboard/modelUnits/delete.js',
                'resources/js/dashboard/modelUnits/submit-model-unit.js',
                'resources/js/dashboard/modelUnits/button-loader.js',
                //end of model units

                //computations
                'resources/js/dashboard/computations/computations-table.js',
                'resources/js/dashboard/computations/submitComputation.js',
                'resources/js/dashboard/computations/add.js',
                'resources/js/dashboard/computations/edit.js',
                'resources/js/dashboard/computations/delete.js',
                'resources/js/dashboard/computations/view.js',
                'resources/css/computations.css',
                //end of computations

                //landing page form
                'resources/js/landing-page/form.js',

                //floating tools
                'resources/css/components/floating-tools.css',
                'resources/js/component/floatingTools/floating-tools.js',
                'resources/js/component/floatingTools/computation.js',
                //end of floating tools

                //appointments
                'resources/js/dashboard/appointments/show.js',
                'resources/js/dashboard/appointments/re-schedule-appointment.js',
                //edn of appointments

                //sales
                'resources/css/sales.css',
                'resources/js/dashboard/sales/create.js',
                //end of sales
            ],
            refresh: true,
        }),
    ],

    // 👇 ADD THIS SECTION
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    pdf: ['html2pdf.js'],
                },
            },
        },
    },
});
