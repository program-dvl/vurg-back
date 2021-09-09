<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OfferFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [1,1,3,1,1,0,"best deal"],
            [2,1,3,2,1,0,"Awesome"],
            [3,2,3,1,0,1,"costly"],
            [4,2,3,2,1,0,"Awesome"],
            [5,3,3,1,1,0,"best deal"],
            [6,3,3,2,1,0,"Awesome"],
            [7,4,1,3,0,1,"Time interval should be more"],
            [8,4,2,3,1,0,"Awesome buy price"],
            [9,4,4,3,0,1,""],
            [10,4,5,3,0,1,""],
            [11,1,3,8,1,0,"best deal"],
            [12,1,3,7,0,1,""],
            [13,1,3,6,1,0,""],
            [14,1,3,5,1,0,"Fabulous"],
        ];

        foreach($users as $key=>$value){
            $userInsert = [
                'id' => $value[0],
                'offer_id' => $value[1],
                'from_buyer' => $value[2],
                'from_seller' => $value[3],
                'positive' => $value[4],
                'negative' => $value[5],
                'comment' => $value[6]
            ];
            DB::table('offer_trade_feedback')->insert($userInsert);
        }
    }
}
