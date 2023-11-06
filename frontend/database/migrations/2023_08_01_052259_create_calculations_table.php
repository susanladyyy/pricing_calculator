<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('version_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('calculation_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('status');
            $table->unsignedBigInteger('result');
            $table->timestamp('created_at')->default(date("Y-m-d H:i:s"));
            $table->timestamp('updated_at')->default(date("Y-m-d H:i:s"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculations');
    }
}
