<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Receipt - {{ $booking->ticket_token }}</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #111;
            background: #fff;
        }

        @page {
            size: A4;
            margin: 18mm;
        }

        .receipt {
            max-width: 420px;
            margin: auto;
        }

        h1 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 2px;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-bottom: 10px;
        }

        .divider {
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }

        .box {
            border: 1px solid #ddd;
            padding: 8px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 4px 0;
        }

        th {
            text-align: left;
            font-weight: bold;
        }

        .right { text-align: right; }
        .center { text-align: center; }

        .total-row td {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 6px;
        }

        .qr {
            text-align: center;
            margin-top: 12px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 12px;
        }
    </style>
</head>

<body>

<div class="receipt">

    <!-- HEADER -->
    <h1>EventHUB</h1>
    <div class="subtitle">Event Ticket & Payment Receipt</div>

    <!-- EVENT INFO (PRIMARY) -->
    <div class="box">
        <strong>{{ $booking->event->title }}</strong><br>
        Date: {{ $booking->event->start_date->format('d M Y') }}<br>
        Location: {{ $booking->event->location }}
    </div>

    <!-- META -->
    <table>
        <tr>
            <td>Ticket ID:</td>
            <td class="right">{{ $booking->ticket_token }}</td>
        </tr>
        <tr>
            <td>Issued On:</td>
            <td class="right">{{ $booking->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Payment Status:</td>
            <td class="right">{{ ucfirst($booking->payment_status) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- ATTENDEE -->
    <strong>Attendee</strong><br>
    {{ $booking->full_name }}<br>
    <span style="color:#666">{{ $booking->email }} | {{ $booking->phone }}</span>

    <div class="divider"></div>

    <!-- TICKETS -->
    <table>
        <thead>
            <tr>
                <th>Ticket</th>
                <th class="center">Qty</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->bookingTickets as $bt)
            <tr>
                <td>{{ $bt->eventTicket->name }}</td>
                <td class="center">{{ $bt->quantity }}</td>
                <td class="right">Rs. {{ number_format($bt->sub_total, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">Total Paid</td>
                <td class="right">Rs. {{ number_format($booking->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- QR CODE -->
    <div class="qr">
        <img
            src="{{ public_path('storage/' . $booking->qr_path) }}"
            width="130"
            alt="Ticket QR Code"
        >
        <div style="font-size:10px;color:#666;margin-top:4px;">
            Present this QR code at entry
        </div>

        @if($booking->is_checked_in)
            <div style="color:green;font-weight:bold;margin-top:4px;">
                ✔ Already Checked In
            </div>
        @endif
    </div>

    <!-- FOOTER -->
    <div class="footer">
        This is a system-generated ticket receipt.<br>
        Support: support@eventhub.com
    </div>

</div>

</body>
</html>
