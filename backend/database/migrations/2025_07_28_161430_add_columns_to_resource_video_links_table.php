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
        Schema::table('resource_video_links', function (Blueprint $table) {
            $table->enum('video_status', ['1', '2'])->default('2')->comment('1: Completed, 2: Incompleted')->after('video_description');
            $table->string('video_state')->nullable()->after('video_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_video_links', function (Blueprint $table) {
            //
        });
    }
};
