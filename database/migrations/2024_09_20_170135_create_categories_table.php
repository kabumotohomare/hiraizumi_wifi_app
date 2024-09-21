<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->boolean('reservation_flag')->default(false);
            $table->boolean('display_flag')->default(true);
            $table->string('color_code', 7)->nullable();  // 16進数カラーコードフィールド (e.g., #FFFFFF)
            $table->integer('sort_order')->default(0);     // 並び順フィールド
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
