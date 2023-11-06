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
        Schema::create('parameter_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('version_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('history_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('parameter_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('calculation_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('parameter_id', 1000);
            $table->string('parameter_name', 1000);
            $table->unsignedBigInteger('parameter_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter_histories');
    }
};
