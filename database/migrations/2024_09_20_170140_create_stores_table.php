<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('email')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('category_id'); // カテゴリID
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->boolean('approval_flag')->default(false);
            $table->boolean('display_flag')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
    