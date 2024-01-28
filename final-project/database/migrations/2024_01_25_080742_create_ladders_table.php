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
        Schema::create('ladders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tournament_id')->unsigned();
            $table->bigInteger('participant1_id')->unsigned();
            $table->bigInteger('participant2_id')->unsigned();
            $table->bigInteger('winner_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('tournament_id')->references('id')->on('tournaments');
            $table->foreign('participant1_id')->references('id')->on('users');
            $table->foreign('participant2_id')->references('id')->on('users');
            $table->foreign('winner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ladders');
    }
};
