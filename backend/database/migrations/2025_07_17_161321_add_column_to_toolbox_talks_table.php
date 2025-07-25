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
        Schema::table('toolbox_talks', function (Blueprint $table) {
            $table->enum('is_library_deleted', ['1', '2'])->default('2')->comment('1: Yes, 2: No')->after('is_library');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toolbox_talks', function (Blueprint $table) {
            //
        });
    }
};
