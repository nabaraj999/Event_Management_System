<x-admin.admin-layout>

<div class="py-6 px-4 max-w-5xl mx-auto lg:py-12">
    <div class="bg-white rounded-2xl shadow-xl p-6 lg:p-10">
        <div class="text-center mb-10">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800">Ticket Scanner</h1>
            <p class="text-gray-600 mt-4 text-lg lg:text-xl">Fast & reliable check-in for your event</p>
        </div>

        <!-- Gallery Upload - RECOMMENDED -->
        <div class="mb-10 p-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-300 rounded-2xl">
            <label class="block text-xl font-semibold text-gray-800 mb-4 text-center">
                📸 Recommended: Upload Photo
            </label>
            <p class="text-center text-gray-700 mb-6">Take a photo/screenshot of the QR code</p>
            <input type="file" id="qr-image" accept="image/*" capture="environment"
                   class="block w-full px-6 py-5 text-lg border-2 border-blue-400 rounded-xl bg-white focus:ring-4 focus:ring-blue-300">
        </div>

        <!-- Live Camera Controls -->
        <div class="text-center mb-8 space-y-4">
            <button id="start-camera-btn" onclick="startScanner()"
                    class="px-10 py-5 bg-green-600 hover:bg-green-700 text-white font-bold text-xl rounded-2xl shadow-lg transition">
                📷 Open Camera & Capture
            </button>

            <button id="stop-camera-btn" onclick="stopScanner()"
                    class="hidden px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg transition">
                ⏹ Close Camera
            </button>
        </div>

        <!-- Live Scanner + Capture Button -->
        <div id="scanner-container" class="bg-gray-900 rounded-2xl p-6 mb-10 relative overflow-hidden hidden">
            <div id="reader" class="w-full max-w-lg mx-auto"></div>
            <div class="text-center text-white mt-6 space-y-4">
                <p class="text-lg font-medium">Align QR code clearly</p>
                <p class="text-sm opacity-90">Hold steady • Good lighting • No glare</p>
                <button id="capture-btn" onclick="captureAndScan()"
                        class="hidden px-14 py-7 bg-yellow-500 hover:bg-yellow-600 text-black font-bold text-2xl rounded-2xl shadow-2xl transition transform active:scale-95">
                    📸 Capture & Scan Now
                </button>
            </div>
        </div>

        <!-- Manual Token -->
        <div class="mb-10">
            <label class="block text-lg font-semibold text-gray-700 mb-4">Or enter token manually</label>
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="text" id="manual-token" class="flex-1 px-6 py-5 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-orange-300 text-lg"
                       placeholder="Paste token here">
                <button onclick="scanManual()" class="px-10 py-5 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl shadow-lg transition">
                    Verify
                </button>
            </div>
        </div>

        <!-- Result -->
        <div id="result" class="mt-8 hidden"></div>
    </div>
</div>

<!-- Confirm Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full">
        <h3 class="text-3xl font-bold text-gray-800 mb-6 text-center">Confirm Check-In</h3>
        <div id="modal-content" class="space-y-4 text-gray-700 text-lg"></div>
        <div class="flex gap-4 mt-8">
            <button onclick="confirmCheckIn()" class="flex-1 py-5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-xl transition">
                Yes, Check In
            </button>
            <button onclick="closeModal()" class="flex-1 py-5 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-xl text-xl transition">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Already Checked In Warning -->
<div id="alreadyCheckedModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-10 max-w-md w-full text-center">
        <div class="text-7xl mb-6">⚠️</div>
        <h3 class="text-3xl font-bold text-orange-600 mb-4">Already Checked In</h3>
        <p class="text-xl text-gray-700 mb-4">This ticket was used earlier</p>
        <p id="checkedInTime" class="text-2xl font-bold text-gray-800 mb-8"></p>
        <button onclick="closeAlreadyCheckedModal()" class="px-12 py-5 bg-gray-700 hover:bg-gray-800 text-white font-bold rounded-xl text-xl transition">
            Close
        </button>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let currentToken = '';
let html5QrCode = null;
let videoElement = null;

// Extract token from full URL
function extractToken(text) {
    let cleaned = text.trim();
    if (cleaned.includes('?')) cleaned = cleaned.split('?')[0];
    const parts = cleaned.split('/');
    if (parts.length > 1) {
        const last = parts.pop();
        const prev = parts[parts.length - 1];
        if (prev && (prev.includes('verify-ticket') || prev.includes('verify'))) return last;
    }
    return cleaned;
}

// Start camera preview
async function startScanner() {
    if (html5QrCode) await stopScanner();

    html5QrCode = new Html5Qrcode("reader");
    const config = { fps: 10, qrbox: { width: 350, height: 350 }, aspectRatio: 1 };

    document.getElementById('scanner-container').classList.remove('hidden');
    document.getElementById('start-camera-btn').classList.add('hidden');
    document.getElementById('capture-btn').classList.remove('hidden');
    document.getElementById('stop-camera-btn').classList.remove('hidden');

    try {
        await html5QrCode.start({ facingMode: "environment" }, config, () => {}, () => {});
    } catch {
        await html5QrCode.start({ facingMode: "user" }, config, () => {}, () => {});
    }

    videoElement = document.querySelector('#reader video');
}

