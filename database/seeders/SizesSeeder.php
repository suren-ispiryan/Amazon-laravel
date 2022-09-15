<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([[
            'size' => 'Extra small',
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ],[
            'size' => 'Small',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'size' => 'Medium',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'size' => 'Large',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'size' => 'Extra large',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
    }
}
