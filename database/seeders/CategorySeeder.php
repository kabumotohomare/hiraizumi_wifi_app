<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Storeテーブルのリセット（外部キー制約があるためdeleteを使用）
        Store::query()->delete();

        // Categoryテーブルのリセット（外部キー制約があるためdeleteを使用）
        Category::query()->delete();

        $categories = [
            ['name' => '寺院・世界遺産', 'color_code' => '#FF5733'],
            ['name' => '博物館', 'color_code' => '#33FF57'],
            ['name' => '観光案内所', 'color_code' => '#5733FF'],
            ['name' => '史跡', 'color_code' => '#FFC300'],
            ['name' => '和食', 'color_code' => '#33FFF6'],
            ['name' => 'カフェ・軽食', 'color_code' => '#F633FF'],
            ['name' => '居酒屋', 'color_code' => '#FF33A8'],
            ['name' => 'レストラン', 'color_code' => '#A833FF'],
            ['name' => 'ホテル', 'color_code' => '#3377FF'],
            ['name' => '温泉宿', 'color_code' => '#FF8C33'],
            ['name' => '旅館', 'color_code' => '#FF3333'],
            ['name' => '温泉ホテル', 'color_code' => '#33FF8C'],
            ['name' => 'スーパーマーケット', 'color_code' => '#FF3333'],
            ['name' => '農産物直売所', 'color_code' => '#8C33FF'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category['name'],
                'color_code' => $category['color_code'],
            ]);
        }
    }
}
