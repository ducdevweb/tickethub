<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiningReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('dining_reservations', function (Blueprint $table) {
            $table->bigIncrements('id_reservation');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('restaurant_id');
            $table->dateTime('reservation_date');
            $table->integer('number_of_people');
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dining_reservations');
    }
}