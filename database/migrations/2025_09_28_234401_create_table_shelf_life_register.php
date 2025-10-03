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
        Schema::create('shelf_life_register', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('upload_id');
            $table->string('operation_name');
            $table->string('sku_name');
            $table->string('answer');
            $table->float('latitude');
            $table->float('longitude');
            $table->integer('battery_level');
            $table->string('type')->nullable();
            $table->date('validity_at')->nullable();
            $table->integer('amount')->nullable();
            $table->foreign('upload_id')->references('id')->on('upload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelf_life_register');
    }
};
