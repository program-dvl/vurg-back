<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezones = [
            ['Africa/Abidjan','(GMT) Monrovia, Reykjavik','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Africa/Addis_Ababa','(GMT+03:00) Nairobi','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Africa/Algiers','(GMT+01:00) West Central Africa','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Africa/Blantyre','(GMT+02:00) Harare, Pretoria','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Africa/Cairo','(GMT+02:00) Cairo','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Africa/Windhoek','(GMT+01:00) Windhoek','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Adak','(GMT-10:00) Hawaii-Aleutian','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Anchorage','(GMT-09:00) Alaska','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Araguaina','(GMT-03:00) UTC-3','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Argentina/Buenos_Aires','(GMT-03:00) Buenos Aires','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Belize','(GMT-06:00) Saskatchewan, Central America','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Bogota','(GMT-05:00) Bogota, Lima, Quito, Rio Branco','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Campo_Grande','(GMT-04:00) Campo Grande','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Cancun','(GMT-06:00) Guadalajara, Mexico City, Monterrey','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Caracas','(GMT-04:30) Caracas','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Chicago','(GMT-06:00) Central Time (US & Canada)','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Chihuahua','(GMT-07:00) Chihuahua, La Paz, Mazatlan','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Dawson_Creek','(GMT-07:00) Arizona','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Denver','(GMT-07:00) Mountain Time (US & Canada)','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Ensenada','(GMT-08:00) Tijuana, Baja California','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Glace_Bay','(GMT-04:00) Atlantic Time (Canada)','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Godthab','(GMT-03:00) Greenland','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Goose_Bay','(GMT-04:00) Atlantic Time (Goose Bay)','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Havana','(GMT-05:00) Cuba','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/La_Paz','(GMT-04:00) La Paz','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Los_Angeles','(GMT-08:00) Pacific Time (US & Canada)','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Miquelon','(GMT-03:00) Miquelon, St. Pierre','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Montevideo','(GMT-03:00) Montevideo','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/New_York','(GMT-05:00) Eastern Time (US & Canada)','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Noronha','(GMT-02:00) Mid-Atlantic','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Santiago','(GMT-04:00) Santiago','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/Sao_Paulo\" selected=\"','(GMT-03:00) Brasilia','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['America/St_Johns','(GMT-03:30) Newfoundland','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Anadyr','(GMT+12:00) Anadyr, Kamchatka','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Bangkok','(GMT+07:00) Bangkok, Hanoi, Jakarta','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Beirut','(GMT+02:00) Beirut','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Damascus','(GMT+02:00) Syria','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Dhaka','(GMT+06:00) Astana, Dhaka','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Dubai','(GMT+04:00) Abu Dhabi, Muscat','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Gaza','(GMT+02:00) Gaza','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Hong_Kong','(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Irkutsk','(GMT+08:00) Irkutsk, Ulaan Bataar','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Jerusalem','(GMT+02:00) Jerusalem','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Kabul','(GMT+04:30) Kabul','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Katmandu','(GMT+05:45) Kathmandu','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Kolkata','(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Krasnoyarsk','(GMT+07:00) Krasnoyarsk','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Magadan','(GMT+11:00) Magadan','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Novosibirsk','(GMT+06:00) Novosibirsk','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Rangoon','(GMT+06:30) Yangon (Rangoon)','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Seoul','(GMT+09:00) Seoul','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Tashkent','(GMT+05:00) Tashkent','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Tehran','(GMT+03:30) Tehran','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Tokyo','(GMT+09:00) Osaka, Sapporo, Tokyo','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Vladivostok','(GMT+10:00) Vladivostok','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Yakutsk','(GMT+09:00) Yakutsk','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Yekaterinburg','(GMT+05:00) Ekaterinburg','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Asia/Yerevan','(GMT+04:00) Yerevan','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Atlantic/Azores','(GMT-01:00) Azores','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Atlantic/Cape_Verde','(GMT-01:00) Cape Verde Is.','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Atlantic/Stanley','(GMT-04:00) Faukland Islands','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Australia/Adelaide','(GMT+09:30) Adelaide','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Australia/Brisbane','(GMT+10:00) Brisbane','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Australia/Darwin','(GMT+09:30) Darwin','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Australia/Eucla','(GMT+08:45) Eucla','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Australia/Hobart','(GMT+10:00) Hobart','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Australia/Lord_Howe','(GMT+10:30) Lord Howe Island','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Australia/Perth','(GMT+08:00) Perth','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Chile/EasterIsland','(GMT-06:00) Easter Island','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Etc/GMT-11','(GMT+11:00) Solomon Is., New Caledonia','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Etc/GMT-12','(GMT+12:00) Fiji, Kamchatka, Marshall Is.','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Etc/GMT+10','(GMT-10:00) Hawaii','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Etc/GMT+8','(GMT-08:00) Pitcairn Islands','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Amsterdam','(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Belfast','(GMT) Greenwich Mean Time : Belfast','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Belgrade','(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Brussels','(GMT+01:00) Brussels, Copenhagen, Madrid, Paris','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Dublin','(GMT) Greenwich Mean Time : Dublin','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Lisbon','(GMT) Greenwich Mean Time : Lisbon','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/London','(GMT) Greenwich Mean Time : London','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Minsk','(GMT+02:00) Minsk','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Europe/Moscow','(GMT+03:00) Moscow, St. Petersburg, Volgograd','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Auckland','(GMT+12:00) Auckland, Wellington','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Chatham','(GMT+12:45) Chatham Islands','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Gambier','(GMT-09:00) Gambier Islands','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Kiritimati','(GMT+14:00) Kiritimati','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Marquesas','(GMT-09:30) Marquesas Islands','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Midway','(GMT-11:00) Midway Island, Samoa','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Norfolk','(GMT+11:30) Norfolk Island','2017-09-28 21:20:14','2017-09-28 21:20:14'],
            ['Pacific/Tongatapu','(GMT+13:00) Nuku\'alofa','2017-09-28 21:20:14','2017-09-28 21:20:14']
        ];

        foreach($timezones as $key=>$value){
            $timezoneInsert = [
                'country' => $value[0],
                'timezone' => $value[1],
                'created_at' => $value[2],
                'updated_at' => $value[3],
            ];
            DB::table('timezones')->insert($timezoneInsert);
        }
    }
}
