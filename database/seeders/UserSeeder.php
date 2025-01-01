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
                'name'              => 'salahdrbas'                 ,
                'email'             => 'salahdrbas1@gmail.com'      ,
                'type'              => 1                            ,
                'password'          => Hash::make('salah@@123')     ,
                'email_verified_at' => Carbon::now()                ,
                'created_at'        => Carbon::now()                ,
                'updated_at'        => Carbon::now()                ,
            ] ,
            [
                'name'              => 'b2c'                        ,
                'email'             => 'b2c@gmail.com'              ,
                'type'              => 1                            ,
                'password'          => Hash::make('b2c@@123')       ,
                'email_verified_at' => Carbon::now()                ,
                'created_at'        => Carbon::now()                ,
                'updated_at'        => Carbon::now()                ,
            ] ,
            [
                'name'              => 'b2b'                        ,
                'email'             => 'b2b@gmail.com'              ,
                'type'              => 2                            ,
                'password'          => Hash::make('b2b@@123')       ,
                'email_verified_at' => Carbon::now()                ,
                'created_at'        => Carbon::now()                ,
                'updated_at'        => Carbon::now()                ,
            ]
        ]);
    }
}
