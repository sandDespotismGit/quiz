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
        Schema::create('courcess', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_id');
            $table->foreign('rate_id')
                ->references('id')->on('rates')
                ->onDelete('cascade');
            $table->string('name');
            $table->double('price');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courcess');
    }
};
