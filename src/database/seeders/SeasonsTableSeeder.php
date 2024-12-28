<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seasons')->insert([
            ['name' => '春', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '夏', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '秋', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '冬', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
