
<div id='calendar' data-editable='{{ $editable }}' data-url='{{ $getAllUrl }}'></div>

@pushonce('scripts')
    @vite('resources/js/dashboard/leads/appointment.js')
{{--    @vite('resources/js/component/appointment/calendar.js')--}}
@endpushonce
