<!-- resources/views/mails/verify-email.blade.php -->

@component('mail::message')
# Verify Email Address

Hi {{ $userName }},

You recently registered on {{ config('app.name') }}. To complete your registration, please click the button below to verify your email address:

@component('mail::button', ['url' => $url])
Verify Email
@endcomponent

**Note: This link is valid for a limited time.**

If you didn't register on our site, no further action is required.

Regards,<br>
{{ config('app.name') }}
@endcomponent
