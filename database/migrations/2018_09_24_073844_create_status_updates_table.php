<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status_type');
            $table->string('next_followup');
            
            $table->string('finali_date');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('time_period');

            $table->string('doc_1');
            $table->string('doc_2');
            $table->string('doc_3');
            $table->string('doc_4');
            $table->string('doc_5');

            $table->string('remarks');
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
        Schema::dropIfExists('status_updates');
    }
}
