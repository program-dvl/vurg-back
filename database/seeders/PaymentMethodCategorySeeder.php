<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethodyCategories = [
            ['1','Online Wallets','1'],
            ['2','Bank Transfers','1'],
            ['3','Gift Cards','1'],
            ['4','Cash Payments','1'],
            ['5','Debit/Credit Cards','1'],
            ['6','Digital Currencies','1'],
            ['7','Goods & Services','1']
        ];

        foreach($paymentMethodyCategories as $key=>$value){
            $categoryInsert = [
                'id' => $value[0],
                'name' => $value[1],
                'is_active'=> $value[2]
            ];
            DB::table('payment_method_category')->insert($categoryInsert);
        }
    }
}
