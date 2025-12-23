{{-- resources/views/organizer/support/create.blade.php --}}

<x-organizer.organizer-layout>

    <div class="py-8 px-4 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-4 mb-3">
                        <a href="{{ route('org.support.index') }}"
                            class="text-blue-200 hover:text-white transition flex items-center font-medium">
                            ← Back to Tickets
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold">
                        Submit a New Support Ticket
                    </h1>
                    <p class="text-blue-200 mt-2">
                        Need help? We're here for you. Describe your issue clearly and attach screenshots if possible.
                    </p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-8 p-6 bg-green-100 border border-green-400 text-green-800 rounded-2xl shadow">
                <p class="text-lg font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Create Ticket Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 lg:p-10">
                <form action="{{ route('org.support.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Subject -->
                    <div class="mb-8">
                        <label for="subject" class="block text-lg font-medium text-gray-700 mb-3">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                            class="w-full px-6 py-4 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-primary transition text-lg"
                            placeholder="Brief summary of your issue (e.g., Can't publish event)">
                        @error('subject')
                            <p class="mt-3 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-8">
                        <label for="priority" class="block text-lg font-medium text-gray-700 mb-3">
                            Priority Level
                        </label>
                        <select name="priority" id="priority"
                            class="w-full px-6 py-4 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-primary transition text-lg">
                            <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>
                                Normal
                            </option>
                            <option value="urgent" class="text-red-600 font-bold"
                                {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                Urgent – Blocks my work (immediate help needed)
                            </option>
                        </select>
                        <p class="mt-3 text-sm text-gray-500">
                            Use <strong>Urgent</strong> only if the issue completely prevents you from using the
                            platform.
                        </p>
                    </div>

                    <!-- Message -->
                    <div class="mb-8">
                        <label for="message" class="block text-lg font-medium text-gray-700 mb-3">
                            Describe Your Issue <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" id="message" rows="10" required
                            class="w-full px-6 py-5 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-primary transition resize-none text-base"
                            placeholder="Please explain:
• What you were trying to do
• What happened instead
• Steps to reproduce the issue
• Any error messages you saw...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-3 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attachments -->
                    <div class="mb-10">
                        <label for="attachments" class="block text-lg font-medium text-gray-700 mb-4">
                            Attach Screenshots or Files (Optional)
                        </label>
                        <input type="file" name="attachments[]" id="attachments" multiple
                            accept="image/*,.pdf,.doc,.docx,.txt,.zip"
                            class="w-full px-6 py-5 border border-gray-200 rounded-xl file:mr-6 file:py-4 file:px-8 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-primary file:text-white hover:file:bg-orange-600 cursor-pointer transition text-gray-600">

                        <p class="mt-4 text-sm text-gray-500">
                            Supported: Images, PDFs, Word docs, text files, ZIP (max 10MB per file)
                        </p>
                        @error('attachments.*')
                            <p class="mt-3 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-12 py-5 bg-primary hover:bg-orange-600 text-white font-bold text-xl rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-orange-300 transition duration-300">
                            Submit Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 + Success Popup -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket Submitted!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#FF7A28',
                    timer: 6000,
                    timerProgressBar: true,
                    showConfirmButton: true
                });
            @endif
        </script>
    @endpush

</x-organizer.organizer-layout>
