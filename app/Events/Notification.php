<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notification
{
    use Dispatchable, SerializesModels;

    public $notificationId;
    public $notificationtext;
    public $modelId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notificationId, $notificationtext, $modelId)
    {
        $this->notificationId = $notificationId;
        $this->notificationtext = $notificationtext;
        $this->modelId = $modelId;
    }
}
