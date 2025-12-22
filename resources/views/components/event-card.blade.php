{{-- resources/views/components/event-card.blade.php --}}

@props(['event'])

<a href="{{ route('events.show', $event) }}" class="block group">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
        <!-- Image -->
        <div class="relative">
            <img src="{{ $event->banner_image ? asset('storage/' . $event->banner_image) : 'https://via.placeholder.com/600x400' }}"
                 alt="{{ $event->title }}"
                 class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">

            <!-- Featured Badge -->
            @if($event->is_featured)
                <div class="absolute top-4 left-4">
                    <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                        Featured
                    </span>
                </div>
            @endif

            <!-- Category Badge (optional) -->
            @if($event->category)
                <div class="absolute bottom-4 left-4">
                    <span class="bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-lg">
                        {{ $event->category->name }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-6">
            <h3 class="text-xl font-bold text-darkBlue line-clamp-2 mb-3 group-hover:text-primary transition">
                {{ $event->title }}
            </h3>

            <!-- Date & Location -->
            <div class="text-sm text-gray-600 space-y-2 mb-4">
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ $event->start_date->format('M d, Y') }}</span>
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    <span class="line-clamp-1">{{ $event->location }}</span>
                </p>
            </div>

            <!-- Price -->
            <div class="flex items-center justify-between">
                <div>
                    @if($event->min_price ?? 0 == 0)
                        <span class="text-2xl font-extrabold text-green-600">Free</span>
                    @else
                        <span class="text-2xl font-extrabold text-primary">
                            Rs. {{ number_format($event->min_price ?? 0) }}+
                        </span>
                    @endif
                </div>
                <span class="text-gray-400 group-hover:text-primary transition">→</span>
            </div>
        </div>
    </div>
</a>
