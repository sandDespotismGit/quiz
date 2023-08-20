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
        Schema::create('courses_clients', function (Blueprint $table) {
            $table->id();

            //то есть знаем, кто продавец текущего курса, что за курс на данной итерации и какой курс будет на следующей
            $table->unsignedBiginteger('clients_id')->unsigned();
            $table->unsignedBiginteger('courses_id')->unsigned();
            $table->unsignedBiginteger('next_courses_id')->nullable();

            $table->foreign('clients_id')->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('courses_id')->references('id')
                ->on('courses')->onDelete('cascade');
            $table->foreign('next_courses_id')->references('id')
                ->on('courses')->onDelete('cascade');

            //для связки цепочки курсов
            $table->bigInteger('key');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_clients');
    }
};
