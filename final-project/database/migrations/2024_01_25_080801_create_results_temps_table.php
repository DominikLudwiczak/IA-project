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
        Schema::create('results_temps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ladder_id')->unsigned();
            $table->bigInteger('participant_id')->unsigned();
            $table->bigInteger('winner_id')->unsigned();
            $table->timestamps();

            $table->foreign('ladder_id')->references('id')->on('ladders');
            $table->foreign('participant_id')->references('id')->on('users');
            $table->foreign('winner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results_temps');
    }
};
