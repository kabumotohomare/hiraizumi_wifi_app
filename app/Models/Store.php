<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores'; // テーブル名が 'stores' であることを指定

    // 必要に応じてfillableやhidden、リレーションを追加
    protected $fillable = [
        'name',
        'postal_code',
        'address',
        'lat',
        'lng',
        'email',
        'link',
        'category_id',
        'phone',
        'approval_flag',
        'display_flag',
    ];

    // カテゴリとのリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
