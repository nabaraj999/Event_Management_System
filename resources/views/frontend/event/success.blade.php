<x-frontend.frontend-layout title="Booking Success">

<div class="py-24 bg-white min-h-screen font-raleway text-center">
    <div class="max-w-2xl mx-auto px-6">
        <div class="mb-8">
            <svg class="w-24 h-24 text-green-600 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold text-darkBlue mb-4">Payment Successful!</h1>
        <p class="text-xl text-gray-700 mb-8">Your booking has been confirmed. Check your email for ticket details.</p>
        <a href="{{ route('events.index') }}" class="px-10 py-4 bg-primary text-white text-xl font-bold rounded-xl hover:bg-darkBlue transition">
            Back to Events
        </a>
    </div>
</div>

<x-frontend.footer-card />
