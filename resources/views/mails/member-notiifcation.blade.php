<!-- resources/views/mails/member-notification.blade.php -->

@component('mail::message')

Hello {{ $notifiable->name }},

{{ $message }}

Thank you for using our application!

@if ($attachmentPath)
<div style="margin-top: 20px; margin-bottom: 20px; padding: 10px; background-color: #28a745; color: #fff; text-align: center; cursor: pointer; font-weight: bold; max-width: 200px; margin-left: auto; margin-right: auto;">
    <a href="{{ route('download.attachment', ['filename' => $attachmentName]) }}" style="text-decoration: none; color: #fff;">
        Download Attachment
    </a>
</div>
@endif

Regards,<br>
{{ config('app.name') }}
@endcomponent
