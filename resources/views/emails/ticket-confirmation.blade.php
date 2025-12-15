<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Event Ticket</title>
</head>
<body>
    <h1>Ticket Confirmed!</h1>
    <p>Thank you for your purchase, {{ $booking->full_name }}.</p>
    <p>Event: {{ $booking->event->title }}</p>
    <p>Ticket Type: {{ $booking->bookingTickets->first()->eventTicket->name ?? 'N/A' }}</p>
    <p>Quantity: {{ $booking->bookingTickets->first()->quantity ?? 'N/A' }}</p>

    <h3>Scan this QR code at the venue:</h3>

    <img src="data:image/png;base64,{{ base64_encode($qrCodePng) }}"
         alt="Ticket QR Code"
         style="width: 300px; height: 300px; display: block; margin: 20px 0; border: 1px solid #ccc;">

    <p>The QR code is also attached as "Ticket-QR-Code.png" for backup.</p>
    <small>Ticket Token: {{ $booking->ticket_token }}</small>
</body>
</html>
