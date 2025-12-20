<x-organizer.organizer-layout title="Create Event Ticket">

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <h2 class="text-3xl font-bold text-darkBlue mb-8">Create New Ticket</h2>

        <div class="bg-white shadow-lg rounded-xl p-8">
            <form action="{{ route('org.event-tickets.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <div class="mb-6">
                            <label for="event_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Event <span class="text-red-500">*</span>
                            </label>
                            <select name="event_id" id="event_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('event_id') border-red-500 @enderror"
                                    required>
                                <option value="">-- Select Event --</option>
                                @foreach($events as $id => $title)
                                    <option value="{{ $id }}" {{ old('event_id') == $id ? 'selected' : '' }}>
                                        {{ $title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Ticket Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror"
                                   placeholder="e.g., VIP, Early Bird, General"
                                   required>
                            @error('name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                Price (Rs.) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   id="price"
                                   value="{{ old('price') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('price') border-red-500 @enderror"
                                   required>
                            @error('price')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="total_seats" class="block text-sm font-semibold text-gray-700 mb-2">
                                Total Seats <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   name="total_seats"
                                   id="total_seats"
                                   value="{{ old('total_seats') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('total_seats') border-red-500 @enderror"
                                   min="1"
                                   required>
                            @error('total_seats')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description (Optional)
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                      placeholder="e.g., Includes VIP access, food, and merchandise">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label for="sale_start" class="block text-sm font-semibold text-gray-700 mb-2">
                                Sale Start Date & Time
                            </label>
                            <input type="datetime-local"
                                   name="sale_start"
                                   id="sale_start"
                                   value="{{ old('sale_start') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <div class="mb-6">
                            <label for="sale_end" class="block text-sm font-semibold text-gray-700 mb-2">
                                Sale End Date & Time
                            </label>
                            <input type="datetime-local"
                                   name="sale_end"
                                   id="sale_end"
                                   value="{{ old('sale_end') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('sale_end')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6 flex items-center">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   id="is_active"
                                   class="h-5 w-5 text-primary rounded focus:ring-primary"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-3 text-sm font-semibold text-gray-700">
                                Ticket is Active
                            </label>
                        </div>

                        <div class="mb-6">
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">
                                Sort Order <small class="font-normal text-gray-500">(Lower = appears first)</small>
                            </label>
                            <input type="number"
                                   name="sort_order"
                                   id="sort_order"
                                   value="{{ old('sort_order', 0) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('org.event-tickets.index') }}"
                       class="px-8 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition text-center">
                        Back to List
                    </a>
                    <button type="submit"
                            class="px-8 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-darkBlue transition">
                        Create Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-organizer.organizer-layout>
