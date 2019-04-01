<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paymentID');
            $table->integer('userID')->unsigned()->index();
            $table->foreign('userID')
                ->references('id')->on('students')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('month');
            $table->string('year');
            $table->string('amount');
            $table->string('payDate');
            $table->string('dueFine');
            $table->string('refund');
            $table->string('mobileNo');
            $table->string('method');
            $table->string('trxID');
            $table->string('confirmation');
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
        Schema::dropIfExists('payments');
    }
}
