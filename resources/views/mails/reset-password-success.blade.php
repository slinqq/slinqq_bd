<!-- resources/views/mails/password_reset_success.blade.php -->

@component('mail::message')
# Password Reset Successful

Hi {{ $userName }},

Your password has been successfully reset. If you did not initiate this change, please contact us immediately.

If you have any further questions or concerns, feel free to reach out.

Regards,<br>
{{ config('app.name') }}
@endcomponent
