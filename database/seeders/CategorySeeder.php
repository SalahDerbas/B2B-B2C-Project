<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([

            ['name' => 'Local',    'description' => 'Local Plans',           'sub_category_id' => NULL  , 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'Regional', 'description' => 'Regional Plans',        'sub_category_id' => NULL  , 'created_at' => now(), 'updated_at'  => now() ],
            ['name' => 'Global',   'description' => 'Global Plans',          'sub_category_id' => NULL  , 'created_at' => now(), 'updated_at'  => now() ],

        ]);
    }
}
