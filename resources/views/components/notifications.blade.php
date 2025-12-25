@if(request()->has(['notification','id']))
    <div id="notification-getter" data-notification-id="{{request('id')}}"></div>

    @pushonce('scripts')
        @vite(['resources/js/component/notifications.js'])
    @endpushonce
@endif
