<x-admin.admin-layout title="{{ isset($category) ? 'Edit' : 'Create' }} Category">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-2xl rounded-xl overflow-hidden">

            <div class="bg-[#063970] text-white px-8 py-6">
                <h1 class="text-3xl font-bold">{{ isset($category) ? 'Edit Category' : 'Create New Category' }}</h1>
            </div>

            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
                  method="POST" class="p-8 space-y-8">
                @csrf
                @if(isset($category)) @method('PUT') @endif

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#FF7A28] focus:border-[#FF7A28]">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#FF7A28]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#FF7A28]">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Icon Type</label>
                        <select name="icon_type" id="icon_type" onchange="toggleIconInput()"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#FF7A28]">
                            <option value="fontawesome" {{ old('icon_type', $category->icon_type ?? 'fontawesome') === 'fontawesome' ? 'selected' : '' }}>Font Awesome</option>
                            <option value="heroicon" {{ old('icon_type', $category->icon_type ?? '') === 'heroicon' ? 'selected' : '' }}>Heroicons</option>
                            <option value="custom" {{ old('icon_type', $category->icon_type ?? '') === 'custom' ? 'selected' : '' }}>Custom SVG</option>
                        </select>
                    </div>

                    <div id="icon_name_wrapper">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Icon Class / Name</label>
                        <input type="text" name="icon_name" value="{{ old('icon_name', $category->icon_name ?? '') }}"
                               placeholder="e.g. fa-solid fa-heart" required
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#FF7A28]">
                        <p class="text-xs text-gray-500 mt-1">For Font Awesome: <code>fa-solid fa-heart</code> | For Heroicon: <code>heart</code></p>
                    </div>
                </div>

                <div id="custom_svg_wrapper" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Custom SVG Code</label>
                    <textarea name="custom_svg" rows="6" class="font-mono text-xs w-full px-4 py-3 border rounded-lg">{{ old('custom_svg', $category->custom_svg ?? '') }}</textarea>
                </div>

                <div class="flex items-center space-x-4">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
                           class="h-6 w-6 text-[#FF7A28] rounded">
                    <label for="is_active" class="text-lg font-medium">Category is Active</label>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('admin.categories.index') }}" class="px-8 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-10 py-3 bg-[#FF7A28] hover:bg-[#e65100] text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition">
                        {{ isset($category) ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleIconInput() {
            const type = document.getElementById('icon_type').value;
            document.getElementById('icon_name_wrapper').style.display = type === 'custom' ? 'none' : 'block';
            document.getElementById('custom_svg_wrapper').style.display = type === 'custom' ? 'block' : 'none';
        }
        toggleIconInput(); // Run on load
    </script>
</x-admin.admin-layout>
