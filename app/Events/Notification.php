<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notification
{
    use Dispatchable, SerializesModels;

    public $notificationId;
    public $notificationtext;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notificationId, $notificationtext)
    {
        $this->notificationId = $notificationId;
        $this->notificationtext = $notificationtext;
    }
}
