<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id');
            $table->string('user_id');
            $table->string('user_type');
            $table->string('lead_head');
            $table->string('w_e_f');
            $table->string('w_e_t');
            $table->string('status');
            $table->string('company_id');
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
        Schema::dropIfExists('lead_assignments');
    }
}
