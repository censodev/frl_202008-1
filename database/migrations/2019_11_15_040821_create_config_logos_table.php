<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_logos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('link')->nullable();
            $table->string('link_title')->nullable();
            $table->string('images');
            $table->string('title_image');
            $table->string('alt_image');
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('config_logos');
    }
}
