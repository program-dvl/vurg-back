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
            ['1','darshan','prajapati','darshan2593@yahoo.com','123456789', 'darshan'],
            ['2','darshan','prajapati','sam.love9093@gmail.com','123456789', 'sam'],
            ['3','dhaval','prajapati','dhaval.prajapati@vurg.com','123456789', 'dhaval'],
            ['4','test','prajapati','test.prajapati@vurg.com','123456789', 'test'],
            ['5','test1','prajapati','test1.prajapati@vurg.com','123456789', 'test1'],
            ['6','test2','prajapati','test2.prajapati@vurg.com','123456789', 'test2'],
            ['7','test3','prajapati','test3.prajapati@vurg.com','123456789', 'test3'],
            ['8','test4','prajapati','test4.prajapati@vurg.com','123456789', 'test4'],
        ];

        foreach($users as $key=>$value){
            $userInsert = [
                'id' => $value[0],
                'firstname' => $value[1],
                'lastname' => $value[2],
                'email' => $value[3],
                'password' => Hash::make($value[4]),
                'username' => $value[5]
            ];
            DB::table('users')->insert($userInsert);
        }
    }
}
