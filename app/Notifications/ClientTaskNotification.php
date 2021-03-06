<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientTaskNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $taskDetails;
    private $hashURL;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($taskDetails, $hashURL)
    {
        $this->taskDetails = $taskDetails;
        $this->hashURL = $hashURL;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/task-notify/' . $this->hashURL->hash_url);
        return (new MailMessage)
            ->subject('Notification For New Task')
            ->greeting('Hello!')
            ->line('Your task has been created and Assigned to ' . $this->taskDetails->users[1]->name)
            ->line('Task Title: ' . $this->taskDetails->title)
            ->line('Task Details: ' . $this->taskDetails->details)
            ->action('See Details', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}