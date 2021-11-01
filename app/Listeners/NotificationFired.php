<?php

namespace App\Listeners;

use App\Events\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  Notification  $event
     * @return void
     */
    public function handle(Notification $event)
    {
        $notificationInsert = [
            'notification_id' => $event->notificationId,
            'notification_text' => $event->notificationtext,
            'model_id' => $event->modelId,
            'user_id' => Auth::id()
        ];
        DB::table('user_notifications')->insert($notificationInsert);
    }
}
