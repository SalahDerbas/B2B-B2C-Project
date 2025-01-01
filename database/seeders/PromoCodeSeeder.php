<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promo_codes')->delete();

        DB::table('promo_codes')->insert([
            ['promo_code' => 'RAMADAN' , 'description' => 'This is description' , 'from_date' => '2024-05-01 00:00:00' , 'to_date' => '2024-06-30 00:00:00' , 'type_id' => 3 , 'limit' => 100 , 'user_limit' => 1 , 'counter' => 0 , 'amount' => 1.00 , 'created_at' => now(), 'updated_at'  => now()],
        ]);

    }
}
