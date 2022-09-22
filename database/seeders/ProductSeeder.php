<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([[
            'user_id' => 1,
            'name' => 'Car',
            'description' => 'Beautiful car 2020 year',
            'brand' => 'Toyota',
            'price' => 1000,
            'in_stock' => 10,
            'color' => '#d24646',
            'size' => 'Small',
            'published' => 1,
            'category' => 'Cars',
            'subcategory' => 'Cars',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'user_id' => 2,
            'name' => 'Knife',
            'description' => 'Beautiful knife very sharp',
            'brand' => 'Blade',
            'price' => 10,
            'in_stock' => 100,
            'color' => '#d24646',
            'size' => 'Medium',
            'published' => 0,
            'category' => 'Home',
            'subcategory' => 'Home',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'user_id' => 1,
            'name' => 'Car',
            'description' => 'Beautiful car 2021 year',
            'brand' => 'Bentley',
            'price' => 9000,
            'in_stock' => 10,
            'color' => '#d24646',
            'size' => 'Large',
            'published' => 0,
            'category' => 'Cars',
            'subcategory' => 'Cars',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'user_id' => 3,
            'name' => 'Clothes',
            'description' => 'Beautiful boots 2021 year',
            'brand' => 'x-tep',
            'price' => 160,
            'in_stock' => 10,
            'color' => '#d24646',
            'size' => 'Extra large',
            'published' => 1,
            'category' => 'Cars',
            'subcategory' => 'Cars',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'user_id' => 3,
            'name' => 'Harry Potter',
            'description' => 'Interesting book 2021 year',
            'brand' => 'Fantasy',
            'price' => 100,
            'in_stock' => 100,
            'color' => '#d24646',
            'size' => 'Small',
            'published' => 1,
            'category' => 'Books',
            'subcategory' => 'Books',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
    }
}
