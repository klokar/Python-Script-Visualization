<?php

use App\Models\Execution;
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
            $table->unsignedBigInteger('user_id');
            $table->string('hash');
            $table->unsignedBigInteger('data_processor_id');
            $table->unsignedBigInteger('dataset_id');
            $table->unsignedBigInteger('dataset_ev_id');
            $table->tinyInteger('test_set_size');
            $table->string('parameters')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(Execution::STATUS_CREATED);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('data_processor_id')->references('id')->on('data_processors')->onDelete('cascade');
            $table->foreign('dataset_id')->references('id')->on('datasets')->onDelete('cascade');
            $table->foreign('dataset_ev_id')->references('id')->on('datasets')->onDelete('cascade');
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
