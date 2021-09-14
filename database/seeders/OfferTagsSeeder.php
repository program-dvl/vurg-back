<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offerTags = [
            ['1','friends and family','Payment will be made by friends and family paypal payment','1'],
            ['2','invoices are accepted','Get your invoice paid','1'],
            ['3','with receipt','Gift cards have receipt for a trade','1'],
            ['4','external payment','You may be navigated to an external website such as a payment gateway.','1'],
            ['5','without receipt','Gift cards have no receipts for a trade','1'],
            ['6','no receipt needed','Receipt not required for this trade.','1'],
            ['7','physical cards only','Only physical cards accepted.','1'],
            ['8','pin required','PIN required for gift card.','1'],
            ['9','online payments','Online payments accepted for this trade.','1'],
            ['10','e-gift cards only','Not a physical gift card. To be used for online purchases or redeemed via mobile with accepting vendors.','1'],
            ['11','cash in person','For trades conducted in cash with a person.','1'],
            ['12','no verification needed','You don’t need to be a verified user to complete this trade.','1'],
            ['13','same bank only','Limit trades with users with an account in the same bank as yours.','1'],
            ['14','up to 100 face value','Maximum gift card value - 100 units','1'],
            ['15','no negotiation','Negotiation on price or payment methods violates the Paxful terms of service.','1'],
            ['16','verified paypal only','Only verified PayPal accounts accepted.','1'],
            ['17','no third parties','Payments must be made from your own account.','1'],
            ['18','photo id required','Valid government-issued photo ID required.','1'],
            ['19','cash only','Cash transaction only.','1'],
            ['20','e-codes accepted','Electronic codes are accepted for this trade.','1'],
            ['21','receipt required','You must provide transaction receipt to complete the trade.','1'],
        ];

        foreach($offerTags as $key=>$value){
            $offerInsert = [
                'id' => $value[0],
                'tag_name' => $value[1],
                'tag_description' => $value[2]                
            ];
            DB::table('offer_tags')->insert($offerInsert);
        }
    }
}
