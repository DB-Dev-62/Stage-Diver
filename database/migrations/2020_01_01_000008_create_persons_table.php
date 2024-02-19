<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id')->index();
            $table->string('name')->index();
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('year')->nullable();
            $table->boolean('registered')->nullable();
            $table->boolean('friday')->nullable();
            $table->boolean('friday_beer')->nullable();
            $table->boolean('saturday')->nullable();
            $table->boolean('saturday_beer')->nullable();
            $table->boolean('sunday')->nullable();
            $table->boolean('sunday_beer')->nullable();
            $table->string('t_shirt_size')->nullable();
            $table->boolean('t_shirt_picked_up')->nullable();
            $table->integer('food')->nullable();
            $table->longText('allergies')->nullable();
            $table->longText('other')->nullable();
            $table->longText('note')->nullable();
            $table->integer('workload')->nullable();
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
        Schema::dropIfExists('persons');
    }
}
