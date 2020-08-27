<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_socials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('select_link')->nullable();
            $table->text('link')->nullable();
            $table->string('link_title')->nullable();
            $table->string('icon_default')->nullable();
            $table->string('images')->nullable();
            $table->string('title_image')->nullable();
            $table->string('alt_image')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->smallInteger('hide_social')->default(0);
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
        Schema::dropIfExists('config_socials');
    }
}
