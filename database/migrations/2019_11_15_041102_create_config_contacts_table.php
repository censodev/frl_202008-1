<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('title_contact')->nullable();
            $table->string('title_contact_sub')->nullable();
            $table->string('images_background')->nullable();
            $table->longText('google_map')->nullable();
            $table->longText('description')->nullable();
            $table->string('title_contact_info')->nullable();
            $table->string('title_contact_info_sub')->nullable();
            $table->longText('description_info')->nullable();
            $table->longText('contact_info')->nullable();
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
        Schema::dropIfExists('config_contacts');
    }
}
