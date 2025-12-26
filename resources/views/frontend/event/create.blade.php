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
                    khalti: "#5C2D91",
                }
            }
        }
    }
</script>

<div class="py-10 lg:py-16 bg-gradient-to-br from-gray-50 to-white min-h-screen font-raleway">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        <!-- Page Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-darkBlue mb-3">
                Complete Your Booking
            </h1>
            <p class="text-base sm:text-lg text-gray-600">
                Secure your spot in just one step
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Order Summary -->
            <div class="lg:col-span-1 order-2 lg:order-1">
                <div class="bg-white rounded-3xl shadow-xl p-6 sticky top-24 border">
                    <h3 class="text-xl font-bold text-darkBlue mb-6">
                        Order Summary
                    </h3>

                    <div class="space-y-5">
                        <div class="bg-primary/10 rounded-2xl p-4">
                            <p class="text-sm text-gray-600">Event</p>
                            <p class="text-lg font-bold text-darkBlue">
                                {{ $eventTicket->event->title }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Ticket Type</p>
                            <p class="text-base font-semibold text-darkBlue">
                                {{ $eventTicket->name }}
                            </p>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Price per ticket</span>
                            <span class="font-bold text-darkBlue">
                                Rs. {{ number_format($eventTicket->price, 2) }}
                            </span>
                        </div>

                        <div class="border-t pt-4 flex justify-between items-center">
                            <span class="text-lg font-bold">Total</span>
                            <span id="total-amount" class="text-xl font-extrabold text-primary">
                                Rs. 0.00
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="lg:col-span-2 order-1 lg:order-2">
                <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 border">
                    <form action="{{ route('user.booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_ticket_id" value="{{ $eventTicket->id }}">

                        <!-- Quantity -->
                        <div class="mb-8">
                            <label class="block text-lg font-bold text-darkBlue mb-3">
                                Number of Tickets
                            </label>
                            <select name="quantity" id="quantity"
                                class="w-full px-5 py-4 border-2 rounded-xl focus:border-primary focus:ring-primary/20"
                                required>
                                <option value="">Select quantity</option>
                                @for($i = 1; $i <= min(10, $remaining); $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }} ticket{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- User Info -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-darkBlue mb-4">
                                Your Information
                            </h3>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <input type="text" name="full_name"
                                    value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                    placeholder="Full Name"
                                    class="w-full px-5 py-4 border-2 rounded-xl"
                                    required>

                               <input type="email" name="email"
       value="{{ old('email', auth()->user()->email ?? '') }}"
       placeholder="Email Address"
       class="w-full px-5 py-4 border-2 rounded-xl"
       readonly
       required>

                                <input type="text" name="phone"
                                    placeholder="Phone Number"
                                    class="sm:col-span-2 w-full px-5 py-4 border-2 rounded-xl"
                                    required>
                            </div>
                        </div>

                        <!-- Khalti Payment -->
                        <div class="mb-10">
                            <h3 class="text-xl font-bold text-darkBlue mb-4">
                                Payment Method
                            </h3>

                            <div class="flex items-center gap-4 p-5 rounded-2xl border-2 border-khalti/30 bg-khalti/5">
                                <img src="https://cdn.aptoide.com/imgs/b/2/c/b2c3c82e2890203b7a4b0cfb188b3f71_icon.png"
                                     alt="Khalti"
                                     class="w-14 h-14 object-contain">
                                <div>
                                    <p class="text-lg font-bold text-khalti">
                                        Khalti Wallet
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Secure payment via Khalti
                                    </p>
                                </div>
                            </div>

                            <input type="hidden" name="payment_method" value="khalti">
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ url()->previous() }}"
                               class="w-full sm:w-auto px-8 py-4 bg-gray-200 rounded-xl font-bold text-center">
                                Cancel
                            </a>

                            <button type="submit"
                                class="w-full sm:w-auto px-10 py-4 bg-khalti text-white font-bold rounded-xl
                                       hover:bg-[#4a2476] transition shadow-lg">
                                Pay with Khalti →
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const quantity = document.getElementById('quantity');
    const total = document.getElementById('total-amount');
    const price = {{ $eventTicket->price }};

    quantity.addEventListener('change', () => {
        const q = parseInt(quantity.value || 0);
        total.textContent = 'Rs. ' + (q * price).toLocaleString('en-US', {
            minimumFractionDigits: 2
        });
    });
</script>

<x-frontend.footer-card />
