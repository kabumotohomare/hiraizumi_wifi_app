<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryPublicFacilityReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('temporary_public_facility_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facility_id');  // gym_id to facility_id
            $table->string('reservation_name');
            $table->string('reservation_phone');
            $table->string('reservation_email');
            $table->string('reservation_postal_code');
            $table->string('reservation_address');
            $table->date('reservation_date');
            $table->integer('people');
            $table->integer('reservation_time');  // 予約時間 (1時間単位, 最大3時間)
            $table->tinyInteger('approval_flag')->default(0);  // 0:申請中, 1:承認, 2:却下
            $table->timestamps();

            // 外部キー参照をgym_idからfacility_idに変更
            $table->foreign('facility_id')->references('id')->on('public_facilities')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('temporary_public_facility_reservations');
    }
}
