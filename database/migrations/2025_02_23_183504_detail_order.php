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
        Schema::create('detail_order', function (Blueprint $table) {
            $table->id('id_detail');
            $table->integer('id_order');
            $table->integer('id_ticket');
            $table->string('seri_ticket');
            $table->integer('id_event');
            $table->integer('quantity');
            $table->decimal('total', 10, 2)->default(0);
            $table->string('value_voucher')->nullable();
            $table->string('value_down')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_order');
    }
};
