<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'usrename'          => 'salahdrbas'                 ,
                'name'              => 'salahdrbas'                 ,
                'email'             => 'salahdrbas1@gmail.com'      ,
                'type'              => 1                            ,
                'payment_id'        => NULL                         ,
                'client_id'         => NULL                         ,
                'client_secret'     => NULL                         ,
                'password'          => Hash::make('salah@@123')     ,
                'email_verified_at' => Carbon::now()                ,
                'created_at'        => Carbon::now()                ,
                'updated_at'        => Carbon::now()                ,
            ] ,
            [
                'usrename'          => 'b2c'                        ,
                'name'              => 'b2c'                        ,
                'email'             => 'b2c@gmail.com'              ,
                'type'              => 1                            ,
                'payment_id'        => NULL                         ,
                'client_id'         => NULL                         ,
                'client_secret'     => NULL                         ,
                'password'          => Hash::make('b2c@@123')       ,
                'email_verified_at' => Carbon::now()                ,
                'created_at'        => Carbon::now()                ,
                'updated_at'        => Carbon::now()                ,
            ] ,
            [
                'usrename'          => 'b2b'                        ,
                'name'              => 'b2b'                        ,
                'email'             => 'b2b@gmail.com'              ,
                'type'              => 2                            ,
                'payment_id'        => 4                            ,
                'client_id'         => rand(1000000000,10000000000) ,
                'client_secret'     => generateString(150)          ,
                'password'          => Hash::make('b2b@@123')       ,
                'email_verified_at' => Carbon::now()                ,
                'created_at'        => Carbon::now()                ,
                'updated_at'        => Carbon::now()                ,
            ]
        ]);
    }
}
