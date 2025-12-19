<x-admin.admin-layout>

<div class="py-8 px-4 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Create New Event</h1>
                <p class="text-blue-200 mt-1">Add a new event to the system</p>
            </div>
            <a href="{{ route('admin.events.index') }}"
               class="px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition">
                ← Back
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title & Slug -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Event Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary text-lg"
                           placeholder="Enter event title" onkeyup="updateSlug()">
                    @error('title') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl bg-gray-50">
                    <small class="text-gray-500">Auto-generated from title</small>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                        <option value="">Choose category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Location & Venue -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Location *</label>
                    <input type="text" name="location" value="{{ old('location') }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl"
                           placeholder="e.g. Dhaka, Bangladesh">
                    @error('location') <p class="text-red-600 text-sm mt-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Venue</label>
                    <input type="text" name="venue" value="{{ old('venue') }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl"
                           placeholder="e.g. ICCB Hall 4">
                </div>
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date & Time *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                    @error('start_date') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date & Time</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description</label>
                    <textarea name="short_description" rows="4"
                              class="w-full px-5 py-4 border border border-gray-300 rounded-xl">{{ old('short_description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Content</label>
                    <textarea name="content" rows="10"
                              class="w-full px-5 py-4 border border-gray-300 rounded-xl">{{ old('content') }}</textarea>
                </div>
            </div>

            <!-- Images -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Banner Image (1920×1080) *</label>
                    <input type="file" name="banner_image" accept="image/*" required
                           class="w-full px-5 py-8 border-2 border-dashed border-gray-300 rounded-xl text-center hover:border-primary transition">
                    @error('banner_image') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Thumbnail (600×400) *</label>
                    <input type="file" name="thumbnail" accept="image/*" required
                           class="w-full px-5 py-8 border-2 border-dashed border-gray-300 rounded-xl text-center hover:border-primary transition">
                    @error('thumbnail') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Status & Featured -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published">Published</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed">Completed</option>
                    </select>
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
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                    <textarea name="meta_description" rows="3" placeholder="Meta Description"
                              class="w-full px-5 py-4 border border-gray-300 rounded-xl">{{ old('meta_description') }}</textarea>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="Meta Keywords (comma separated)"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4 mt-12">
                <a href="{{ route('admin.events.index') }}"
                   class="px-10 py-4 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 font-medium transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-12 py-4 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 shadow-xl transition transform hover:scale-105">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Live Slug + SweetAlert -->
<script>
function updateSlug() {
    const title = document.getElementById('title').value;
    const slugField = document.getElementById('slug');
    if (!slugField.value) {
        slugField.value = title
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }
}

@if(session('swal_success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('swal_success') }}',
        confirmButtonColor: '#FF7A28',
        timer: 3000
    });
@endif

@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: '@foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach',
        confirmButtonColor: '#FF7A28'
    });
@endif
</script>

</x-admin.admin-layout>
