<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('email')->nullable();
            $table->string('username');
            $table->string('password');
            $table->date('dateOfBirth')->nullable();
            $table->string('address')->nullable();
            $table->string('education')->nullable();
            $table->string('institution')->nullable();
            $table->integer('mobileNo')->nullable();
            $table->string('localGuardian')->nullable();
            $table->string('guardianNo')->nullable();
            $table->string('role');
            $table->string('filename')->nullable();
            $table->string('rememberToken');
            $table->string('accountStatus');
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
        Schema::dropIfExists('students');
    }
}
