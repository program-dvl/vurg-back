<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\Notification\NotificationRepository;
use App\Models\ContactUs;
use Illuminate\Http\Response;
use Validator;
use Mail;

class NotificationController extends Controller
{
    public function __construct(Request $request, NotificationRepository $notificationRepository) {
        $this->request = $request;
        $this->notificationRepository = $notificationRepository;
    }

    public function getAllNotifications(Request $request) {
        try {
            $input = $request->all();
            $rules = [
                'page_number' => 'required|numeric|min:1',
                'per_page' => 'required|numeric|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $skip = ($input['page_number'] - 1) * $input['per_page'];
            $take = $input['per_page'];

            $userId = Auth::id();
            $notifications = $this->notificationRepository->getNotificationDetails($userId, $skip, $take);

            $this->notificationRepository->updateNotificationDetails($userId, $skip, $take);
            return $this->sendSuccess($notifications, 'Notification fetched successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }

    public function getUnreadNotificationCount(Request $request) {
        $userId = Auth::id();
        $data['unread_count'] = $this->notificationRepository->getUnreadNotificationCount($userId);
        return $this->sendSuccess($data, 'Unread notification count fetch successfully');
    }

    public function markAsReadNotifications(Request $request) {
        $userId = Auth::id();
        $this->notificationRepository->makeAllNotificationsAsRead($userId);
        return $this->sendSuccess($data = [], 'Unread notification count fetch successfully');
    }
    
}
