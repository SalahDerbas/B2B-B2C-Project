<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['local' , 'global'];
        foreach ($types as $type) {
            $this->seedItemsByType($type);
        }

        $this->updateAndDeleteCategories();
    }


    private function seedItemsByType($type)
    {
        $sub_category_id = ($type === 'global') ? 2 : 1;
        $source_id       = 1;
        $payment_id      = 1;

        $url  = env('AIRALO_URL') . env('AIRALO_VERSION') . '/packages?filter[type]=' . $type . '&limit=5000';

        $response = Http::withHeaders(['Authorization' => 'Bearer ' . env('AIRALO_AUTHORIZATION') ])->get($url);

        if ($response->failed()) {
            $this->command->error('Failed to fetch data from the source.');
            return;
        }

        $datas = $response->json('data');

        foreach ($datas as $data) {
            $category_id = DB::table('categories')->insertGetId([
                'name'            => $data['title'],
                'status'          => True,
                'sub_category_id' => $sub_category_id,
                'description'     => $data['operators'][0]['title'],
                'photo'           => $data['image']['url'],
                'cover'           => $data['operators'][0]['image']['url'],
                'color'           => $data['operators'][0]['gradient_start'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $plan_type = $data['operators'][0]['plan_type'];

            $coverages = array_map(function ($country) {
                return [
                    'country_code' => $country['name'],
                    'networks'     => array_map(function ($network) {
                        return ['name' => $network['name']];
                    }, $country['networks']),
                ];
            }, $data['operators'][0]['coverages']);
            $coverages = json_encode($coverages);

            foreach ($data['operators'][0]['packages'] as $package) {
                $item_id = DB::table('items')->insertGetId([
                    'capacity'         => $package['data'],
                    'plan_type'        => $plan_type,
                    'coverages'        => $coverages,
                    'validaty'         => $package['day'] . ' Days',
                    'sub_category_id'  => $category_id,
                    'status'           => True,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                $item_source_id = DB::table('item_sources')->insertGetId([
                    'item_id'       => $item_id,
                    'package_id'    => $package['id'],
                    'source_id'     => $source_id,
                    'status'        => True,
                    'cost_price'    => $package['net_price'],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                $operators = DB::table('operators')->where('payment_id', $payment_id)->get();
                $final_price = (float) $package['net_price'];
                foreach ($operators as $operator) {
                    $final_price += ($operator->type_id == 1) ? ($operator->value) : ($operator->value * $final_price);
                }

                DB::table('payment_prices')->insert([
                    'item_source_id' => $item_source_id,
                    'payment_id'     => $payment_id,
                    'final_price'    => $final_price,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        $this->command->info("Data successfully seeded for type: $type");
    }


    private function updateAndDeleteCategories()
    {
        // Update items for global
        DB::statement('UPDATE items SET sub_category_id = 3 WHERE sub_category_id = (SELECT id FROM categories WHERE `name` = "World")');

        // Delete category where name is World
        DB::table('categories')->where('name', 'World')->delete();

        $this->command->info('Updated items and deleted the "World" category.');
    }
}
