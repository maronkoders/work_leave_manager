<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->integer('gradeId')->unsigned();
            $table->integer('positionId')->unsigned();
            $table->integer('departmentId')->unsigned();
            $table->integer('subDepartmentId')->unsigned();
            $table->integer('roleId')->unsigned();
            $table->foreign('roleId')->references('id')->on('roles');
            $table->foreign('gradeId')->references('id')->on('grades');
            $table->foreign('positionId')->references('id')->on('positions');
            $table->foreign('departmentId')->references('id')->on('departments');
            $table->foreign('subDepartmentId')->references('id')->on('categories');
            $table->string('password');
            $table->string('userName');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
