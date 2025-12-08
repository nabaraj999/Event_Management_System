<!-- resources/views/admin/events/edit.blade.php -->

<x-admin.admin-layout>

<div class="py-8 px-4 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Edit Event</h1>
                <p class="text-blue-200 mt-1">Update event information</p>
            </div>
            <a href="{{ route('admin.events.index') }}"
               class="px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition font-medium">
                ← Back to Events
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title & Slug -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Event Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary text-lg"
                           onkeyup="updateSlug()">
                    @error('title') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $event->slug) }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl bg-gray-50">
                    <small class="text-gray-500">Leave empty to auto-update from title</small>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>
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
                    <input type="text" name="location" value="{{ old('location', $event->location) }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                    @error('location') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Venue</label>
                    <input type="text" name="venue" value="{{ old('venue', $event->venue) }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                </div>
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date & Time *</label>
                    <input type="datetime-local" name="start_date"
                           value="{{ old('start_date', $event->start_date?->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                    @error('start_date') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date & Time</label>
                    <input type="datetime-local" name="end_date"
                           value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description</label>
                    <textarea name="short_description" rows="4"
                              class="w-full px-5 py-4 border border-gray-300 rounded-xl">{{ old('short_description', $event->short_description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Content</label>
                    <textarea name="content" rows="10"
                              class="w-full px-5 py-4 border border-gray-300 rounded-xl">{{ old('content', $event->content) }}</textarea>
                </div>
            </div>

            <!-- Current Images + Replace Option -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Current Banner Image</label>
                    @if($event->banner_image)
                        <img src="{{ asset('storage/'.$event->banner_image) }}"
                             class="w-full h-64 object-cover rounded-xl shadow-lg mb-4">
                        <p class="text-sm text-gray-500">Leave blank to keep current</p>
                    @else
                        <p class="text-gray-400">No banner image</p>
                    @endif
                    <input type="file" name="banner_image" accept="image/*"
                           class="w-full mt-2 px-5 py-4 border border-dashed border-gray-400 rounded-xl">
                    @error('banner_image') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Current Thumbnail</label>
                    @if($event->thumbnail)
                        <img src="{{ asset('storage/'.$event->thumbnail) }}"
                             class="w-full h-64 object-cover rounded-xl shadow-lg mb-4">
                        <p class="text-sm text-gray-500">Leave blank to keep current</p>
                    @else
                        <p class="text-gray-400">No thumbnail</p>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                           class="w-full mt-2 px-5 py-4 border border-dashed border-gray-400 rounded-xl">
                    @error('thumbnail') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Status & Featured -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-5 py-4 border border-gray-300 rounded-xl">
                        <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="flex items-center mt-8">
                    <input type="checkbox" name="is_featured" value="1"
                           {{ old('is_featured', $event->is_featured) ? 'checked' : '' }}
                           class="w-6 h-6 text-primary rounded focus:ring-primary">
                    <label class="ml-3 text-lg font-medium text-gray-700">Mark as Featured Event</label>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="border-t pt-8 mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">SEO Settings (Optional)</h3>
                <div class="grid grid-cols-1 gap-6">
                    <input type="text" name="meta_title" value="{{ old('meta_title', $event->meta_title) }}"
                           placeholder="Meta Title (60-70 chars)" class="w-full px-5 py-4 border rounded-xl">
                    <textarea name="meta_description" rows="3"
                           placeholder="Meta Description (150-160 chars)"
                           class="w-full px-5 py-4 border rounded-xl">{{ old('meta_description', $event->meta_description) }}</textarea>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $event->meta_keywords) }}"
                           placeholder="Keywords (comma separated)" class="w-full px-5 py-4 border rounded-xl">
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-4 mt-12">
                <a href="{{ route('admin.events.index') }}"
                   class="px-10 py-4 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 font-medium transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-12 py-4 bg-primary text-white font-bold rounded-xl hover:bg-orange-600 shadow-xl transition transform hover:scale-105">
                    Update Event
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
        title: 'Updated!',
        text: '{{ session('swal_success') }}',
        confirmButtonColor: '#FF7A28',
        timer: 3000
    });
@endif
</script>

</x-admin.admin-layout>
