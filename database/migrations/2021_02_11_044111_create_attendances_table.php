<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->string('date');
            $table->string('monthyear');
            $table->integer('present')->default(0);
            $table->integer('paid_leave')->default(0);
            $table->integer('unpaid_leave')->default(0);
            $table->string('entry_time')->nullable();
            $table->string('exit_time')->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