// Capture current frame and scan
async function captureAndScan() {
    if (!videoElement) {
        alert("Camera not ready yet. Wait a second.");
        return;
    }

    try {
        const canvas = document.createElement('canvas');
        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;
        canvas.getContext('2d').drawImage(videoElement, 0, 0);

        const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.95));

        const tempScanner = new Html5Qrcode("reader");
        const decodedText = await tempScanner.scanFile(blob, false);

        currentToken = extractToken(decodedText);
        if (currentToken) verifyTicket(currentToken);

    } catch (err) {
        alert("No QR code found in photo.\n\n→ Move closer\n→ Hold steady\n→ Tap Capture again");
    }
}

// Stop camera
async function stopScanner() {
    if (html5QrCode) {
        await html5QrCode.stop();
        html5QrCode.clear();
        html5QrCode = null;
        videoElement = null;
    }
    document.getElementById('scanner-container').classList.add('hidden');
    document.getElementById('start-camera-btn').classList.remove('hidden');
    document.getElementById('capture-btn').classList.add('hidden');
    document.getElementById('stop-camera-btn').classList.add('hidden');
}

// Gallery upload
document.getElementById('qr-image').addEventListener('change', async function(e) {
    if (!e.target.files.length) return;
    const file = e.target.files[0];
    if (html5QrCode) await stopScanner();

    try {
        const tempScanner = new Html5Qrcode("reader");
        const decodedText = await tempScanner.scanFile(file, false);
        currentToken = extractToken(decodedText);
        if (currentToken) verifyTicket(currentToken);
    } catch {
        alert("Couldn't read QR. Try a clearer photo.");
    } finally {
        e.target.value = '';
    }
});

// Manual
function scanManual() {
    const token = document.getElementById('manual-token').value.trim();
    if (!token) return alert("Enter a token");
    currentToken = token;
    verifyTicket(token);
}

// Verify
function verifyTicket(token) {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch("{{ route('admin.ticket-scanner.verify') }}", {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
        body: JSON.stringify({ token })
    })
    .then(res => res.ok ? res.json() : res.text().then(t => { throw new Error(t) }))
    .then(data => showResult(data))
    .catch(err => alert("Error: " + err.message + "\nRefresh page."));
}

// Show result
function showResult(data) {
    const result = document.getElementById('result');
    result.classList.remove('hidden');
    result.scrollIntoView({ behavior: 'smooth' });

    if (data.success) {
        document.getElementById('modal-content').innerHTML = `
            <div class="text-center mb-6"><div class="text-6xl">✅</div><p class="text-3xl font-bold text-green-600 mt-4">Valid Ticket!</p></div>
            <div class="bg-green-50 p-6 rounded-xl space-y-3 text-left">
                <p><strong>Name:</strong> ${data.booking.full_name}</p>
                <p><strong>Email:</strong> ${data.booking.email}</p>
                <p><strong>Event:</strong> ${data.booking.event}</p>
                <p><strong>Tickets:</strong> ${data.booking.quantity}</p>
            </div>
        `;
        document.getElementById('confirmModal').classList.remove('hidden');
    } else {
        if (data.already_used) {
            document.getElementById('checkedInTime').textContent = data.booking.checked_in_at || "Unknown time";
            document.getElementById('alreadyCheckedModal').classList.remove('hidden');
        } else {
            result.innerHTML = `
                <div class="p-10 bg-red-50 border-4 border-red-300 rounded-2xl text-center">
                    <div class="text-7xl mb-6">❌</div>
                    <p class="text-3xl font-bold text-red-700 mb-4">Invalid Ticket</p>
                    <p class="text-xl text-red-600">${data.message}</p>
                </div>
            `;
        }
    }
}

function confirmCheckIn() {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch("{{ route('admin.ticket-scanner.checkin') }}", {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
        body: JSON.stringify({ token: currentToken })
    })
    .then(res => res.ok ? res.json() : res.text().then(t => { throw new Error(t) }))
    .then(data => {
        if (data.success) {
            closeModal();
            document.getElementById('result').innerHTML = `
                <div class="p-12 bg-green-50 border-4 border-green-400 rounded-2xl text-center">
                    <div class="text-8xl mb-6">🎉</div>
                    <p class="text-4xl font-bold text-green-700 mb-4">Checked In Successfully!</p>
                    <p class="text-2xl text-green-600">Welcome!</p>
                </div>
            `;
            document.getElementById('manual-token').value = '';
        }
    })
    .catch(err => alert("Check-in failed: " + err.message));
}

function closeModal() { document.getElementById('confirmModal').classList.add('hidden'); }
function closeAlreadyCheckedModal() { document.getElementById('alreadyCheckedModal').classList.add('hidden'); }
</script>

<style>
#reader { width: 100%; max-width: 600px; margin: 0 auto; border-radius: 16px; overflow: hidden; }
#reader video { border-radius: 16px; object-fit: cover; width: 100%; height: auto; }
</style>

</x-admin.admin-layout>
