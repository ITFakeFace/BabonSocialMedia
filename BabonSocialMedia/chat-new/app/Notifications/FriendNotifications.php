<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendNotifications extends Notification
{
    use Queueable;
    public $user;
    public $id;
    public $username;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'sender_nametoARRAY' => $this->user,
            'message' => 'You receive friend request from ' . $this->user,
        ];
    }

    public function toDatabase (object $notifiable): array
    {
        return [
            'senderid' => $this->user->id,
            'sendername' => $this->user->username,
            'message' => 'You receive friend request from ' . $this->user->username,
        ];
    }
}
