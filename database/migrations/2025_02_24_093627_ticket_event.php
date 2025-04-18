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
        Schema::create('events', function (Blueprint $table) {
            $table->id('id_event');
            $table->string('name_event');
            $table->string('location');
            $table->string('img_event');
            $table->string('status')->nullable()->default('Chưa bắt đầu');
            $table->integer('max_ticket');
            $table->integer('sold_ticket');
            $table->dateTime('date_start');
            $table->boolean('delete_ever')->default(0);
            $table->dateTime('date_end');
            $table->longText('description_event');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
