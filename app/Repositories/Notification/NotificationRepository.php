<?php

namespace App\Repositories\Notification;

use App\Models\Offers;
use App\Models\OfferViews;
use App\Models\OfferTags;
use App\Models\UserOfferTags;
use App\Models\OfferFavourite;
use App\Models\PaymentMethods;
use App\Models\UserNotifications;
use Illuminate\Support\Facades\Auth;

class NotificationRepository
{
    /**
     * get offer details.
     *
     * @param int $userId
     */
    public function getNotificationDetails(int $userId, $skip, $take)
    {
        return UserNotifications::with('notifications')->where("user_id", $userId)->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
    }

    public function updateNotificationDetails(int $userId, $skip, $take)
    {
        $allNotifications = UserNotifications::where("user_id", $userId)->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
        if(!empty($allNotifications)) {
            foreach($allNotifications as $notification) {
                UserNotifications::where('id', $notification->id)->update(['is_read' => NOTIFICATION_READ]);
            }
        }
    }

    public function getUnreadNotificationCount($userId)
    {
        return UserNotifications::where('user_id' , $userId)->where('is_read' , NOTIFICATION_UNREAD)->count();
    }

    public function makeAllNotificationsAsRead($userId)
    {
        return UserNotifications::where('user_id' , $userId)->update(['is_read' => NOTIFICATION_READ]);
    }
}
