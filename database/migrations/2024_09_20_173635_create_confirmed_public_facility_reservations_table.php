<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmedPublicFacilityReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('confirmed_public_facility_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('temporary_reservation_id');
            $table->date('confirmed_reservation_date'); // 仮予約テーブルの予約日
            $table->integer('confirmed_reservation_time'); // 仮予約テーブルの予約時間
            $table->integer('people'); // 仮予約テーブルの人数
            $table->boolean('cancel_flag')->default(false); // 0:未キャンセル, 1:キャンセル
            $table->timestamps();

            // 短い名前の外部キー制約
            $table->foreign('facility_id', 'fk_facility')
                ->references('id')->on('public_facilities')
                ->onDelete('cascade');

            $table->foreign('temporary_reservation_id', 'fk_temp_reservation')
                ->references('id')->on('temporary_public_facility_reservations')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('confirmed_public_facility_reservations');
    }
}
