<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $invoice_no }}</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 40px;
            line-height: 1.6;
        }

        /* ---------- HEADER ---------- */
        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
        }

        .company-details {
            font-size: 11px;
            color: #555;
            margin-top: 4px;
        }

        .invoice-title {
            float: right;
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 26px;
        }

        .invoice-title p {
            margin: 4px 0;
            font-size: 12px;
        }

        /* ---------- BOX ---------- */
        .box {
            border: 1px solid #ddd;
            padding: 14px;
            margin-bottom: 20px;
        }

        .box strong {
            font-size: 13px;
        }

        /* ---------- TABLE ---------- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background: #f2f2f2;
            text-align: left;
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background: #fafafa;
        }

        /* ---------- FOOTER ---------- */
        .footer {
            margin-top: 60px;
            border-top: 1px solid #ccc;
            padding-top: 12px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="invoice-title">
        <h2>INVOICE</h2>
        <p><strong>Invoice No:</strong> {{ $invoice_no }}</p>
        <p><strong>Date:</strong> {{ $generated_at }}</p>
    </div>

    <div class="company-name">
        {{ $company->name ?? 'EventHub Pvt. Ltd.' }}
    </div>
    <div class="company-details">
        {{ $company->address_full ?? 'Kathmandu, Nepal' }} <br>
        Email: {{ $company->email ?? 'info@eventhub.com' }} |
        Phone: {{ $company->phone ?? '+977-1-XXXXXXX' }}
        @if ($company->pan_no ?? false)
            <br>PAN/VAT: {{ $company->pan_no }}
        @endif
    </div>

    <div style="clear: both;"></div>
</div>

<!-- BILLED TO -->
<div class="box">
    <strong>Billed To:</strong><br>
    {{ $organizer->organization_name ?? ($organizer->contact_person ?? 'Unknown Organizer') }}<br>
    @if ($organizer->contact_person ?? false)
        Contact Person: {{ $organizer->contact_person }}<br>
    @endif
    Email: {{ $organizer->email ?? 'N/A' }}<br>
    @if ($organizer->phone ?? false)
        Phone: {{ $organizer->phone }}
    @endif
</div>

<!-- EVENT DETAILS -->
<div class="box">
    <strong>Event Details:</strong><br>
    {{ $event->title }}<br>
    Location: {{ $event->location ?? 'Not specified' }}<br>
    Date: {{ $event->start_date->format('d M Y') }}
    @if ($event->end_date)
        – {{ $event->end_date->format('d M Y') }}
    @endif
</div>

<!-- SALES TABLE -->
<table>
    <thead>
        <tr>
            <th>Ticket Type</th>
            <th class="right">Price (NPR)</th>
            <th class="right">Sold</th>
            <th class="right">Amount (NPR)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ticketSales as $sale)
            <tr>
                <td>{{ $sale['name'] }}</td>
                <td class="right">{{ number_format($sale['price']) }}</td>
                <td class="right">{{ $sale['sold'] }}</td>
                <td class="right">{{ number_format($sale['subtotal']) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="right" style="text-align:center;">No ticket sales recorded</td>
            </tr>
        @endforelse

        <tr class="total-row">
            <td colspan="3" class="right">Gross Revenue</td>
            <td class="right">Rs. {{ number_format($totalGross) }}</td>
        </tr>

        <tr>
            <td colspan="3" class="right">Platform Commission (16%)</td>
            <td class="right">- Rs. {{ number_format($commission) }}</td>
        </tr>

        <tr class="total-row">
            <td colspan="3" class="right">Net Payable</td>
            <td class="right">Rs. {{ number_format($netIncome) }}</td>
        </tr>
    </tbody>
</table>

<!-- FOOTER -->
<div class="footer">
    This is a system-generated invoice. No signature required.<br>
    © {{ now()->year }} {{ $company->name ?? 'EventHub Pvt. Ltd.' }}
</div>

</body>
</html>
