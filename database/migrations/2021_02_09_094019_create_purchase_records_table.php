<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_records', function (Blueprint $table) {
            $table->id();
            $table->string('thirdparty_name');
            $table->string('purchase_date');
            $table->longText('purpose');
            $table->string('bill_number');
            $table->string('bill_amount');
            $table->string('paid_amount');
            $table->string('due_amount');
            $table->string('monthyear');
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
        Schema::dropIfExists('purchase_records');
    }
}
