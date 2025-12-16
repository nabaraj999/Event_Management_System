<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $booking->ticket_token }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        @media print {
            .no-print { display: none !important; }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
            text-align: left;
        }
    </style>
</head>

<body class="bg-white">

<div class="max-w-[794px] mx-auto">

    <!-- PRINT BUTTON -->
    <div class="no-print text-center mb-4">
        <button onclick="window.print()"
                class="px-6 py-2 bg-black text-white text-sm rounded">
            Download PDF
        </button>
    </div>

    <!-- HEADER -->
    <div class="flex justify-between items-center border-b pb-3 mb-4">
        <div>
            <h1 class="text-xl font-bold">EventHUB</h1>
            <p class="text-xs text-gray-600">Booking Invoice & Ticket</p>
        </div>

        <div class="text-right text-xs">
            <p><strong>Invoice No:</strong> {{ $booking->ticket_token }}</p>
            <p><strong>Date:</strong> {{ $booking->created_at->format('d M Y') }}</p>
            <p>
                <strong>Status:</strong>
                {{ ucfirst($booking->payment_status) }}
            </p>
        </div>
    </div>

    <!-- CUSTOMER & EVENT INFO -->
    <div class="grid grid-cols-2 gap-6 mb-4">

        <div>
            <h3 class="font-bold mb-1">Billed To</h3>
            <p>{{ $booking->full_name }}</p>
            <p>{{ $booking->email }}</p>
            <p>{{ $booking->phone }}</p>
        </div>

        <div>
            <h3 class="font-bold mb-1">Event Details</h3>
            <p><strong>{{ $booking->event->title }}</strong></p>
            <p>Date: {{ $booking->event->start_date->format('d M Y') }}</p>
            <p>Location: {{ $booking->event->location }}</p>
        </div>

    </div>

    <!-- TICKET TABLE -->
    <table class="mb-4 text-xs">
        <thead>
            <tr>
                <th>Ticket Type</th>
                <th style="text-align:center">Qty</th>
                <th style="text-align:right">Price</th>
                <th style="text-align:right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->bookingTickets as $bt)
            <tr>
                <td>{{ $bt->eventTicket->name }}</td>
                <td style="text-align:center">{{ $bt->quantity }}</td>
                <td style="text-align:right">Rs. {{ number_format($bt->price_at_booking, 2) }}</td>
                <td style="text-align:right">Rs. {{ number_format($bt->sub_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="flex justify-end mb-4">
        <table class="w-1/3 text-xs">
            <tr>
                <th>Total Amount</th>
                <td style="text-align:right; font-weight:bold">
                    Rs. {{ number_format($booking->total_amount, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <!-- QR CODE -->
    <div class="flex justify-between items-center mt-6">

        <div class="text-xs">
            <p><strong>Ticket Token:</strong></p>
            <p class="font-mono">{{ $booking->ticket_token }}</p>

            @if($booking->is_checked_in)
                <p class="mt-2 text-green-700 font-bold">
                    ✔ Checked In
                </p>
            @endif
        </div>

        <div>
            {!! QrCode::size(120)->generate(route('verify.ticket', $booking->ticket_token)) !!}
        </div>

    </div>

    <!-- FOOTER -->
    <div class="border-t mt-6 pt-3 text-center text-xs text-gray-600">
        <p>This invoice is system generated.</p>
        <p>Support: support@eventhub.com</p>
    </div>

</div>

</body>
</html>
