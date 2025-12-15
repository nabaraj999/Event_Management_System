<x-frontend.frontend-layout>
<div class="py-20 bg-red-50 min-h-screen">
    <div class="max-w-2xl mx-auto text-center">
        <h1 class="text-5xl font-bold text-red-600 mb-8">Invalid Ticket</h1>
        <p class="text-2xl text-red-700">{{ $error ?? 'This QR code is not valid.' }}</p>
        <a href="{{ url('/') }}" class="mt-10 inline-block px-8 py-4 bg-primary text-white rounded-xl">Back to Home</a>
    </div>
</div>
</x-frontend.frontend-layout>
