<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['Bitcoin price change', 'Get notified when the price of bitcoin changes by 5% or more. You will be notified only once a day.'],
            ['Buyer started uploading cards', ''],
            ['Cryptocurrency deposit confirmed', ''],
            ['Cryptocurrency deposit pending', ''],
            ['Cryptocurrency purchased', ''],
            ['Cryptocurrency sent', ''],
            ['Cryptocurrency sold', ''],
            ['Funds reserved for trade', ''],
            ['Incoming trade', ''],
            ['New chat message', ''],
            ['New moderator message', ''],
            ['Partner paid for trade', ''],
            ['Someone viewed my profile', ''],
            ['Tether price change', 'Get notified when the price of tether changes by 5% or more. You will be notified only once a day.'],
            ['Trade cancelled/expired', ''],
            ['Play notification sound for new messages and trades', ''],
            ['Receive important emails from us occasionally', ''],
            ['Receive SMS notification for confirmed cryptocurrency deposits', 'Setting up SMS notifications will automatically turn off in-app notifications on your mobile device'],
        ];

        foreach($settings as $key=>$value){
            $settingInsert = [
                'setting_name' => $value[0],
                'setting_description' => $value[1]
            ];
            DB::table('settings')->insert($settingInsert);
        }
    }
}
