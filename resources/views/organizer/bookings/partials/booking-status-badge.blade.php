@switch($status)
    @case('confirmed') <span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Confirmed</span> @break
    @case('pending')   <span class="px-2.5 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">Pending</span> @break
    @case('cancelled') <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Cancelled</span> @break
    @default           <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">{{ ucfirst($status) }}</span>
@endswitch
