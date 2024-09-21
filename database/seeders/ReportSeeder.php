<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 一件だけinsertする
        DB::table('reports')->insert([
    'image' => 'images/mekabu_favicon.png',
    'shop' => 'ABCD商店',
    'email' => 'testtest@gmail.com',
    'postal_code' => '029-4100',
    'address' => '岩手県西磐井郡平泉町1-1-1',
    'map_url' => 'https://www.google.com/intl/ja_jp/business/',
]);
    }
}
