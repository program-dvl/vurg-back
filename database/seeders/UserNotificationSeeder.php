<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userNotifications = [
            ['1', '1', 'New trade message from Darshan'],
            ['2', '1', 'New trade message from Test'],
            ['3', '2', 'You started trade_id trade'],
            ['4', '2', 'Darshan started trade_id trade'],
            ['5', '3', 'Trade trade_id funded now'],
            ['6', '3', 'Trade trade_id funded now'],
            ['7', '4', 'Trade trade_id expired'],
            ['8', '4', 'Trade trade_id expired'],
            ['9', '5', 'Success! You bought 0.00007247 BTC'],
            ['10', '5', 'Success! You bought 0.00009111 BTC'],
            ['11', '6', 'Darshan has left you positive feedback'],
            ['12', '6', 'Test has left you positive feedback'],
            ['13', '7', 'Darshan has left you negative feedback'],
            ['14', '7', 'Test has left you negative feedback'],
            ['15', '8', '0.00009902 BTC queued to send out'],
            ['16', '9', 'Dispute started against you by Darshan in trade trade_id']
        ];

        foreach($userNotifications as $key=>$value){
            $notificationInsert = [
                'id' => $value[0],
                'user_id' => 3,
                'notification_id' => $value[1],
                'notification_text' => $value[2],
                'is_read' => 0,
                'created_at' => Carbon::now()
            ];
            DB::table('user_notifications')->insert($notificationInsert);
        }
    }
}
