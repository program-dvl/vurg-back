<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();        
        $this->call([
            UserSeeder::class,
            TimezoneSeeder::class,
            CurrencySeeder::class,
            CountrySeeder::class,
            SettingSeeder::class,
            OfferTagsSeeder::class,
            PaymentMethodCategorySeeder::class,
            PaymentMethodsSeeder::class,
            OfferSeeder::class,
            OfferFeedbackSeeder::class
        ]);
    }
}
