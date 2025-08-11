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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('toolbox_talk_id')->nullable();
            $table->unsignedBigInteger('assigned_id')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->longText('message')->nullable();
            $table->longText('description')->nullable();
            $table->longText('data')->nullable();
            $table->enum('is_read', ['1', '2'])->default('2')->comment('1: Yes, 2: No');
            $table->enum('status', ['1', '2'])->default('2')->comment('1: Yes, 2: No');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
