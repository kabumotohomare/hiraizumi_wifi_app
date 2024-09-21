<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->string('image');
            $table->text('shop');
            $table->string('email');
            $table->string('postal_code');
            $table->text('address');
            $table->string('map_url');
            $table->foreignId('status_id')
                ->default(0)  // 0は掲載していない状態。status_idカラムに外部キー制約を追加し、statusesテーブルから参照する
                ->constrained();
            $table->timestamp('reported_at')->useCurrent();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
