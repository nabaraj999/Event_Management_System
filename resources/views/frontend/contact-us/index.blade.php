<x-frontend.frontend-layout />

    <!-- Success Message -->
    @if(session('success'))
        <div class="container mx-auto px-4 mb-8">
            <div class="max-w-4xl mx-auto p-6 bg-green-100 border border-green-400 text-green-800 rounded-2xl text-center text-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="py-20 md:py-32 bg-cover bg-center relative" style="background-image: url('{{ asset('storage/' . $company->bg_image) ?? 'https://images.pexels.com/photos/3184338/pexels-photo-3184338.jpeg' }}');">
        <div class="absolute inset-0 bg-darkBlue/80"></div>
        <div class="container mx-auto px-4 relative z-10 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold font-raleway mb-6">Contact Us</h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto">We'd love to hear from you. Let's plan your next unforgettable event together.</p>
        </div>
    </section>

    <!-- Contact Form + Info -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">

                <!-- Form -->
                <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                    <h2 class="text-3xl font-bold text-darkBlue font-raleway mb-8">Send Us a Message</h2>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-darkBlue font-medium mb-2">Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-darkBlue font-medium mb-2">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-darkBlue font-medium mb-2">Phone (Optional)</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        </div>

                        <div>
                            <label class="block text-darkBlue font-medium mb-2">Message *</label>
                            <textarea name="message" rows="6" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-primary text-white font-bold py-4 rounded-full hover:bg-primary/90 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Company Details -->
                <div class="space-y-8">
                    <h2 class="text-3xl font-bold text-darkBlue font-raleway mb-8">Get in Touch</h2>

                    @if($company->address_full || $company->location)
                        <div class="bg-white rounded-2xl p-6 shadow-md">
                            <h4 class="text-xl font-semibold text-darkBlue mb-3 flex items-center">
                                <svg class="w-6 h-6 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Our Address
                            </h4>
                            <p class="text-gray-700">{{ $company->address_full ?? $company->location }}</p>
                            @if($company->map_link)
                                <a href="{{ $company->map_link }}" target="_blank" class="text-primary font-medium hover:underline mt-3 inline-block">View on Map →</a>
                            @endif
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @if($company->phone)
                            <div class="bg-white rounded-2xl p-6 shadow-md text-center">
                                <svg class="w-12 h-12 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <p class="font-semibold text-darkBlue">Phone</p>
                                <p class="text-gray-700">{{ $company->phone }}</p>
                            </div>
                        @endif

                        <div class="bg-white rounded-2xl p-6 shadow-md text-center">
                            <svg class="w-12 h-12 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="font-semibold text-darkBlue">Email</p>
                            <p class="text-gray-700 break-all">{{ $company->email }}</p>
                        </div>
                    </div>

                    <!-- Social Links -->
                    @if($company->facebook || $company->instagram || $company->twitter || $company->linkedin || $company->youtube)
                        <div class="bg-white rounded-2xl p-6 shadow-md">
                            <h4 class="text-xl font-semibold text-darkBlue mb-4">Follow Us</h4>
                            <div class="flex space-x-6 justify-center">
                                @if($company->facebook)<a href="{{ $company->facebook }}" target="_blank" class="text-3xl text-gray-600 hover:text-primary transition"><i class="fab fa-facebook-f"></i></a>@endif
                                @if($company->instagram)<a href="{{ $company->instagram }}" target="_blank" class="text-3xl text-gray-600 hover:text-primary transition"><i class="fab fa-instagram"></i></a>@endif
                                @if($company->twitter)<a href="{{ $company->twitter }}" target="_blank" class="text-3xl text-gray-600 hover:text-primary transition"><i class="fab fa-twitter"></i></a>@endif
                                @if($company->linkedin)<a href="{{ $company->linkedin }}" target="_blank" class="text-3xl text-gray-600 hover:text-primary transition"><i class="fab fa-linkedin-in"></i></a>@endif
                                @if($company->youtube)<a href="{{ $company->youtube }}" target="_blank" class="text-3xl text-gray-600 hover:text-primary transition"><i class="fab fa-youtube"></i></a>@endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    @if($company->map_link)
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="rounded-3xl overflow-hidden shadow-2xl h-96">
                    <iframe src="{{ $company->map_link }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    @endif


<x-frontend.footer-card />
