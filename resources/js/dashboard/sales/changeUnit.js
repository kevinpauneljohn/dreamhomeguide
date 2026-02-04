import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
select2()

$(function (){
    $('#lead_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Client',
        allowClear: true,
    });
    $('#user_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Agent',
        allowClear: true,
    });
    $('#project_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Project',
        allowClear: true,
    });

    $('select[name=model_unit_id]').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Unit',
        allowClear: true,
    });
});
const changeUnits = (project, unit) => {
    if (!project) {
        // Clear model units safely
        $('select[name="model_unit_id"]')
            .html('<option value="">Select Unit</option>')
            .val(null)
            .trigger('change');
        return;
    }

    $.ajax({
        url: "/get-project-units/" + project,
        type: "GET",
        data: {"model_id" : unit},
    })
        .done(function (data) {
            $('select[name="model_unit_id"]').html(data).trigger('change');
        })
        .fail(function (xhr) {
            console.log(xhr);
        });
};

export {changeUnits};
