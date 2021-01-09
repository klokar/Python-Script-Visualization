<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataProcessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_processors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('path');
            $table->string('algorithm', 20);
            $table->string('processor_path')->nullable();
            $table->string('dataset_path')->nullable();
            $table->string('dataset_filename')->nullable();
            $table->string('results_path')->nullable();
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
        Schema::dropIfExists('data_processors');
    }
}
