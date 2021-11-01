<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $notifications = [
            ['1','Message received'],
            ['2','Trade started'],
            ['3','Trade funded'],
            ['4','Trade cancelled'],
            ['5','Trade completed'],
            ['6','Positive feedback received'],
            ['7','Negative feedback received'],
            ['8','Crpto transferred'],
            ['9', 'Dispute initiated']
        ];

        foreach($notifications as $key=>$value){
            $notificationInsert = [
                'id' => $value[0],
                'name' => $value[1],
            ];
            DB::table('notifications')->insert($notificationInsert);
        }
    }
}
