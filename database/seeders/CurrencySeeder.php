<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            ['British Pound','GBP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Canadian Dollar','CAD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Euro','EUR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Indian Rupee','INR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Kenyan Shilling','KES','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Nigerian Naira','NGN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['US Dollar','USD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Yuan (Chinese) Renminbi','CNY','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Afghan Afghani','AFN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Albanian Lek','ALL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Algerian Dinar','DZD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Angolan Kwanza','AOA','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Argentine Peso','ARS','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Armenian Dram','AMD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Aruban Florin','AWG','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Australian Dollar','AUD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Azerbaijan Manat','AZN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bahamian Dollar','BSD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bahraini Dinar','BHD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bangladeshi Taka','BDT','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Barbadian Dollar','BBD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Belarusian Ruble','BYN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Belize Dollar','BZD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bermudian Dollar','BMD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bhutanese Ngultrum','BTN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bolivian Boliviano','BOB','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bosnia and Herzegovina Convertible Mark','BAM','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Botswana Pula','BWP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Brazilian Real','BRL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Brunei Dollar','BND','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Bulgarian Lev','BGN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['CFP Franc','XPF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Cambodian Riel','KHR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Cape Verdean Escudo','CVE','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Caymanian Dollar','KYD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Chilean peso','CLP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Colombian Peso','COP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Communauté Financière Africaine (BCEAO), Franc','XOF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Communauté Financière Africaine (BEAC), CFA Franc BEAC','XAF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Comorian Franc','KMF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Congolese Franc','CDF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Costa Rican Colon','CRC','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Croatian Kuna','HRK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Czech Republic Koruna','CZK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Danish Krone','DKK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Djiboutian Franc','DJF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Dominican Peso','DOP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Eastern Caribbean dollar','XCD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Egyptian Pound','EGP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Eritrean Nakfa','ERN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Ethiopian Birr','ETB','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Falkland Islands Pound','FKP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Fijian Dollar','FJD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Gambian Dalasi','GMD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Georgian Lari','GEL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Ghanaian Cedi','GHS','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Gibraltar Pound','GIP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Gold Ounce','XAU','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Guatemalan Quetzal','GTQ','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Guernsey Pound','GGP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Guinean Franc','GNF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Guyanese Dollar','GYD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Haitian Gourde','HTG','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Honduran Lempira','HNL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Hong Kong Dollar','HKD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Hungarian Forint','HUF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Icelandic Krona','ISK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Indonesian Rupiah','IDR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Israeli Shekel','ILS','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Jamaican Dollar','JMD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Japanese Yen','JPY','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Jersey Pound','JEP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Jordanian Dinar','JOD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Kazakhstani Tenge','KZT','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Kuwaiti Dinar','KWD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Kyrgyzstani Som','KGS','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Lao Kip','LAK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Lesotho Loti','LSL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Liberian Dollar','LRD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Macanese Pataca','MOP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Macedonian Denar','MKD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Malagasy Ariary','MGA','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Malawian Kwacha','MWK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Malaysian Ringgit','MYR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Maldivian Rufiyaa','MVR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Manx The Isle of Man Pound','IMP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Mauritanian Ouguiya','MRU','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Mauritanian Ouguiya','MRO','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Mauritian Rupee','MUR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Mexican Peso','MXN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Moldovan Leu','MDL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Mongolian Tugrik','MNT','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Moroccan Dirham','MAD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Mozambique Metical','MZN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Myanmar Kyat','MMK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Namibian Dollar','NAD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Nepalese Rupee','NPR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Netherlands Antillean Guilder','ANG','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['New Zealand Dollar','NZD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Nicaraguan Córdoba','NIO','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Norwegian Krone','NOK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Omani Rial','OMR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Pakistan Rupee','PKR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Palladium Ounce','XPD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Panamanian Balboa','PAB','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Papua New Guinean Kina','PGK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Paraguay Guarani','PYG','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Peruvian Sol','PEN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Philippine Peso','PHP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Platinum Ounce','XPT','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Polish Zloty','PLN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Qatari Rial','QAR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Romanian Leu','RON','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Russian Ruble','RUB','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Rwandan Franc','RWF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Salvadoran Colon','SVC','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Samoan Tala','WST','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Sao Tome and Principe Dobra','STD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Sao Tome and Principe Dobra','STN','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Saudi Arabian Riyal','SAR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Serbian Dinar','RSD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Seychelles Rupee','SCR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Sierra Leone Leone','SLL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Silver Ounce','XAG','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Singapore Dollar','SAD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Solomon Islands Dollar','SBD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['South African Rand','ZAR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['South Korean Won','KRW','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Sri Lanka Rupee','LKR','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['St. Helena Pound','SHP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Surinamese Dollar','SRD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Swazi Lilangeni','SZL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Swedish Krona','SEK','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Swiss Franc','CHF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Taiwan Dollar','TWD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Tajikistani Somoni','TJS','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Tanzanian Shilling','TZS','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Thai Baht','THB','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Tongan Pa\'anga','TOP','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Trinidad and Tobago Dollar','TTD','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Tunisian Dinar','TND','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Turkish Lira','TRY','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Turkmenistan Manat','TMT','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Uganda Shilling','UGX','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Ukrainian Hryvnia','UAH','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Unidad de Fomento','CLF','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['United Arab Emirates Dirham','AED','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Uruguayan Peso','UYU','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Uzbekistani Som','UZS','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Vanuatu Vatu','VUV','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Vietnamese Dong','VND','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Yemeni Rial','YER','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Zambian Kwacha','ZMW','2021-08-17 21:20:14','2021-08-17 21:20:14'],
            ['Zimbabwean Dollar','ZWL','2021-08-17 21:20:14','2021-08-17 21:20:14'],
        ];

        foreach($currencies as $value){
            $currencyInsert = [
                'currency_name' => $value[0],
                'currency_code' => $value[1],
                'created_at' => $value[2],
                'updated_at' => $value[3],
            ];
            DB::table('currencies')->insert($currencyInsert);
        }
    }
}
