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
            $table->string('e_path');
            $table->string('e_path_result_figures');
            $table->string('e_path_result_data');
            $table->string('e_path_program_details')->nullable();
            $table->string('e_path_evaluation_details')->nullable();
            $table->tinyInteger('level');
            $table->text('comment')->nullable();
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
