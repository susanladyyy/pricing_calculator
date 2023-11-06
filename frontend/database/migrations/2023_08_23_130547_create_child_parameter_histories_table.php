<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_parameter_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parameter_history_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('parameter_name', 1000);
            $table->unsignedBigInteger('parameter_cost');
            $table->integer('parameter_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_parameter_histories');
    }
};
