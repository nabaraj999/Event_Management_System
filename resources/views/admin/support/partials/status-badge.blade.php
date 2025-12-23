{{-- resources/views/admin/support/partials/status-badge.blade.php --}}

@php
    $status = $status ?? 'unknown';
@endphp

@switch($status)
    @case('open')
        <span class="px-4 py-1.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Open</span>
        @break
    @case('waiting_for_reply')
        <span class="px-4 py-1.5 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">Waiting for Reply</span>
        @break
    @case('replied')
        <span class="px-4 py-1.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">Replied</span>
        @break
    @case('closed')
        <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Closed</span>
        @break
    @default
        <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Unknown</span>
@endswitch
