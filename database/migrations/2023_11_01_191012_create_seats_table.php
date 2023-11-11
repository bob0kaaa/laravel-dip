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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('free')->default(true);
            $table->integer('col_number');
            $table->integer('row_number');
            $table->integer('hall_id');
            $table->integer('ticket_id')->default(0);
            $table->unsignedBigInteger('seance_id');
            $table->foreign('seance_id')->references('id')->on('seances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
