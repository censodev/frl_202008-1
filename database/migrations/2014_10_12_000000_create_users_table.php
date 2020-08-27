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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('fullname');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->char('phone',20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            //$table->timestamp('email_verified_at')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->smallInteger('status')->default(1);
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
