<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessortWorkShiftPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressort_work_shift_person', function (Blueprint $table) {

            $table->unsignedBigInteger('ressort_work_shift_id');
            $table->foreign('ressort_work_shift_id')
                ->references('id')
                ->on('ressort_work_shifts')
                ->onDelete('cascade');

            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');

            $table->boolean('is_optional')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ressort_work_shift_person');
    }
}
