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
        Schema::create('price_survey_start', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('upload_id');
            $table->string('operation_name');
            $table->float('latitude');
            $table->float('longitude');
            $table->integer('battery_level');
            $table->foreign('upload_id')->references('id')->on('upload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_survey_start');
    }
};
