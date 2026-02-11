<x-organizer.organizer-layout>

<div class="py-8 px-4 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Create New Event</h1>
                <p class="text-blue-200 mt-1">Add a new event to your organizer account</p>
            </div>
            <a href="{{ route('org.events.index') }}"
               class="px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition">
                ← Back
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form id="eventForm" action="{{ route('org.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title & Slug -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Event Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary text-lg transition"
                           placeholder="Enter event title" onkeyup="updateSlug()">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('title') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl bg-gray-50 transition">
                    <small class="text-gray-500 block mt-1">Auto-generated from title (leave blank to auto-fill)</small>
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('slug') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">
                        <option value="">Choose category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('category_id') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Location & Venue -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                    <input type="text" name="location" value="{{ old('location') }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl transition"
                           placeholder="e.g. Kathmandu, Nepal">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('location') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Venue *</label>
                    <input type="text" name="venue" value="{{ old('venue') }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl transition"
                           placeholder="e.g. Dashrath Stadium">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('venue') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date & Time *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('start_date') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date & Time</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('end_date') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description *</label>
                    <textarea name="short_description" rows="5" required
                              class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">{{ old('short_description') }}</textarea>
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('short_description') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Content *</label>
                    <textarea name="content" id="editor" rows="14"
                              class="w-full border border-gray-300 rounded-xl transition">{{ old('content') }}</textarea>
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('content') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Images -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Banner Image (1920×1080) *</label>
                    <input type="file" name="banner_image" accept="image/*" required
                           class="w-full px-5 py-8 border-2 border-dashed border-gray-300 rounded-xl text-center hover:border-primary transition">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('banner_image') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Thumbnail (600×400) *</label>
                    <input type="file" name="thumbnail" accept="image/*" required
                           class="w-full px-5 py-8 border-2 border-dashed border-gray-300 rounded-xl text-center hover:border-primary transition">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('thumbnail') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Status & Featured -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="cancelled" {{ old('status', 'cancelled') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    <small class="text-gray-500 block mt-1">You can change to Completed later</small>
                    @error('status') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center mt-8">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="w-6 h-6 text-primary rounded focus:ring-primary">
                    <label class="ml-3 text-lg font-medium text-gray-700">Mark as Featured Event</label>
                </div>
            </div>

            <!-- SEO -->
            <div class="border-t pt-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">SEO Settings (Optional)</h3>
                <div class="grid grid-cols-1 gap-6">
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Meta Title"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">
                    <textarea name="meta_description" rows="3" placeholder="Meta Description"
                              class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">{{ old('meta_description') }}</textarea>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="Meta Keywords (comma separated)"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl transition">
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4 mt-12">
                <a href="{{ route('org.events.index') }}"
                   class="px-10 py-4 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 font-medium transition">
                    Cancel
                </a>
                <button type="submit" id="submitBtn"
                        class="px-12 py-4 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 shadow-xl transition transform hover:scale-105">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Dependencies -->
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Slug generator
function updateSlug() {
    const title = document.getElementById('title').value.trim();
    const slugInput = document.getElementById('slug');
    if (!slugInput.value.trim()) {
        slugInput.value = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
}

// CKEditor
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','|','outdent','indent','|','undo','redo']
    })
    .catch(err => console.error('CKEditor error:', err));

// AJAX Form
document.getElementById('eventForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const btn = document.getElementById('submitBtn');
    const original = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = 'Creating...';

    // Clear old errors
    document.querySelectorAll('.error-message').forEach(el => {
        el.textContent = ''; el.classList.add('hidden');
    });
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.classList.remove('border-red-500', 'ring-red-400/40');
    });

    try {
        const res = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            credentials: 'same-origin'
        });

        const data = await res.json();

        if (res.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'Event created!',
                timer: 2200,
                showConfirmButton: false
            }).then(() => window.location = '{{ route("org.events.index") }}');
        } else if (res.status === 422) {
            Object.entries(data.errors || {}).forEach(([name, msgs]) => {
                const input = document.querySelector(`[name="${name}"]`);
                if (!input) return;
                input.classList.add('border-red-500', 'ring-red-400/40');
                const errEl = input.nextElementSibling;
                if (errEl?.classList.contains('error-message')) {
                    errEl.textContent = msgs[0];
                    errEl.classList.remove('hidden');
                }
            });
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please correct the red fields',
                confirmButtonColor: '#FF7A28'
            });
        } else {
            throw new Error(data.message || 'Server error');
        }
    } catch (err) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err.message || 'Failed to create event',
            confirmButtonColor: '#FF7A28'
        });
    } finally {
        btn.disabled = false;
        btn.innerHTML = original;
    }
});
</script>

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '@foreach($errors->all() as $e)<div>• {{ addslashes($e) }}</div>@endforeach',
            confirmButtonColor: '#FF7A28'
        });
    </script>
@endif

</x-organizer.organizer-layout>
