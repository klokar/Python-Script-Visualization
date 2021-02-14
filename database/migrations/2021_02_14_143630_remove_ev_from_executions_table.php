<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEvFromExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('executions', function (Blueprint $table) {
            $table->dropForeign(['dataset_ev_id']);
            $table->dropColumn('dataset_ev_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('executions', function (Blueprint $table) {
            $table->unsignedBigInteger('dataset_ev_id')->after('dataset_id');
            $table->foreign('dataset_ev_id')->references('id')->on('datasets')->onDelete('cascade');
        });
    }
}
