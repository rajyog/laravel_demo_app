<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InquiryQuestions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inquiry_questions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0);            
            $table->tinyInteger('type')->default(0);
            $table->string('question',500)->default('');
            $table->tinyInteger('is_static')->default(0);            
            $table->tinyInteger('is_required')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
