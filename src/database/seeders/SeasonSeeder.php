<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SeasonSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('seasons')->insert([
            ['name' => '春', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '夏', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '秋', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '冬', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
