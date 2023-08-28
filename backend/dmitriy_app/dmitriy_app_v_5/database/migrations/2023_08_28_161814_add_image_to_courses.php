<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add the macro to tell the grammar how to handle the unsupported type
        MySqlGrammar::macro('typeLongblob', function (Fluent $column) {
            return 'longblob';
        });

        Schema::table('courses', function (Blueprint $table) {
            // call the low-level addColumn to use the unsupported type
            $table->addColumn('longblob', 'main_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('main_image');
        });
    }
};
