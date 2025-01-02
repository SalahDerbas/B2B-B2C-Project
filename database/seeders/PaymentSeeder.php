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
            ['name' => 'Stripe',           'status' => true  , 'photo' => env('APP_URL').'/Payment/Stripe.png'  , 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'Visa Credit Card', 'status' => true  , 'photo' => env('APP_URL').'/Payment/Visa.png'    , 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'Zain Cash',        'status' => true  , 'photo' => env('APP_URL').'/Payment/ZainCash.png', 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'B2B User',         'status' => true  , 'photo' => NULL                                  , 'created_at' => now(), 'updated_at'  => now() ],
        ]);
    }
}
