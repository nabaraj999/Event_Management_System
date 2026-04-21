<x-frontend.frontend-layout />

<!-- ========== HERO ========== -->
<section class="relative pt-40 pb-28 overflow-hidden bg-gradient-to-br from-darkBlue via-[#0a4f9e] to-darkBlue">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-300/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 text-center text-white">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white/80 text-xs font-bold px-5 py-2 rounded-full mb-8 uppercase tracking-wider">
            <i class="fas fa-info-circle text-primary text-xs"></i> Our Story
        </div>
        <h1 class="font-raleway text-5xl sm:text-6xl font-black mb-6 leading-tight">
            About <span class="text-primary">EventHUB</span>
        </h1>
        <p class="text-lg sm:text-xl text-white/70 leading-relaxed max-w-3xl mx-auto">
            {{ $company->about_us_description }}
        </p>
    </div>

    <!-- Wave -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden">
        <svg viewBox="0 0 1440 80" class="w-full h-20 text-gray-50 fill-current" preserveAspectRatio="none">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"></path>
        </svg>
    </div>
</section>


<!-- ========== OUR STORY ========== -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid md:grid-cols-2 gap-14 items-center">

            <!-- Image -->
            <div class="relative order-2 md:order-1">
                <div class="absolute -top-5 -left-5 w-20 h-20 bg-primary/10 rounded-3xl"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="{{ Storage::url($company->about_us_image) }}"
                         alt="Our Team"
                         class="w-full h-[420px] object-cover hover:scale-105 transition-transform duration-700">
                </div>
                <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-darkBlue/10 rounded-full"></div>
            </div>

            <!-- Text -->
            <div class="order-1 md:order-2">
                <div class="inline-flex items-center gap-2 bg-orange-50 text-primary text-xs font-bold px-4 py-2 rounded-full mb-6 uppercase tracking-wider">
                    <i class="fas fa-book-open text-xs"></i> Our Story
                </div>
                <h2 class="font-raleway text-4xl sm:text-5xl font-black text-darkBlue mb-6 leading-tight">
                    Built for<br><span class="text-primary">Event Lovers</span>
                </h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>Founded with a passion for bringing people together, we specialize in crafting personalized and memorable events that exceed every expectation.</p>
                    <p>From intimate celebrations to grand corporate gatherings, our dedicated team brings creativity, precision, and heartfelt care to every detail.</p>
                    <p>With years of experience and a commitment to excellence, we turn your vision into reality — one extraordinary event at a time.</p>
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('events.index') }}" class="btn-primary inline-flex items-center gap-2 px-7 py-3.5 text-white font-bold rounded-xl shadow-md text-sm">
                        <i class="fas fa-calendar-alt"></i> Browse Events
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-7 py-3.5 border-2 border-darkBlue text-darkBlue font-bold rounded-xl hover:bg-darkBlue hover:text-white transition-all text-sm">
                        <i class="fas fa-envelope"></i> Get in Touch
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ========== MISSION & VISION ========== -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14">
            <p class="text-primary font-bold text-xs mb-3 uppercase tracking-widest">Our Purpose</p>
            <h2 class="font-raleway text-4xl font-black text-darkBlue">Mission &amp; Vision</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Mission -->
            <div class="group bg-gradient-to-br from-orange-50 to-orange-100/50 rounded-3xl p-10 border-2 border-orange-100 hover:border-primary transition-colors duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-primary rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-bullseye text-white text-2xl"></i>
                </div>
                <h3 class="font-raleway text-2xl font-black text-darkBlue mb-4">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed">
                    To deliver seamless, innovative, and emotionally resonant events that create lasting memories for our clients and their guests — every single time.
                </p>
            </div>

            <!-- Vision -->
            <div class="group bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-3xl p-10 border-2 border-blue-100 hover:border-darkBlue transition-colors duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-darkBlue rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-eye text-white text-2xl"></i>
                </div>
                <h3 class="font-raleway text-2xl font-black text-darkBlue mb-4">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed">
                    To be the most trusted and creative event partner in Nepal, known for transforming ordinary moments into extraordinary, unforgettable experiences.
                </p>
            </div>
        </div>
    </div>
</section>


<!-- ========== STATS ========== -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14">
            <p class="text-primary font-bold text-xs mb-3 uppercase tracking-widest">By the Numbers</p>
            <h2 class="font-raleway text-4xl font-black text-darkBlue">Why Choose Us</h2>
            <p class="text-gray-500 max-w-xl mx-auto mt-4 text-lg">We bring expertise, creativity, and dedication to every event</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-4xl mx-auto">

            <!-- Years of Experience -->
            <div class="card-hover bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-primary rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg">
                    <i class="fas fa-trophy text-white text-2xl"></i>
                </div>
                <div class="font-raleway text-4xl font-black text-darkBlue mb-1">{{ $company->company_start }}+</div>
                <div class="text-sm font-black text-gray-800 mb-2">Years of Experience</div>
                <p class="text-xs text-gray-400 leading-relaxed">Planning and executing events with proven excellence</p>
            </div>

            <!-- Events Delivered -->
            <div class="card-hover bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-darkBlue rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
                <div class="font-raleway text-4xl font-black text-darkBlue mb-1">{{ $company->total_events }}</div>
                <div class="text-sm font-black text-gray-800 mb-2">Events Delivered</div>
                <p class="text-xs text-gray-400 leading-relaxed">From weddings to corporate functions — all outstanding</p>
            </div>

            <!-- Satisfaction -->
            <div class="card-hover bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg">
                    <i class="fas fa-smile text-white text-2xl"></i>
                </div>
                <div class="font-raleway text-4xl font-black text-darkBlue mb-1">{{ $company->satisfied_clients }}%</div>
                <div class="text-sm font-black text-gray-800 mb-2">Client Satisfaction</div>
                <p class="text-xs text-gray-400 leading-relaxed">Happy clients who trust us with their most important events</p>
            </div>

        </div>
    </div>
</section>

<x-frontend.footer-card />
