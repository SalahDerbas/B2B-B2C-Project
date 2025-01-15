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
            ['name' => 'Stripe',           'is_b2b' => false , 'status' => true  , 'photo' => env('APP_URL').'assets/Payment/Stripe.png'  , 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'Visa Credit Card', 'is_b2b' => false , 'status' => true  , 'photo' => env('APP_URL').'assets/Payment/Visa.png'    , 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'Zain Cash',        'is_b2b' => false , 'status' => true  , 'photo' => env('APP_URL').'assets/Payment/ZainCash.png', 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'B2B User',         'is_b2b' => true  , 'status' => true  , 'photo' => NULL                                       , 'created_at' => now(), 'updated_at'  => now() ],
        ]);
    }
}
