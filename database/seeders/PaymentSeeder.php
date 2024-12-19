<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->delete();

        DB::table('payments')->insert([
            ['name' => 'Visa Credit Card', 'status' => true  , 'photo' => env('APP_URL').'/Payment/Visa.png'],
            ['name' => 'Zain Cash',        'status' => true  , 'photo' => env('APP_URL').'/Payment/ZainCash.png'],
        ]);
    }
}
