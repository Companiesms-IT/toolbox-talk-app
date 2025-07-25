<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolboxTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toolbox_talks', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->longText('video_url')->nullable();
            $table->integer('number_of_questions_to_ask')->nullable();
            $table->integer('number_of_correct_answer_to_pass')->nullable();
            $table->longText('file')->nullable();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();    
            $table->enum('is_library',['1','2','3'])->default(null);
            $table->date('due_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->enum('status', ['0', '1'])->default(null);
            $table->enum('is_created',['1','2'])->default(2);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toolbox_talks');
    }
}
