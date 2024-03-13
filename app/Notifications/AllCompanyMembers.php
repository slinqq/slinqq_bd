<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AllCompanyMembers extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $attachmentPath;
    protected $subject;
    protected $sender;
    public $tries = 3;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     * @param string|null $attachmentPath
     */
    public function __construct($message, $subject, $attachmentPath = null, $sender = null)
    {
        $this->message = $message;
        $this->attachmentPath = $attachmentPath;
        $this->subject = $subject;
        $this->sender = $sender;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->markdown('mails.member-notiifcation', [
                'subject' => $this->subject,
                'notifiable' => $notifiable,
                'message' => $this->message,
                'attachmentPath' => $this->attachmentPath,
                'attachmentName' => pathinfo($this->attachmentPath, PATHINFO_BASENAME),
            ])
            ->subject($this->subject)
            ->from($this->sender->email, $this->sender->name);

        if ($this->attachmentPath) {
            $attachmentName = pathinfo($this->attachmentPath, PATHINFO_BASENAME);

            $fileContent = file_get_contents(public_path('storage/' . $this->attachmentPath));

            $mailMessage->attachData($fileContent, $attachmentName, [
                'mime' => mime_content_type(public_path('storage/' . $this->attachmentPath)),
            ]);
        }

        return $mailMessage;
    }





    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
