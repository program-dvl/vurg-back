<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['1','3','1','1','56', '2', '1', '7', '0', '5', '10', '30', 'Offer Label 1 Lorem Ipsum', 'Offer terms 1 Lorem Ipsum', 'trade instruction Lorem Ipsum', '1', null, null,'0', '0', '1'],
            ['2','3','1','1','24', '3', '1', '10', '0', '15', '17', '60', 'Offer Label 2 Lorem Ipsum', 'Offer terms 2 Lorem Ipsum', 'trade instruction Lorem Ipsum', '0', null, null, '0', '0', '1'],
            ['3','3','1','1','56', '7', '2', '0', '123456', '5', '5', '30', 'Offer Label 3 Lorem Ipsum', 'Offer terms 3 Lorem Ipsum', 'trade instruction Lorem Ipsum', '1', null, null, '0', '0', '1'],
            ['4','3','1','2','56', '2', '1', '7', '0', '5', '10', '30', 'Offer Label 1 Lorem Ipsum', 'Offer terms 1 Lorem Ipsum', 'trade instruction Lorem Ipsum', '1', null, null, '0', '0', '1'],
            ['5','3','1','2','24', '3', '1', '10', '0', '15', '17', '60', 'Offer Label 2 Lorem Ipsum', 'Offer terms 2 Lorem Ipsum', 'trade instruction Lorem Ipsum', '0', null,null, '0', '0', '1'],
            ['6','3','1','2','56', '7', '2', '0', '123456', '5', '5', '30', 'Offer Label 3 Lorem Ipsum', 'Offer terms 3 Lorem Ipsum', 'trade instruction Lorem Ipsum', '1', null,null, '0', '0', '1'],
        ];

        foreach($users as $key=>$value){
            $userInsert = [
                'id' => $value[0],
                'user_id' => $value[1],
                'cryptocurreny_type' => $value[2],
                'offer_type' => $value[3],
                'payment_method' => $value[4],
                'preferred_currency' => $value[5],
                'trade_price_type' => $value[6],
                'offer_margin_percentage' => $value[7],
                'offer_margin_fixed_price' => $value[8],
                'minimum_offer_trade_limits' => $value[9],
                'maximum_offer_trade_limits' => $value[10],
                'offer_time_limit' => $value[11],
                'offer_label' => $value[12],
                'offer_terms' => $value[13],
                'trade_instruction' => $value[14],
                'require_verified_id' => $value[15],
                'target_country' => $value[16],
                'offer_visibility' => $value[17],
                'minimum_trade_required' => $value[18],
                'limit_for_new_users' => $value[19],
                'status' => $value[20],
            ];
            DB::table('offers')->insert($userInsert);
        }


        $offerTagsInsertArray = [
            [1, 1, 5],
            [2, 1, 2],
            [3, 1, 7],
            [4, 1, 9],
            [5, 1, 10],
            [6, 3, 1],
            [7, 3, 5],
            [8, 2, 11],
            [9, 4, 13],
            [10, 4, 14],
            [11, 4, 15],
            [12, 4, 16],
            [13, 6, 9],
            [14, 6, 12],
            [15, 6, 19],
        ];

        foreach($offerTagsInsertArray as $key=>$value){
            $userInsert = [
                'id' => $value[0],
                'offer_id' => $value[1],
                'offer_tag_id' => $value[2],
            ];
            DB::table('user_offer_tags')->insert($userInsert);
        }

    }
}
