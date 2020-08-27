<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('smtp_title');
            $table->string('smtp_email');
            $table->string('smtp_pass');
            $table->integer('smtp_port');
            $table->string('smtp_host');
            $table->longText('smtp_content')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('config_emails');
    }
}
