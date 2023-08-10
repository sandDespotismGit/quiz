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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            /*
            $table->unsignedBigInteger('rate_id');
            $table->foreign('rate_id')
                ->references('id')->on('rates')
                ->onDelete('cascade');
            */
            
            //или вместо двух строчек выше
            $table->foreignId('rate_id')->constrained('rates')->cascadeOnDelete();

            $table->string('name');
            $table->text('description');
            $table->boolean('is_active');
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
