<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([[
            'category' => 'Cars',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'category' => 'Home',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'category' => 'Food',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'category' => 'Clothes',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'category' => 'Books',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
    }
}
