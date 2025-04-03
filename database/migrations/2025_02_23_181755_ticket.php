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
        Schema::create('ticket', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->integer('id_event');
            $table->integer('id_cate');
            $table->string('name_ticket');
            $table->integer('price_ticket');
            $table->integer('sale_ticket');
            $table->integer('bought')->default(0);
            $table->integer('quantity_ticket');
            $table->boolean('delete_ever')->default(0);
            $table->longText('description_ticket');
            $table->string('img_ticket');
            $table->boolean('hidden_ticket')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
