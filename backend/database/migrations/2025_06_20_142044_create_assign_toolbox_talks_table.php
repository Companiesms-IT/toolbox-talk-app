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
        Schema::create('assign_toolbox_talks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable(); 
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade'); 
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->unsignedBigInteger('toolbox_talk_id')->nullable();
            $table->longText('user_name')->nullable();
            $table->foreign('toolbox_talk_id')->references('id')->on('toolbox_talks')->onDelete('cascade');
            $table->date('due_date')->nullable(); 
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status', ['1', '2', '3', '4'])->default('3')->comment('1: Ended, 2: Completed, 3: Ongoing, 4: Acknowledged');
            $table->string('result')->nullable();
            $table->integer('attempt_count')->nullable();
            $table->string('date_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_toolbox_talks');
    }
};
