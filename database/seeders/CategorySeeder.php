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

            ['name' => 'Local Plans',               'sub_category_id' => NULL ],
            ['name' => 'Regional Plans',            'sub_category_id' => NULL ],
            ['name' => 'Global Plans',              'sub_category_id' => NULL ],

            ['name' => 'Palestine',                 'sub_category_id' => 1    ],
            ['name' => 'Syria',                     'sub_category_id' => 1    ],
            ['name' => 'France',                    'sub_category_id' => 1    ],
            ['name' => 'Jordan',                    'sub_category_id' => 1    ],
            ['name' => 'United States of America',  'sub_category_id' => 1    ],

            ['name' => 'Europe',                    'sub_category_id' => 2    ],
            ['name' => 'Asia',                      'sub_category_id' => 2    ],
            ['name' => 'Australia',                 'sub_category_id' => 2    ],
            ['name' => 'Middle East',               'sub_category_id' => 2    ],

        ]);
    }
}
