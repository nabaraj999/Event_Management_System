<x-admin.admin-layout>
    <div class="py-8 px-4 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-darkBlue text-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold">Edit SEO Page</h1>
                    <p class="text-blue-200 mt-1">
                        Managing SEO settings for:
                        <span class="font-semibold text-primary">
                            {{ ucfirst(str_replace(['.', '_'], ' ', $seoPage->page_key)) }}
                        </span>
                        <code class="ml-2 bg-white/20 px-3 py-1 rounded text-sm">{{ $seoPage->page_key }}</code>
                    </p>
                </div>
                <a href="{{ route('admin.seo.index') }}"
                   class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium transition shadow">
                    ← Back to List
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                    <h3 class="text-lg font-semibold text-red-800">Please fix the following errors:</h3>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.seo.update', $seoPage) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Meta Title -->
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">
                            Meta Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="meta_title"
                               value="{{ old('meta_title', $seoPage->meta_title) }}"
                               required
                               class="w-full px-6 py-4 rounded-xl border {{ $errors->has('meta_title') ? 'border-red-500' : 'border-gray-300' }} focus:ring-2 focus:ring-primary">
                        @error('meta_title')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Robots Directive -->
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Robots Directive</label>
                        <select name="robots"
                                class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary text-lg">
                            <option value="index,follow" {{ $seoPage->robots === 'index,follow' ? 'selected' : '' }}>
                                index, follow (Default)
                            </option>
                            <option value="noindex,follow" {{ $seoPage->robots === 'noindex,follow' ? 'selected' : '' }}>
                                noindex, follow
                            </option>
                            <option value="index,nofollow" {{ $seoPage->robots === 'index,nofollow' ? 'selected' : '' }}>
                                index, nofollow
                            </option>
                            <option value="noindex,nofollow" {{ $seoPage->robots === 'noindex,nofollow' ? 'selected' : '' }}>
                                noindex, nofollow
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Meta Description -->
                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">Meta Description</label>
                    <textarea name="meta_description"
                              rows="4"
                              class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary">{{ old('meta_description', $seoPage->meta_description) }}</textarea>
                </div>

                <!-- Open Graph Title & Description -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Open Graph Title</label>
                        <input type="text"
                               name="og_title"
                               value="{{ old('og_title', $seoPage->og_title) }}"
                               class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-lg font-semibold text-gray-800 mb-3">Open Graph Description</label>
                        <textarea name="og_description"
                                  rows="4"
                                  class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary">{{ old('og_description', $seoPage->og_description) }}</textarea>
                    </div>
                </div>
<!-- Meta Keywords -->
<div>
    <label class="block text-lg font-semibold text-gray-800 mb-3">
        Meta Keywords
        <span class="text-sm font-normal text-gray-500">(Optional – ignored by Google, but useful for internal reference)</span>
    </label>
    <textarea name="meta_keywords"
              rows="3"
              class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary"
              placeholder="e.g., laravel, seo, web development, php">{{ old('meta_keywords', $seoPage->meta_keywords) }}</textarea>
    <p class="text-sm text-gray-500 mt-2">
        Comma-separated keywords. No longer used by search engines for ranking.
    </p>
    @error('meta_keywords')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>
                <!-- Open Graph Image -->
                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        Open Graph Image <span class="text-sm font-normal text-gray-500">(1200×630 recommended)</span>
                    </label>
                    <input type="file"
                           name="og_image"
                           accept="image/*"
                           class="block w-full text-lg file:mr-6 file:py-4 file:px-8 file:rounded-xl file:bg-primary file:text-white hover:file:bg-orange-600">

                    @if($seoPage->og_image)
                        <div class="mt-6">
                            <p class="text-sm font-medium text-gray-700 mb-3">Current Image:</p>
                            <img src="{{ Storage::url($seoPage->og_image) }}"
                                 alt="Current OG Image"
                                 class="h-64 rounded-xl shadow-lg border border-gray-200">
                            <p class="text-xs text-gray-500 mt-2">Upload a new image to replace this one.</p>
                        </div>
                    @endif

                    @error('og_image')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Canonical URL -->
                <div>
                    <label class="block text-lg font-semibold text-gray-800 mb-3">Canonical URL</label>
                    <input type="url"
                           name="canonical_url"
                           value="{{ old('canonical_url', $seoPage->canonical_url) }}"
                           placeholder="https://yoursite.com/{{ $seoPage->page_key }}"
                           class="w-full px-6 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary">
                </div>

                <!-- Active Toggle -->
                <div class="flex items-center gap-4">
                    <input type="checkbox"
                           name="is_active"
                           id="is_active"
                           value="1"
                           {{ old('is_active', $seoPage->is_active) ? 'checked' : '' }}
                           class="w-6 h-6 text-primary rounded focus:ring-primary">
                    <label for="is_active" class="text-lg font-medium text-gray-700">SEO Active for this page</label>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-4 pt-8 border-t border-gray-200">
                    <a href="{{ route('admin.seo.index') }}"
                       class="px-8 py-4 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium transition shadow">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-10 py-4 bg-primary hover:bg-orange-600 text-white rounded-xl font-bold text-lg shadow-lg transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin.admin-layout>
