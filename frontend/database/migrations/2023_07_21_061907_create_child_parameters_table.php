<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('parameter_id');
            $table->string('user_id')->nullable();
            $table->string('parameter_name', 255);
            $table->integer('parameter_cost');
            $table->integer('parameter_number');

            $table->foreign('parameter_id')->references('id')->on('parameters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_parameters');
    }
}
