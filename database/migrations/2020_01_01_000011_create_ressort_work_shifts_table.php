<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessortWorkShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressort_work_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id')->index();
            $table->integer('ressort_id')->references('id')->on('ressorts')->onDelete('cascade');
            $table->string('day')->nullable();
            $table->integer('time_start')->nullable();
            $table->integer('time_end')->nullable();
            $table->integer('supporter_min')->nullable();
            $table->integer('supporter_max')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ressort_work_shifts');
    }
}
