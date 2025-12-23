{{-- resources/views/organizer/support/show.blade.php --}}

<x-organizer.organizer-layout>

    <div class="py-8 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <a href="{{ route('org.support.index') }}"
                           class="text-blue-200 hover:text-white transition flex items-center">
                            ← Back to Tickets
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold">
                        Ticket #{{ $ticket->ticket_id }} – {{ $ticket->subject }}
                    </h1>
                    <p class="text-blue-200 mt-2">
                        Opened on {{ $ticket->created_at->format('d M Y \a\t h:i A') }}
                        @if($ticket->last_replied_at)
                            • Last activity {{ $ticket->last_replied_at->diffForHumans() }}
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Priority Badge -->
                    <span class="px-5 py-2.5 text-sm font-medium rounded-xl
                        @if($ticket->priority === 'urgent')
                            bg-red-600 text-white
                        @else
                            bg-orange-500 text-white
                        @endif">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>

                    <!-- Status Badge -->
                    <span class="px-5 py-2.5 text-sm font-medium rounded-xl
                        @switch($ticket->status)
                            @case('open') bg-blue-600 text-white @break
                            @case('waiting_for_reply') bg-purple-600 text-white @break
                            @case('replied') bg-green-600 text-white @break
                            @case('closed') bg-gray-600 text-white @break
                            @default bg-gray-500 text-white
                        @endswitch">
                        {{ ucwords(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Conversation Thread -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="divide-y divide-gray-100">
                @foreach($ticket->replies as $reply)
                    <div class="p-8 {{ $reply->replier_type === 'organizer' ? 'bg-orange-50' : 'bg-gray-50' }}">
                        <div class="flex items-start gap-6">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg
                                    {{ $reply->replier_type === 'organizer' ? 'bg-primary' : 'bg-darkBlue' }}">
                                    {{ $reply->replier_type === 'organizer' ? 'You' : 'Admin' }}
                                </div>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="text-lg font-semibold text-gray-900">
                                            {{ $reply->replier_type === 'organizer' ? 'You' : 'Support Team' }}
                                        </span>
                                        <span class="text-sm text-gray-500 ml-4">
                                            {{ $reply->created_at->format('d M Y \a\t h:i A') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="prose max-w-none text-gray-700 mb-6">
                                    {!! nl2br(e($reply->message)) !!}
                                </div>

                                <!-- Attachments -->
                                @if($reply->attachments->count() > 0)
                                    <div class="mt-6">
                                        <p class="font-medium text-gray-700 mb-4">
                                            Attachments ({{ $reply->attachments->count() }})
                                        </p>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                            @foreach($reply->attachments as $attachment)
                                                <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm hover:shadow-md transition">
                                                    @if(str_starts_with($attachment->file_type, 'image/'))
                                                        <a href="{{ $attachment->getUrlAttribute() }}" target="_blank" class="block">
                                                            <img src="{{ $attachment->getUrlAttribute() }}"
                                                                 alt="{{ $attachment->file_name }}"
                                                                 class="w-full h-40 object-cover">
                                                        </a>
                                                    @else
                                                        <div class="h-40 bg-gray-100 flex items-center justify-center">
                                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="p-4">
                                                        <p class="text-xs text-gray-600 truncate font-medium">
                                                            {{ $attachment->file_name }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ number_format($attachment->file_size / 1024, 1) }} KB
                                                        </p>
                                                        <a href="{{ $attachment->getUrlAttribute() }}"
                                                           target="_blank"
                                                           class="text-primary text-xs font-semibold hover:underline mt-2 inline-block">
                                                            Download →
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Reply Form (Only if not closed) -->
        @if($ticket->status !== 'closed')
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-darkBlue mb-6">
                        Send a Reply
                    </h2>

                    <form action="{{ route('org.support.reply', $ticket) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <textarea name="message"
                                      rows="8"
                                      required
                                      class="w-full px-6 py-4 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-primary transition resize-none"
                                      placeholder="Write your reply here..."></textarea>
                            @error('message')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Add Attachments (Optional)
                            </label>
                            <input type="file"
                                   name="attachments[]"
                                   multiple
                                   accept="image/*,.pdf,.doc,.docx,.txt,.zip"
                                   class="w-full px-6 py-4 border border-gray-200 rounded-xl file:mr-6 file:py-3 file:px-8 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary file:text-white hover:file:bg-orange-600 cursor-pointer">
                            <p class="mt-3 text-sm text-gray-500">Images, PDFs, documents (max 10MB each)</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-10 py-4 bg-primary hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                                Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-gray-100 rounded-2xl p-12 text-center">
                <svg class="mx-auto h-20 w-20 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <p class="text-2xl font-semibold text-gray-700">This ticket is closed</p>
                <p class="text-gray-600 mt-3">No further replies are possible. Create a new ticket if needed.</p>
            </div>
        @endif
    </div>

    <!-- SweetAlert2 Success Message -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 5000,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-organizer.organizer-layout>
