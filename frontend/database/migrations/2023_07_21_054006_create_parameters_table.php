<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('version_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('parameter_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('calculation_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->string('parameter_name', 255);
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
        Schema::dropIfExists('parameters');
    }
}
