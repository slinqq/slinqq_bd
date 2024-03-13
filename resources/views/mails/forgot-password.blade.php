<!-- resources/views/mails/forgot_password.blade.php -->

@component('mail::message')
# Forgot Password Notification

Hi {{ $userName }},

You recently requested to reset your password. Click the button below to reset it:

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

**Note: This link is valid for 1 hour.**

If you didn't request a password reset, no further action is required.

Regards,<br>
{{ config('app.name') }}
@endcomponent