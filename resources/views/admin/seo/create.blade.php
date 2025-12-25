<x-admin.admin-layout>
    <div class="py-8 px-4 max-w-7xl mx-auto">
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold">Create New SEO Page</h1>
                    <p class="text-blue-200 mt-1">Add SEO settings for a new route</p>
                </div>
                <a href="{{ route('admin.seo.index') }}"
                    class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium transition shadow">
                    ← Back
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                    <h3 class="text-lg font-semibold text-red-800">Please fix the errors:</h3>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.seo.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">Page Key (Route Name) <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="page_key" value="{{ old('page_key') }}" required
                        placeholder="e.g., home, about, contact"
                        class="w-full px-6 py-4 rounded-xl border {{ $errors->has('page_key') ? 'border-red-500' : 'border-gray-300' }} focus:ring-2 focus:ring-primary">
                    @error('page_key')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">Meta Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" required
                        class="w-full px-6 py-4 rounded-xl border {{ $errors->has('meta_title') ? 'border-red-500' : 'border-gray-300' }} focus:ring-2 focus:ring-primary">
                    @error('meta_title')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>



                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">Meta Keywords</label>
                    <textarea name="meta_keywords" rows="3"
                        class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary"
                        placeholder="e.g., laravel, seo, web development, php">{{ old('meta_keywords') }}</textarea>
                    <p class="text-sm text-gray-500 mt-2">Comma-separated keywords (optional, less important for Google
                        now)</p>
                    @error('meta_keywords')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">Meta Description</label>
                    <textarea name="meta_description" rows="4"
                        class="w-full px-6 py-4 rounded-xl border {{ $errors->has('meta_description') ? 'border-red-500' : 'border-gray-300' }} focus:ring-2 focus:ring-primary">{{ old('meta_description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Open Graph Title</label>
                        <input type="text" name="og_title" value="{{ old('og_title') }}"
                            class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Open Graph Description</label>
                        <textarea name="og_description" rows="4"
                            class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary">{{ old('og_description') }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">Open Graph Image (1200x630
                        recommended)</label>
                    <input type="file" name="og_image" accept="image/*"
                        class="block w-full text-lg file:mr-6 file:py-4 file:px-8 file:rounded-xl file:bg-primary file:text-white">
                    @error('og_image')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Canonical URL</label>
                        <input type="url" name="canonical_url" value="{{ old('canonical_url') }}"
                            class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Robots Directive</label>
                        <select name="robots"
                            class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary text-lg">
                            <option value="index,follow" {{ old('robots') == 'index,follow' ? 'selected' : '' }}>index,
                                follow (Default)</option>
                            <option value="noindex,follow" {{ old('robots') == 'noindex,follow' ? 'selected' : '' }}>
                                noindex, follow</option>
                            <option value="index,nofollow" {{ old('robots') == 'index,nofollow' ? 'selected' : '' }}>
                                index, nofollow</option>
                            <option value="noindex,nofollow"
                                {{ old('robots') == 'noindex,nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active', true) ? 'checked' : '' }} class="w-6 h-6 text-primary rounded">
                    <label for="is_active" class="text-lg font-medium text-gray-700">Active</label>
                </div>

                <div class="flex justify-end gap-4 pt-8 border-t">
                    <a href="{{ route('admin.seo.index') }}"
                        class="px-8 py-4 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium transition shadow">Cancel</a>
                    <button type="submit"
                        class="px-10 py-4 bg-primary hover:bg-orange-600 text-white rounded-xl font-bold text-lg shadow-lg">
                        Create SEO Page
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin.admin-layout>
