<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->integer('position_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('image');
            $table->string('national_id');
            $table->string('documents');
            $table->string('contract');
            $table->integer('allocated_salary');
            $table->boolean('has_role');
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
        Schema::dropIfExists('staff');
    }
}
