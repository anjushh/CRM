<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('business_name');
            $table->string('address');
            $table->string('phone_no');
            $table->string('email');
            $table->string('alt_contact');
            $table->string('status');
            $table->string('product');
            $table->string('anni_date');
            $table->string('birth_date');
            $table->string('finali_date');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('time_period');
            $table->string('remarks');
            $table->string('follow_ups');
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
        Schema::dropIfExists('clients');
    }
}
