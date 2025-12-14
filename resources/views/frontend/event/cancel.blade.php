<x-frontend.frontend-layout />

<div class="py-24 bg-white min-h-screen font-raleway text-center">
    <div class="max-w-2xl mx-auto px-6">
        <h1 class="text-4xl font-extrabold text-darkBlue mb-4">Payment Cancelled</h1>
        <p class="text-xl text-gray-700 mb-8">Your booking was not completed. You can try again.</p>
        <a href="{{ route('events.index') }}" class="px-10 py-4 bg-primary text-white text-xl font-bold rounded-xl hover:bg-darkBlue transition">
            Back to Events
        </a>
    </div>
</div>

<x-frontend.footer-card />
