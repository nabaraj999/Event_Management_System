{{-- resources/views/admin/support/show.blade.php --}}

<x-admin.admin-layout>

    <div class="py-8 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-4 mb-3">
                        <a href="{{ route('admin.support.index') }}"
                           class="text-blue-200 hover:text-white transition flex items-center font-medium">
                            ← Back to Tickets
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold">
                        Ticket #{{ $ticket->ticket_id }} – {{ $ticket->subject }}
                    </h1>
                    <p class="text-blue-200 mt-3">
                        Organizer: <strong>{{ $ticket->organizer->name }}</strong> ({{ $ticket->organizer->email }})
                        <br>
                        Opened: {{ $ticket->created_at->format('d M Y \a\t h:i A') }}
                        @if($ticket->last_replied_at)
                            • Last activity: {{ $ticket->last_replied_at->diffForHumans() }}
                        @endif
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <!-- Priority Badge -->
                    <span class="px-6 py-3 text-lg font-medium rounded-xl
                        @if($ticket->priority === 'urgent')
                            bg-red-600 text-white shadow-lg
                        @else
                            bg-orange-500 text-white shadow-lg
                        @endif">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>

                    <!-- Status Badge -->
                    <span class="px-6 py-3 text-lg font-medium rounded-xl
                        @switch($ticket->status)
                            @case('open') bg-blue-600 text-white @break
                            @case('waiting_for_reply') bg-purple-600 text-white @break
                            @case('replied') bg-green-600 text-white @break
                            @case('closed') bg-gray-600 text-white @break
                            @default bg-gray-500 text-white
                        @endswitch shadow-lg">
                        {{ ucwords(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-8 p-6 bg-green-100 border border-green-400 text-green-800 rounded-2xl shadow">
                <p class="text-lg font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Conversation Thread -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="divide-y divide-gray-100">
                @foreach($ticket->replies as $reply)
                    <div class="p-8 {{ $reply->replier_type === 'admin' ? 'bg-blue-50' : 'bg-orange-50' }}">
                        <div class="flex items-start gap-6">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg
                                    {{ $reply->replier_type === 'admin' ? 'bg-darkBlue' : 'bg-primary' }}">
                                    {{ $reply->replier_type === 'admin' ? 'Admin' : 'Org' }}
                                </div>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="text-xl font-bold text-gray-900">
                                            {{ $reply->replier_type === 'admin' ? 'You (Admin)' : $ticket->organizer->name }}
                                        </span>
                                        <span class="text-sm text-gray-500 ml-6">
                                            {{ $reply->created_at->format('d M Y \a\t h:i A') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="prose max-w-none text-gray-800 mb-6 text-lg leading-relaxed">
                                    {!! nl2br(e($reply->message)) !!}
                                </div>

                                <!-- Attachments -->
                                @if($reply->attachments->count() > 0)
                                    <div class="mt-6">
                                        <p class="font-semibold text-gray-800 mb-4 text-lg">
                                            Attachments ({{ $reply->attachments->count() }})
                                        </p>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                                            @foreach($reply->attachments as $attachment)
                                                <div class="border border-gray-300 rounded-xl overflow-hidden bg-white shadow hover:shadow-lg transition">
                                                    @if(str_starts_with($attachment->file_type, 'image/'))
                                                        <a href="{{ $attachment->getUrlAttribute() }}" target="_blank">
                                                            <img src="{{ $attachment->getUrlAttribute() }}"
                                                                 alt="{{ $attachment->file_name }}"
                                                                 class="w-full h-48 object-cover">
                                                        </a>
                                                    @else
                                                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                                                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="p-4 bg-gray-50">
                                                        <p class="text-sm font-medium text-gray-700 truncate">{{ $attachment->file_name }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">{{ number_format($attachment->file_size / 1024, 1) }} KB</p>
                                                        <a href="{{ $attachment->getUrlAttribute() }}"
                                                           target="_blank"
                                                           class="text-primary font-semibold text-sm hover:underline mt-2 inline-block">
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

        <!-- Admin Actions: Reply + Close -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Reply Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-8 lg:p-10">
                        <h2 class="text-2xl font-bold text-darkBlue mb-6">Send Reply to Organizer</h2>

                        <form action="{{ route('admin.support.reply', $ticket) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-8">
                                <textarea name="message"
                                          rows="10"
                                          required
                                          class="w-full px-6 py-5 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-primary transition resize-none text-base"
                                          placeholder="Write your professional response here..."></textarea>
                                @error('message')
                                    <p class="mt-3 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-8">
                                <label class="block text-lg font-medium text-gray-700 mb-4">
                                    Attach Files (Optional)
                                </label>
                                <input type="file"
                                       name="attachments[]"
                                       multiple
                                       accept="image/*,.pdf,.doc,.docx,.txt,.zip"
                                       class="w-full px-6 py-5 border border-gray-200 rounded-xl file:mr-6 file:py-4 file:px-8 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-primary file:text-white hover:file:bg-orange-600 cursor-pointer">
                                <p class="mt-4 text-sm text-gray-500">Max 10MB per file</p>
                            </div>

                            <button type="submit"
                                    class="px-12 py-5 bg-primary hover:bg-orange-600 text-white font-bold text-xl rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                                Send Reply
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Close Ticket Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden h-fit">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Ticket Actions</h3>

                        @if($ticket->status !== 'closed')
                            <form action="{{ route('admin.support.close', $ticket) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to close this ticket? The organizer will no longer be able to reply.')"
                                        class="w-full px-8 py-5 bg-red-600 hover:bg-red-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                                    Close Ticket
                                </button>
                            </form>
                            <p class="mt-4 text-sm text-gray-600 text-center">
                                Closing prevents further replies.
                            </p>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <p class="text-xl font-semibold text-gray-700">This ticket is closed</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 6000,
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush

</x-admin.admin-layout>
