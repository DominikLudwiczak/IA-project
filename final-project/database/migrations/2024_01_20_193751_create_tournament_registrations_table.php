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
        Schema::create('tournament_registrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tournament_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('rank')->nullable();
            $table->string('license');
            $table->timestamps();

            $table->foreign('tournament_id')->references('id')->on('tournaments');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_registrations');
    }
};
