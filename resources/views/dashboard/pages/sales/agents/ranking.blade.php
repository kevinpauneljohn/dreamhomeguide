@foreach($agentRanking as $index => $row)
    @php
        $agent = $row->agent;
        $initials = $agent
            ? collect(explode(' ', $agent->full_name))
                ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                ->join('')
            : 'NA';
    @endphp

    <tr>
        {{-- RANK --}}
        <td class="fw-bold">{{ $index + 1 }}</td>

        {{-- AGENT WITH PHOTO --}}
        <td>
            <div class="d-flex align-items-center gap-2">

                {{-- PROFILE PHOTO --}}
                @if($agent && $agent->profile_photo)
                    <img
                        src="{{ asset('/storage/profile_pictures/' . $agent->profile_photo) }}"
                        alt="{{ $agent->full_name }}"
                        class="rounded-circle"
                        width="36"
                        height="36"
                        style="object-fit: cover;"
                    >
                @else
                    <div
                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                        style="width:36px;height:36px;font-size:12px;"
                    >
                        {{ $initials }}
                    </div>
                @endif

                {{-- NAME --}}
                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">
                                                        {{ $agent->full_name ?? 'N/A' }}
                                                    </span>
                    <div class="d-flex gap-1 flex-wrap">
                        @forelse($agent->getRoleNames() as $role)
                            <span class="badge bg-secondary-subtle text-secondary">
                                                                {{ $role }}
                                                            </span>
                        @empty
                            <span class="badge bg-light text-muted">Agent</span>
                        @endforelse
                    </div>


                </div>
            </div>
        </td>

        {{-- UNITS SOLD --}}
        <td>
                                        <span class="badge bg-primary">
                                            {{ $row->units_sold }}
                                        </span>
        </td>

        {{-- TOTAL AMOUNT --}}
        <td class="fw-semibold text-success">
            ₱{{ number_format($row->total_amount, 2) }}
        </td>
    </tr>
@endforeach
