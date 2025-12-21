<x-organizer.organizer-layout />

<div class="py-6 px-4 max-w-5xl mx-auto lg:py-12">
    <div class="bg-white rounded-2xl shadow-xl p-6 lg:p-10">
        <div class="text-center mb-10">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800">Manual Ticket Check-In</h1>
            <p class="text-gray-600 mt-4 text-lg lg:text-xl">Secure verification by admin</p>
        </div>

        <!-- Search Section -->
        <div class="mb-12 max-w-3xl mx-auto">
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border-2 border-indigo-200 rounded-2xl p-8 shadow-lg">
                <label class="block text-2xl font-semibold text-gray-800 mb-6 text-center">
                    🔍 Search Attendee
                </label>
                <p class="text-center text-gray-700 mb-8 text-lg">Enter name, email, phone or ticket token</p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <input type="text" id="search-query"
                           class="flex-1 px-8 py-6 text-xl border-2 border-indigo-300 rounded-2xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-200 transition"
                           placeholder="e.g. John Doe, john@example.com, +97798..., or ABC123XYZ">
                    <button id="search-btn"
                            class="px-12 py-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xl rounded-2xl shadow-xl transition">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading -->
        <div id="loading" class="text-center my-12 hidden">
            <div class="inline-flex items-center gap-4">
                <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-indigo-600"></div>
                <p class="text-2xl text-indigo-600 font-semibold">Searching attendee...</p>
            </div>
        </div>

        <!-- Booking Found -->
        <div id="result-container" class="hidden max-w-4xl mx-auto">
            <div id="booking-details" class="bg-white rounded-3xl shadow-2xl p-10 border-4 border-green-200"></div>
        </div>

        <!-- Error Messages -->
        <div id="error-container" class="max-w-3xl mx-auto my-16 hidden">
            <div class="bg-red-50 border-4 border-red-300 rounded-3xl p-12 text-center">
                <div class="text-8xl mb-6">❌</div>
                <h3 class="text-4xl font-bold text-red-700 mb-6" id="error-title">Invalid Ticket</h3>
                <p class="text-2xl text-red-600 mb-8" id="error-message">Ticket not found or invalid details</p>
                <p class="text-lg text-gray-700">Please verify the information and try again.</p>
            </div>
        </div>

        <!-- Already Checked In -->
        <div id="already-checked" class="max-w-3xl mx-auto my-16 hidden">
            <div class="bg-orange-50 border-4 border-orange-300 rounded-3xl p-12 text-center">
                <div class="text-8xl mb-6">⚠️</div>
                <h3 class="text-4xl font-bold text-orange-600 mb-6">Already Checked In</h3>
                <p class="text-2xl text-orange-700 mb-4">This attendee has already entered the event</p>
                <p class="text-xl text-gray-700" id="checked-time"></p>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Check-In Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-3xl p-12 max-w-lg w-full text-center">
        <div class="text-8xl mb-6">✅</div>
        <h3 class="text-4xl font-bold text-green-600 mb-6">Confirm Check-In?</h3>
        <p class="text-xl text-gray-700 mb-10">This will mark the ticket as used and allow entry</p>
        <div class="flex gap-6">
            <button id="confirm-btn" class="flex-1 py-6 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl text-2xl transition shadow-xl">
                Yes, Check In
            </button>
            <button onclick="closeConfirmModal()" class="flex-1 py-6 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-2xl text-2xl transition">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
let currentToken = '';

function searchBooking() {
    const query = document.getElementById('search-query').value.trim();
    if (!query) {
        alert("Please enter name, email, phone or ticket token");
        return;
    }

    // Show loading, hide others
    document.getElementById('loading').classList.remove('hidden');
    document.getElementById('result-container').classList.add('hidden');
    document.getElementById('error-container').classList.add('hidden');
    document.getElementById('already-checked').classList.add('hidden');

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('org.ticket-scanner.search') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf
        },
        body: JSON.stringify({ query: query })
    })
    .then(res => res.ok ? res.json() : res.text().then(t => { throw new Error(t) }))
    .then(data => {
        document.getElementById('loading').classList.add('hidden');

        if (data.success && data.booking) {
            currentToken = data.booking.ticket_token;

            let checkInButton = '';
            let statusSection = '';

            if (data.booking.is_checked_in) {
                document.getElementById('checked-time').textContent = data.booking.checked_in_at || "Time not recorded";
                document.getElementById('already-checked').classList.remove('hidden');
                return;
            } else {
                checkInButton = `
                    <div class="mt-12 text-center">
                        <button onclick="openConfirmModal()" class="px-20 py-10 bg-green-600 hover:bg-green-700 text-white font-bold text-4xl rounded-3xl shadow-2xl transition transform hover:scale-105">
                            ✅ Check In Now
                        </button>
                    </div>`;
            }

            document.getElementById('booking-details').innerHTML = `
                <div class="text-center mb-10">
                    <div class="text-7xl mb-6">🎟️</div>
                    <h2 class="text-4xl font-bold text-indigo-800 mb-4">${data.booking.full_name}</h2>
                    <p class="text-2xl text-gray-700 mb-6">${data.booking.event_title}</p>
                    <span class="inline-block px-8 py-4 bg-green-100 text-green-800 font-bold rounded-full text-xl">Valid Ticket</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-50 rounded-3xl p-10 shadow-inner text-left text-lg">
                    <div><strong class="text-indigo-700">Email:</strong><br>${data.booking.email}</div>
                    <div><strong class="text-indigo-700">Phone:</strong><br>${data.booking.phone || 'Not provided'}</div>
                    <div><strong class="text-indigo-700">Ticket Token:</strong><br><code class="bg-gray-200 px-4 py-2 rounded-lg">${data.booking.ticket_token}</code></div>
                    <div><strong class="text-indigo-700">Quantity:</strong><br>${data.booking.quantity}</div>
                    <div><strong class="text-indigo-700">Booking Date:</strong><br>${data.booking.booking_date}</div>
                    <div><strong class="text-indigo-700">Payment:</strong><br><span class="text-green-600 font-bold">${data.booking.payment_status}</span></div>
                </div>

                ${checkInButton}
            `;

            document.getElementById('result-container').classList.remove('hidden');
        } else {
            document.getElementById('error-title').textContent = "Ticket Not Found";
            document.getElementById('error-message').textContent = "No matching booking found. Please check the details.";
            document.getElementById('error-container').classList.remove('hidden');
        }
    })
    .catch(err => {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('error-title').textContent = "Search Error";
        document.getElementById('error-message').textContent = "Something went wrong. Please try again.";
        document.getElementById('error-container').classList.remove('hidden');
    });
}

// Search on button click or Enter
document.getElementById('search-btn').addEventListener('click', searchBooking);
document.getElementById('search-query').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') searchBooking();
});

function openConfirmModal() {
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

document.getElementById('confirm-btn').addEventListener('click', function() {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('org.ticket-scanner.checkin') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf
        },
        body: JSON.stringify({ token: currentToken })
    })
    .then(res => res.ok ? res.json() : res.text().then(t => { throw new Error(t) }))
    .then(data => {
        if (data.success) {
            closeConfirmModal();
            alert("🎉 Checked in successfully!");
            location.reload();
        } else {
            closeConfirmModal();
            alert("Error: " + (data.message || "Check-in failed"));
        }
    })
    .catch(err => {
        closeConfirmModal();
        alert("Check-in failed: " + err.message);
    });
});
</script>


