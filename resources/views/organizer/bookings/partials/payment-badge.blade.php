@switch($status)
    @case('paid')     <span class="px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span> @break
    @case('pending')  <span class="px-2.5 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span> @break
    @case('failed')   <span class="px-2.5 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Failed</span> @break
    @case('refunded') <span class="px-2.5 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Refunded</span> @break
    @default          <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">{{ ucfirst($status) }}</span>
@endswitch
