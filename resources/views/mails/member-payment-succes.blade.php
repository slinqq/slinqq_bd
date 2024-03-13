@component('mail::message')
# Payment Success

Your payment for the month of **{{ $formattedMonth }}** has been successfully processed.

**Details:**
- Amount: {{ $data['amount'] }} {{ $data['currency'] }}
- Payment Method: {{ $data['payment_method'] }}
- Payment Date: {{ $data['payment_date'] }}

@component('mail::button', ['url' => url("/download-invoice-pdf/{$data['payment_id']}/{$data['section_id']}")])
Download Invoice
@endcomponent

Thank you for using our services!

@endcomponent