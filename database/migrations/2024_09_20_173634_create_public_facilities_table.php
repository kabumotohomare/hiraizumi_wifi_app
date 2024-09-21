<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicFacilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('public_facilities', function (Blueprint $table) {
            $table->id();  // 自動インクリメントID
            $table->string('name');  // 施設名
            $table->string('address');  // 住所
            $table->string('phone')->nullable();  // 電話番号 (nullableに設定)
            $table->boolean('reservation_flag')->default(false);  // 予約可否フラグ
            $table->decimal('lat', 10, 7)->nullable();  // 緯度 (10桁中7桁を小数点以下に)
            $table->decimal('lng', 10, 7)->nullable();  // 経度 (10桁中7桁を小数点以下に)
            $table->string('postal_code', 8)->nullable();  // 郵便番号
            $table->boolean('display_flag')->default(true);  // 表示フラグ
            $table->timestamps();  // 作成・更新日時
        });
    }

    public function down()
    {
        Schema::dropIfExists('public_facilities');
    }
}
