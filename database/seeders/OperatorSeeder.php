<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('operators')->delete();

        DB::table('operators')->insert([
            [ 'name' => 'tax1',        'type_id' =>  1 , 'value' => 0.12  , 'payment_id' => 1  , 'created_at' => now(), 'updated_at'  => now() ],
            [ 'name' => 'tax2',        'type_id' =>  2 , 'value' => 0.34  , 'payment_id' => 1  , 'created_at' => now(), 'updated_at'  => now() ],

        ]);

    }
}
