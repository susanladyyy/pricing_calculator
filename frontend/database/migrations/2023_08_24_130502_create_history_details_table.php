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
        Schema::create('history_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('version_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('calculation_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_details');
    }
};
