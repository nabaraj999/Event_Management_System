{{-- resources/views/emails/ticket-confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Your Event Ticket - {{ $booking->event->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #333333;
        }
        table { border-collapse: collapse; }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }
        .header p {
            margin: 12px 0 0;
            font-size: 18px;
            opacity: 0.95;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .ticket-card {
            width: 100%;
            border: 3px solid #e0e0e0;
            border-radius: 16px;
            overflow: hidden;
            margin: 30px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .ticket-header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .ticket-body {
            padding: 30px;
            background-color: #f8f9fa;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px dashed #ced4da;
            font-size: 16px;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #495057;
            width: 40%;
            text-align: left;
        }
        .value {
            color: #212529;
            width: 60%;
            text-align: right;
            font-weight: 500;
        }
        .qr-section {
            margin: 40px 0;
            padding: 30px;
            background-color: #ffffff;
            border: 2px solid #dee2e6;
            border-radius: 12px;
        }
        .qr-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #343a40;
        }
        .qr-image {
            width: 260px;
            height: 260px;
            border: 10px solid #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            margin: 0 auto;
            display: block;
        }
        .qr-note {
            margin-top: 20px;
            color: #6c757d;
            font-size: 15px;
        }
        .closing {
            margin-top: 30px;
            font-size: 16px;
            color: #495057;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            font-size: 13px;
            color: #868e96;
        }
        .footer a {
            color: #4a90e2;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .detail-row {
                flex-direction: column;
                text-align: left;
            }
            .label, .value {
                width: 100%;
                text-align: left;
            }
            .value {
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table class="container" cellpadding="0" cellspacing="0">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            <h1>Ticket Confirmed! 🎉</h1>
                            <p>We're thrilled to have you at the event</p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td class="content">
                            <p class="greeting">Dear <strong>{{ $booking->full_name }}</strong>,</p>
                            <p>Thank you for your booking. Your ticket is confirmed and ready!</p>

                            <!-- Ticket Card -->
                            <table class="ticket-card" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="ticket-header">
                                        {{ $booking->event->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ticket-body">
                                        <div class="detail-row">
                                            <span class="label">Ticket Type</span>
                                            <span class="value">{{ $booking->bookingTickets->first()->eventTicket->name ?? 'General Admission' }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Quantity</span>
                                            <span class="value">{{ $booking->quantity ?? $booking->bookingTickets->first()->quantity ?? '1' }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Date & Time</span>
                                            <span class="value">
                                                {{ \Carbon\Carbon::parse($booking->event->start_date)->format('F j, Y') }}
                                                @if($booking->event->start_time)
                                                    at {{ $booking->event->start_time }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Venue</span>
                                            <span class="value">{{ $booking->event->location ?? $booking->event->venue ?? 'See event details' }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Order ID</span>
                                            <span class="value">#{{ $booking->id }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Ticket Token</span>
                                            <span class="value"><strong>{{ $booking->ticket_token }}</strong></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- QR Code Section -->
                            <div class="qr-section">
                                <p class="qr-title">Your Entry QR Code</p>
                               <img src="data:image/png;base64,{{ $qrCodeBase64 }}"
     alt="Ticket QR Code"
     class="qr-image">

                                <p class="qr-note">
                                    Show this QR code at the venue entrance.<br>
                                    A separate QR image and full PDF ticket are attached for backup and printing.
                                </p>
                            </div>

                            <p class="closing">
                                We can't wait to see you there!<br>
                                If you have any questions, just reply to this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p>&copy; {{ date('Y') }} EventHUB. All rights reserved.</p>
                            <p>
                                Need help?
                                <a href="mailto:support@eventhub.com">support@eventhub.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
