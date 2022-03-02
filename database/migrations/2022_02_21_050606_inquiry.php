<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Inquiry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number', 100);
            $table->string('address_line1')->default('');
            $table->string('address_line2')->default('');
            $table->bigInteger('country_id')->default(0);
            $table->bigInteger('state_id')->default(0);
            $table->bigInteger('city_id')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('pincode', 20)->default('');
            $table->bigInteger('source_type')->default(0);
            $table->bigInteger('source_user_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('assigned_to')->default(0);
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
        //
    }
}
