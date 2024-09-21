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
            'mail' => 'testtest@gmail.com',
            'postal_code' => '029-4100',
            'address' => '岩手県西磐井郡平泉町1-1-1',
            'map_url' => 'https://www.google.com/maps/place/%E5%B9%B3%E6%B3%89%E7%94%BA%E5%BD%B9%E5%A0%B4/@38.9866243,141.1138986,15z/data=!4m6!3m5!1s0x5f88ce10b21f96b1:0x84e25b1fbe991e7!8m2!3d38.9866243!4d141.1138986!16s%2Fg%2F1tdqh8mm?entry=ttu&g_ep=EgoyMDI0MDkxNS4wIKXMDSoASAFQAw%3D%3D',
        ]);
    }
}
