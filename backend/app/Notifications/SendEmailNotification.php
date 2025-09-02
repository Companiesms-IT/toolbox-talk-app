<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailNotification extends Notification
{
    use Queueable;

    protected $toolboxTalk;
    protected $subject;
    protected $line;
    protected $actionUrl;
    protected $actionText;
    /**
     * Create a new notification instance.
     *
     * @param object $toolboxTalk
     * @param string $subject
     * @param string $line
     * @param string $actionUrl
     * @param string $actionText
     */
    public function __construct($toolboxTalk, string $subject, string $line, string $actionUrl, string $actionText)
    {
        $this->toolboxTalk = $toolboxTalk;
        $this->subject = $subject;
        $this->line = $line;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('Hello,')
            ->line($this->line)
            ->action($this->actionText, $this->actionUrl)
            ->line('Thank you for using our application!');
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'toolbox_talk_id' => $this->toolboxTalk->id,
            'subject' => $this->subject,
            'message' => $this->line,
        ];
    }
}
