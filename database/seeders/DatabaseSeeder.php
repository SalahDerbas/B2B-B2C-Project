<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Database\Seeders\AdminSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\LookupSeeder;
use Database\Seeders\OperatorSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\PromoCodeSeeder;
use Database\Seeders\SourceSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ItemSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LookupSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(OperatorSeeder::class);
        $this->call(PromoCodeSeeder::class);
        $this->call(SourceSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ItemSeeder::class);
    }
}
