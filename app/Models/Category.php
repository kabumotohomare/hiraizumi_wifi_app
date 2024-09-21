<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // テーブル名が 'categories' であることを指定

    // 必要に応じてfillableやhidden、リレーションを追加
    protected $fillable = [
        'category_name',
        'reservation_flag',
        'display_flag',
        'color_code',
        'sort_order',
    ];
}
