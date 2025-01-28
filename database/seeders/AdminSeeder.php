<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert([
            [
                'username'        => 'Salah Admin'                     ,
                'email'           => 'salah.admin@sd-softwares.com'    ,
                'password'        => Hash::make('Sal123@@')            ,
                'status'          => True                              ,
                'created_at'      => Carbon::now()                     ,
                'updated_at'      => Carbon::now()                     ,
            ]
        ]);
    }
}
