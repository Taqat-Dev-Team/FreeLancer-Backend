<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\Channel;

class NewIDRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->data['title'] ?? 'بدون عنوان',
            'message' => $this->data['message'] ?? '',
            'url' => $this->data['url'] ?? '#',
            'freelancer_id' => $this->data['freelancer_id'] ?? null,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'freelancer_id' => $this->data['freelancer_id'],
            'url' => $this->data['url'],
        ]);
    }

    public function broadcastOn(): Channel
    {
        return new Channel('admin-notifications');
    }
}
