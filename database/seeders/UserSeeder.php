<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['1','darshan','darshan2593@yahoo.com','123456789', 'darshan'],
            ['2','darshan','sam.love9093@gmail.com','123456789', 'sam'],
        ];

        foreach($users as $key=>$value){
            $userInsert = [
                'id' => $value[0],
                'name' => $value[1],
                'email' => $value[2],
                'password' => Hash::make($value[3]),
                'username' => $value[4]
            ];
            DB::table('users')->insert($userInsert);
        }
    }
}
