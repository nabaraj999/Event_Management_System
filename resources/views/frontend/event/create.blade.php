<x-frontend.frontend-layout />
 <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        raleway: ["Raleway", "sans-serif"]
                    },
                    colors: {
                        primary: "#FF7A28",
                        darkBlue: "#063970",
                    }
                }
            }
        }

    </script>
<div class="py-12 lg:py-20 bg-gradient-to-br from-gray-50 to-white min-h-screen font-raleway">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-darkBlue mb-4">
                Complete Your Booking
            </h1>
            <p class="text-xl text-gray-600">Secure your spot for an amazing experience</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1 order-2 lg:order-1">
                <div class="bg-white rounded-3xl shadow-xl p-8 sticky top-24 border border-gray-100">
                    <h3 class="text-2xl font-bold text-darkBlue mb-8 flex items-center">
                        <svg class="w-8 h-8 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Order Summary
                    </h3>

                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-primary/10 to-darkBlue/10 rounded-2xl p-6">
                            <p class="text-sm text-gray-600 mb-2">Event</p>
                            <p class="text-xl font-bold text-darkBlue">{{ $eventTicket->event->title }}</p>
                        </div>

                        <div class="border-b pb-4">
                            <p class="text-sm text-gray-600">Ticket Type</p>
                            <p class="text-lg font-semibold text-darkBlue">{{ $eventTicket->name }}</p>
                            @if($eventTicket->description)
                                <p class="text-sm text-gray-500 mt-2 italic">{{ $eventTicket->description }}</p>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600">Price per ticket</span>
                                <span class="font-bold text-darkBlue">Rs. {{ number_format($eventTicket->price, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-lg">
                                <span class="text-gray-600">Available seats</span>
                                <span class="font-bold {{ $remaining <= 10 ? 'text-red-600 animate-pulse' : 'text-green-600' }}">
                                    {{ $remaining }} left
                                    @if($remaining <= 10)
                                        <span class="text-sm block mt-1">Hurry! Limited seats</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="border-t-2 border-dashed pt-6 mt-8">
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-800">Total Amount</span>
                                <span id="total-amount" class="text-3xl font-extrabold text-primary">
                                    Rs. 0.00
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="lg:col-span-2 order-1 lg:order-2">
                <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12 border border-gray-100">
                    <form action="{{ route('user.booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_ticket_id" value="{{ $eventTicket->id }}">

                        <!-- Quantity Selector -->
                        <div class="mb-10">
                            <label for="quantity" class="block text-xl font-bold text-darkBlue mb-4">
                                How many tickets? <span class="text-red-500">*</span>
                            </label>
                            <select name="quantity" id="quantity"
                                    class="w-full px-6 py-5 text-xl border-2 border-gray-200 rounded-2xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition"
                                    required>
                                <option value="">Choose quantity</option>
                                @for($i = 1; $i <= min(10, $remaining); $i++)
                                    <option value="{{ $i }}">{{ $i }} ticket{{ $i > 1 ? 's' : '' }} — Rs. {{ number_format($i * $eventTicket->price, 2) }}</option>
                                @endfor
                            </select>
                            @error('quantity')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Personal Information -->
                        <div class="mb-10">
                            <h3 class="text-2xl font-bold text-darkBlue mb-6">Your Information</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="full_name" class="block text-lg font-semibold text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="full_name" id="full_name"
                                           value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                           class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition"
                                           placeholder="John Doe"
                                           required>
                                    @error('full_name')
                                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email"
                                           value="{{ old('email', auth()->user()->email ?? '') }}"
                                           class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition"
                                           placeholder="john@example.com"
                                           required>
                                    @error('email')
                                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="phone" class="block text-lg font-semibold text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="phone" id="phone"
                                           value="{{ old('phone') }}"
                                           class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition"
                                           placeholder="e.g., 9800000000"
                                           required>
                                    @error('phone')
                                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-12">
                            <h3 class="text-2xl font-bold text-darkBlue mb-6">Payment Method</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <label class="relative flex items-center p-6 bg-gray-50 rounded-2xl cursor-pointer hover:bg-primary/5 transition border-2 border-transparent hover:border-primary">
                                    <input type="radio" name="payment_method" value="khalti" class="w-6 h-6 text-primary focus:ring-primary" required>
                                    <div class="ml-5">
                                        <div class="text-xl font-bold text-darkBlue">Khalti</div>
                                        <p class="text-gray-600">Pay instantly with Khalti wallet</p>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-6 bg-gray-50 rounded-2xl cursor-pointer hover:bg-primary/5 transition border-2 border-transparent hover:border-primary">
                                    <input type="radio" name="payment_method" value="esewa" class="w-6 h-6 text-primary focus:ring-primary" required>
                                    <div class="ml-5">
                                        <div class="text-xl font-bold text-darkBlue">eSewa</div>
                                        <p class="text-gray-600">Pay securely with eSewa</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-600 text-sm mt-3">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ url()->previous() }}"
                               class="px-8 py-4 text-center bg-gray-200 text-gray-800 rounded-xl font-bold hover:bg-gray-300 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-12 py-5 bg-primary -to-r from-primary to-darkBlue text-white text-xl font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                                Proceed to Payment →
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const quantitySelect = document.getElementById('quantity');
    const totalAmount = document.getElementById('total-amount');
    const price = {{ $eventTicket->price }};

    quantitySelect.addEventListener('change', function() {
        const qty = parseInt(this.value) || 0;
        const total = qty * price;
        totalAmount.textContent = 'Rs. ' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Add animation when total changes
        totalAmount.classList.add('animate-pulse');
        setTimeout(() => totalAmount.classList.remove('animate-pulse'), 600);
    });
</script>

<x-frontend.footer-card />
