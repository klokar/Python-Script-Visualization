<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executions', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->unsignedBigInteger('data_processor_id');
            $table->unsignedBigInteger('dataset_id');
            $table->text('comment')->nullable();
            $table->string('parameters')->nullable();
            $table->timestamps();

            $table->foreign('data_processor_id')->references('id')->on('data_processors');
            $table->foreign('dataset_id')->references('id')->on('datasets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('executions');
    }
}
