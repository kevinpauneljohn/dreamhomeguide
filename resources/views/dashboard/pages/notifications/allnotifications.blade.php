@extends('dashboard.layouts.app')
@section('title', $title)
@section('content')

    <div class="card card-default mx-auto">
        <div class="card-header card-header-border-bottom">
            All Notifications
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Notification</th>
                    <th>Description</th>
                    <th class="text-nowrap">Received</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($notifications as $notification)
                    @php
                        $type = ucwords(str_replace('_', ' ', $notification->data['type']));
                        $isUnread = is_null($notification->read_at);
                    @endphp

                    <tr class="{{ $isUnread ? 'table-info' : '' }}">

                        <!-- Type -->
                        <td class="fw-semibold">
                            {{ $type }}
                        </td>

                        <!-- Description -->
                        <td class="text-muted">
                            {!! $notification->data['description'] ?? '—' !!}
                        </td>

                        <!-- Time -->
                        <td class="text-nowrap text-muted small">
                            {{ $notification->created_at->diffForHumans() }}
                        </td>

                        <!-- Action -->
                        <td class="text-center">
                            <a href="{{ $notification->data['url'].'?notification=read&id='.$notification->id ?? '#' }}"
                               class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No notifications found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $notifications->links() }}
            </div>

        </div>
    </div>

@endsection

