<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-header {
            text-align: center;
            background-color: #f0f0f0;
            padding: 20px 0;
        }

        .invoice-header h1 {
            margin: 0;
            color: #333;
            font-weight: bold;
        }

        .company-info {
            text-align: right;
            margin-top: 20px;
        }

        .company-info p {
            margin: 5px 0;
        }

        .invoice-details {
            width: 100%;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .left-section {
            width: 50%;
        }

        .right-section {
            width: 50%;
        }

        .left-section p,
        .right-section p {
            margin: 5px 0;
        }

        .payment-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .payment-table th,
        .payment-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .payment-table th {
            background-color: #f2f2f2;
        }

        .subtotal-section {
            margin-top: 20px;
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
            color: #555;
        }

        .gap-vertical {
            margin-bottom: 20px !important;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <h1>INVOICE</h1>
    </div>

    <div class="company-info">
        <p>{{ $invoiceData['building']->name }}</p>
        <p>{{ $invoiceData['building']->address }}</p>
        <p>Phone: {{ $invoiceData['building']->contact_no }}</p>
        <!-- Add any other company information you want to include -->
    </div>

    <div class="invoice-details">
        <div class="left-section">
            <p class="gap-vertical"><strong>Details:</strong></p>
            <p><strong>Name:</strong> {{ $invoiceData['flat']->name }}</p>
            <p><strong>Email:</strong> {{ $invoiceData['flat']->email }}</p>
            <p><strong>Advance Payment:</strong> {{ $invoiceData['flat']->advance_amount }} TK</p>
        </div>

        <div class="right-section">
            <p><strong>Building :</strong> {{ $invoiceData['building']->name }}</p>
            <p><strong>Floor :</strong> {{ $invoiceData['floor']->title }}</p>
            <p><strong>Flat :</strong> {{ $invoiceData['flat']->name }}</p>
        </div>
    </div>

    <table class="payment-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Status</th>
                <th>Amount</th>
                <!-- Add more table headers if needed -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Payment for Month: {{ $invoiceData['payment']->payment_for_month }}</td>
                <td>{{ $invoiceData['payment']->status }}</td>
                <td>{{ $invoiceData['payment']->amount }} TK</td>
            </tr>
            <!-- Add more rows for additional payment info -->
        </tbody>
    </table>

    <div class="subtotal-section">
        <p><strong>Subtotal:</strong> {{ $invoiceData['payment']->amount }} TK</p>
        <!-- Add more details if needed -->
    </div>

    <div class="footer">
        <p>All rights reserved &copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>

</body>

</html>