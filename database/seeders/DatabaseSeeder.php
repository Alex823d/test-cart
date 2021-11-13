<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $products = array(
            ['title' => 'produqti 1','user_id'=> 10,'price' => 10],
            ['title' => 'produqti 2','user_id'=> 10,'price' => 15],
            ['title' => 'produqti 3 ','user_id'=> 10,'price' => 8],
            ['title' => 'produqti 4','user_id'=> 10,'price' => 7],
            ['title' => 'produqti 5','user_id'=> 10,'price' => 20],
        );
        // \App\Models\User::factory(10)->create();
        DB::table('products')->insert($products);

        $cart = array(
            ['user_id' => 15,'product_id'=> 2,'quantity' => 3],
            ['user_id' => 15,'product_id'=> 5,'quantity' => 2],
            ['user_id' => 15,'product_id'=> 1,'quantity' => 1],

        );
        // \App\Models\User::factory(10)->create();
        DB::table('cart')->insert($cart);

        $groups = array(
            ['user_id' => 10,'discount' => 15],


        );
        // \App\Models\User::factory(10)->create();
        DB::table('user_product_groups')->insert($groups);

        $items = array(
            ['group_id' => 1,'product_id' => 2],
            ['group_id' => 1,'product_id' => 5],


        );
        // \App\Models\User::factory(10)->create();
        DB::table('product_group_items')->insert($items);

    }
}
