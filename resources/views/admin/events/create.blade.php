<x-admin.admin-layout>

<div class="py-10 px-4 max-w-5xl mx-auto">

    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Create New Event</h1>
                <p class="text-blue-200 mt-1">Add a new event professionally</p>
            </div>
            <a href="{{ route('admin.events.index') }}"
               class="px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition">
                ← Back
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-10">
        <form id="eventForm" action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ================= TITLE ================= --}}
            <div class="mb-8">
                <label class="block font-semibold mb-2">
                    Event Title <span class="text-red-600">*</span>
                </label>
                <input type="text" name="title" id="title"
                       value="{{ old('title') }}"
                       onkeyup="updateSlug()"
                       class="w-full px-5 py-4 border rounded-xl focus:ring-2 focus:ring-primary transition
                       @error('title') border-red-500 @enderror"
                       placeholder="Enter event title" required>
                <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                @error('title')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= SLUG ================= --}}
            <div class="mb-8">
                <label class="block font-semibold mb-2">Slug (Auto Generated)</label>
                <input type="text" name="slug" id="slug"
                       value="{{ old('slug') }}"
                       class="w-full px-5 py-4 border rounded-xl bg-gray-100 transition
                       @error('slug') border-red-500 @enderror">
                <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                @error('slug')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= CATEGORY ================= --}}
            <div class="mb-8">
                <label class="block font-semibold mb-2">
                    Category <span class="text-red-600">*</span>
                </label>
                <select name="category_id" required
                        class="w-full px-5 py-4 border rounded-xl transition
                        @error('category_id') border-red-500 @enderror">
                    <option value="">Choose Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                @error('category_id')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= LOCATION & VENUE ================= --}}
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block font-semibold mb-2">
                        Location <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="location"
                           value="{{ old('location') }}"
                           class="w-full px-5 py-4 border rounded-xl transition
                           @error('location') border-red-500 @enderror"
                           placeholder="Required if venue empty">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('location')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Venue <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="venue"
                           value="{{ old('venue') }}"
                           class="w-full px-5 py-4 border rounded-xl transition
                           @error('venue') border-red-500 @enderror"
                           placeholder="Required if location empty">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('venue')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ================= DATE TIME ================= --}}
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block font-semibold mb-2">
                        Start Date & Time <span class="text-red-600">*</span>
                    </label>
                    <input type="datetime-local" name="start_date"
                           value="{{ old('start_date') }}"
                           class="w-full px-5 py-4 border rounded-xl transition
                           @error('start_date') border-red-500 @enderror"
                           required>
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('start_date')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">End Date & Time</label>
                    <input type="datetime-local" name="end_date"
                           value="{{ old('end_date') }}"
                           class="w-full px-5 py-4 border rounded-xl transition
                           @error('end_date') border-red-500 @enderror">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('end_date')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ================= SHORT DESCRIPTION ================= --}}
            <div class="mb-8">
                <label class="block font-semibold mb-2">
                    Short Description <span class="text-red-600">*</span>
                </label>
                <textarea name="short_description" rows="4" required
                          class="w-full px-5 py-4 border rounded-xl transition
                          @error('short_description') border-red-500 @enderror">{{ old('short_description') }}</textarea>
                <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                @error('short_description')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= FULL CONTENT ================= --}}
           {{-- ================= FULL CONTENT ================= --}}
            <div class="mb-8">
                <label class="block font-semibold mb-2">
                    Full Description <span class="text-red-600">*</span>
                </label>

                <textarea name="content" id="editor"
                          class="w-full px-5 py-4 border rounded-xl
                          @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>

                @error('content')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- ================= IMAGES ================= --}}
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block font-semibold mb-2">
                        Banner Image <span class="text-red-600">*</span>
                    </label>
                    <input type="file" name="banner_image" accept="image/*" required
                           class="w-full px-5 py-8 border-2 border-dashed border-gray-300 rounded-xl text-center hover:border-primary transition">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('banner_image')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Thumbnail Image <span class="text-red-600">*</span>
                    </label>
                    <input type="file" name="thumbnail" accept="image/*" required
                           class="w-full px-5 py-8 border-2 border-dashed border-gray-300 rounded-xl text-center hover:border-primary transition">
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('thumbnail')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ================= STATUS & FEATURED ================= --}}
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block font-semibold mb-2">
                        Status <span class="text-red-600">*</span>
                    </label>
                    <select name="status" required
                            class="w-full px-5 py-4 border rounded-xl transition
                            @error('status') border-red-500 @enderror">
                        <option value="draft"     {{ old('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="ongoing"   {{ old('status') == 'ongoing'   ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <p class="error-message text-red-600 text-sm mt-1.5 hidden"></p>
                    @error('status')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center mt-10">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                           class="w-5 h-5 text-primary rounded focus:ring-primary"
                           {{ old('is_featured') ? 'checked' : '' }}>
                    <label for="is_featured" class="ml-3 text-lg font-medium text-gray-700">
                        Mark as Featured Event
                    </label>
                </div>
            </div>

            {{-- ================= SEO (optional) ================= --}}
            <div class="border-t pt-8 mb-8">
                <h3 class="text-xl font-bold mb-6">SEO Settings (Optional)</h3>
                <div class="space-y-6">
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                           placeholder="Meta Title" class="w-full px-5 py-4 border rounded-xl transition">

                    <textarea name="meta_description" rows="3" placeholder="Meta Description (150-160 chars)"
                              class="w-full px-5 py-4 border rounded-xl transition">{{ old('meta_description') }}</textarea>

                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}"
                           placeholder="Meta Keywords (comma separated)"
                           class="w-full px-5 py-4 border rounded-xl transition">
                </div>
            </div>

            {{-- ================= SUBMIT ================= --}}
            <div class="flex justify-end">
                <button type="submit" id="submitBtn"
                        class="px-12 py-4 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 shadow-lg transition transform hover:scale-105">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/classic/ckeditor.js"></script>

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

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => console.error('CKEditor failed:', error));

// AJAX Form Handling
document.getElementById('eventForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const btn = document.getElementById('submitBtn');
    const originalText = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = 'Creating...';

    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => {
        el.textContent = '';
        el.classList.add('hidden');
    });
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.classList.remove('border-red-500', 'ring-red-400/40');
    });

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'Event created successfully!',
                timer: 2500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '{{ route("admin.events.index") }}';
            });
        } else if (response.status === 422) {
            // Show field errors
            Object.entries(data.errors || {}).forEach(([field, messages]) => {
                const input = document.querySelector(`[name="${field}"]`);
                if (!input) return;

                input.classList.add('border-red-500', 'ring-red-400/40');

                const errorEl = input.nextElementSibling;
                if (errorEl && errorEl.classList.contains('error-message')) {
                    errorEl.textContent = messages[0];
                    errorEl.classList.remove('hidden');
                }
            });

            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please check the highlighted fields',
                confirmButtonColor: '#FF7A28'
            });
        } else {
            throw new Error(data.message || 'Server error');
        }
    } catch (error) {
        console.error('Form error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Something went wrong. Please try again.',
            confirmButtonColor: '#FF7A28'
        });
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }

});
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'));

function updateSlug() {
    const title = document.getElementById('title').value;
    const slug = document.getElementById('slug');
    if (!slug.value) {
        slug.value = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
}
</script>
</x-admin.admin-layout>
