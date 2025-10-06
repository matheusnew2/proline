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
        Schema::create('data_amount', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('upload_id');
            $table->foreign('upload_id')->references('id')->on('upload');
            $table->string('table');
            $table->integer('qtd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_amount');
    }
};
