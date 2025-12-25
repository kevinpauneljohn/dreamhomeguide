@if(request()->has(['notification','id']))
    <div id="notification-getter" data-notification-id="{{request('id')}}"></div>

    @pushonce('scripts')
        @vite(['resources/js/component/notifications/notifications-mark-read.js'])
    @endpushonce
@endif

@pushonce('scripts')
    @vite(['resources/js/component/notifications/get-notifications.js'])
@endpushonce
