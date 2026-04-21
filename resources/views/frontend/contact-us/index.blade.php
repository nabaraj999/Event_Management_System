<x-frontend.frontend-layout />

<!-- Flash Message -->
@if(session('success'))
    <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4">
        <div class="bg-green-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 font-semibold text-sm">
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check text-white text-xs"></i>
            </div>
            {{ session('success') }}
        </div>
    </div>
@endif

<!-- ========== HERO ========== -->
<section class="relative pt-40 pb-24 overflow-hidden">
    <div class="absolute inset-0">
        @if($company->bg_image)
            <img src="{{ asset('storage/' . $company->bg_image) }}" class="w-full h-full object-cover" alt="Contact" />
        @else
            <div class="w-full h-full bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue"></div>
        @endif
        <div class="absolute inset-0 bg-darkBlue/85"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 text-center text-white">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white/80 text-xs font-bold px-5 py-2 rounded-full mb-8 uppercase tracking-wider">
            <i class="fas fa-headset text-primary text-xs"></i> Get In Touch
        </div>
        <h1 class="font-raleway text-5xl sm:text-6xl font-black mb-5 leading-tight">
            Contact <span class="text-primary">Us</span>
        </h1>
        <p class="text-lg text-white/65 max-w-2xl mx-auto">
            We'd love to hear from you. Let's plan your next unforgettable event together.
        </p>
    </div>

    <!-- Wave -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden">
        <svg viewBox="0 0 1440 60" class="w-full h-16 text-gray-50 fill-current" preserveAspectRatio="none">
            <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z"></path>
        </svg>
    </div>
</section>


<!-- ========== FORM + INFO ========== -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid md:grid-cols-2 gap-10 max-w-6xl mx-auto">

            <!-- Contact Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-paper-plane text-primary"></i>
                    </div>
                    <h2 class="font-raleway text-xl font-black text-darkBlue">Send Us a Message</h2>
                </div>

                <div class="p-8">
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">Full Name *</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Your full name"
                                           class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">Email Address *</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com"
                                           class="w-full pl-11 pr-4 py-3.5 border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">Phone Number <span class="text-gray-400 font-normal normal-case">(Optional)</span></label>
                            <div class="relative">
                                <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+977-98XXXXXXXX"
                                       class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-600 uppercase tracking-wider mb-2">Your Message *</label>
                            <textarea name="message" rows="5" required placeholder="Tell us how we can help you..."
                                      class="w-full px-4 py-3.5 border {{ $errors->has('message') ? 'border-red-400' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium resize-none">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn-primary w-full py-4 text-white font-black rounded-xl shadow-lg flex items-center justify-center gap-3 text-sm">
                            <i class="fas fa-paper-plane"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6">
                <div>
                    <p class="text-primary font-bold text-xs mb-3 uppercase tracking-widest">Reach Us</p>
                    <h2 class="font-raleway text-3xl font-black text-darkBlue mb-4">We're Here to Help</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">Our team is available to assist you with any questions about events, tickets, or partnerships.</p>
                </div>

                <!-- Address -->
                @if($company->address_full || $company->location)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-primary rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md">
                            <i class="fas fa-map-marker-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-darkBlue text-sm mb-1">Our Location</h4>
                            <p class="text-gray-600 text-sm">{{ $company->address_full ?? $company->location }}</p>
                            @if($company->map_link)
                                <a href="{{ $company->map_link }}" target="_blank" class="inline-flex items-center gap-1 text-primary font-bold text-xs mt-2 hover:underline">
                                    View on Map <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($company->phone)
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                            <div class="w-11 h-11 bg-gradient-to-br from-blue-600 to-darkBlue rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                                <i class="fas fa-phone text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-0.5">Phone</p>
                                <p class="font-bold text-darkBlue text-sm">{{ $company->phone }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="w-11 h-11 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                            <i class="fas fa-envelope text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-0.5">Email</p>
                            <p class="font-bold text-darkBlue text-sm break-all">{{ $company->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                @if($company->facebook || $company->instagram || $company->twitter || $company->linkedin || $company->youtube)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h4 class="font-black text-darkBlue text-sm mb-4">Follow Us on Social Media</h4>
                        <div class="flex flex-wrap gap-3">
                            @if($company->facebook)
                                <a href="{{ $company->facebook }}" target="_blank" class="w-10 h-10 bg-blue-100 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <i class="fab fa-facebook-f text-sm"></i>
                                </a>
                            @endif
                            @if($company->instagram)
                                <a href="{{ $company->instagram }}" target="_blank" class="w-10 h-10 bg-pink-100 hover:bg-pink-600 text-pink-600 hover:text-white rounded-xl flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <i class="fab fa-instagram text-sm"></i>
                                </a>
                            @endif
                            @if($company->twitter)
                                <a href="{{ $company->twitter }}" target="_blank" class="w-10 h-10 bg-sky-100 hover:bg-sky-500 text-sky-500 hover:text-white rounded-xl flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <i class="fab fa-twitter text-sm"></i>
                                </a>
                            @endif
                            @if($company->linkedin)
                                <a href="{{ $company->linkedin }}" target="_blank" class="w-10 h-10 bg-blue-100 hover:bg-blue-700 text-blue-700 hover:text-white rounded-xl flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <i class="fab fa-linkedin-in text-sm"></i>
                                </a>
                            @endif
                            @if($company->youtube)
                                <a href="{{ $company->youtube }}" target="_blank" class="w-10 h-10 bg-red-100 hover:bg-red-600 text-red-600 hover:text-white rounded-xl flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <i class="fab fa-youtube text-sm"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Quick CTA -->
                <div class="bg-gradient-to-br from-darkBlue to-[#0a4f9e] rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/15 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative">
                        <h4 class="font-raleway font-black text-lg mb-2">Want to Organize an Event?</h4>
                        <p class="text-white/65 text-sm mb-4">Join hundreds of organizers on EventHUB and reach thousands of attendees.</p>
                        <a href="{{ route('organizer.apply.form') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-orange-400 transition-colors text-sm shadow-md">
                            <i class="fas fa-rocket"></i> Apply Now
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========== MAP ========== -->
@if($company->map_link)
    <section class="pb-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="rounded-3xl overflow-hidden shadow-xl border border-gray-100 h-80 sm:h-96">
                <iframe src="{{ $company->map_link }}" width="100%" height="100%"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
@endif


<x-frontend.footer-card />
