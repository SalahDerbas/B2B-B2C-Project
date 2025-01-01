<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sources')->delete();

        DB::table('sources')->insert([
            ['name' => 'Airalo' , 'photo' => env('APP_URL').'/Source/Airalo.png', 'created_at' => now(), 'updated_at'  => now()],
        ]);

    }
}
