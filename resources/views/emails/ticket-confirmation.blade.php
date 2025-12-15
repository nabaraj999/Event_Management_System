<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Your Event Ticket - {{ $booking->event->title }}</title>
    <style type="text/css">
        body { margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif; }
        table { border-collapse: collapse; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
        .header { background-color: #4a90e2; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 30px; text-align: center; }
        .ticket-card { width: 100%; border: 2px solid #e0e0e0; border-radius: 10px; overflow: hidden; margin: 20px 0; }
        .ticket-header { background-color: #333333; color: #ffffff; padding: 15px; font-size: 20px; font-weight: bold; }
        .ticket-body { padding: 20px; background-color: #fafafa; }
        .detail-row { padding: 10px 0; border-bottom: 1px dashed #dddddd; text-align: left; }
        .label { font-weight: bold; width: 40%; }
        .value { width: 60%; }
        .qr-section { margin: 30px 0; padding: 20px; background-color: #ffffff; border: 1px solid #dddddd; border-radius: 8px; }
        .qr-image { width: 250px; height: 250px; border: 8px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .footer { background-color: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #777777; }
        .button { display: inline-block; background-color: #4a90e2; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }
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
                            <p style="margin: 10px 0 0; font-size: 18px;">We're excited to see you at the event!</p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td class="content">
                            <p>Dear {{ $booking->full_name }},</p>
                            <p>Thank you for your purchase. Your ticket is ready!</p>

                            <!-- Ticket Card -->
                            <table class="ticket-card" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="ticket-header">
                                        {{ $booking->event->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ticket-body">
                                        <table width="100%">
                                            <tr class="detail-row">
                                                <td class="label">Ticket Type</td>
                                                <td class="value">{{ $booking->bookingTickets->first()->eventTicket->name ?? 'General' }}</td>
                                            </tr>
                                            <tr class="detail-row">
                                                <td class="label">Quantity</td>
                                                <td class="value">{{ $booking->bookingTickets->first()->quantity ?? '1' }}</td>
                                            </tr>
                                            <tr class="detail-row">
                                                <td class="label">Date & Time</td>
                                                <td class="value">{{ \Carbon\Carbon::parse($booking->event->start_date)->format('F j, Y') }} at {{ $booking->event->start_time ?? 'TBD' }}</td>
                                            </tr>
                                            <tr class="detail-row">
                                                <td class="label">Venue</td>
                                                <td class="value">{{ $booking->event->venue ?? 'See event details' }}</td>
                                            </tr>
                                            <tr class="detail-row">
                                                <td class="label">Order ID</td>
                                                <td class="value">#{{ $booking->id }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- QR Code Section -->
                            <div class="qr-section">
                                <p style="font-size: 18px; margin-bottom: 20px;"><strong>Scan this QR code at the venue for entry</strong></p>
                                <img src="data:image/png;base64,{{ base64_encode($qrCodePng) }}"
                                     alt="Ticket QR Code"
                                     class="qr-image">
                                <p style="margin-top: 20px; color: #555555;">The QR code is also attached as "Ticket-QR-Code.png" for backup.</p>
                            </div>

                            <p>See you soon! If you have any questions, reply to this email.</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p>&copy; {{ date('Y') }} Your Event Platform. All rights reserved.</p>
                            <p>Need help? Contact us at support@yourevent.com</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
