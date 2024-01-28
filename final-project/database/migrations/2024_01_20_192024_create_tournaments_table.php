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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('time', 0);
            $table->dateTime('registration_time', 0);
            $table->integer('max_participants');
            $table->double('latitude');
            $table->double('longitude');
            $table->bigInteger('organizer_id')->unsigned();
            $table->bigInteger('discipline_id')->unsigned();
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);

            $table->foreign('organizer_id')->references('id')->on('users');
            $table->foreign('discipline_id')->references('id')->on('disciplines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
        \DB::unprepared('DROP TRIGGER IF EXISTS create_ladder_trigger');
    }
};
