<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSocialTopbarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_social_topbars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('link')->nullable();
            $table->string('icon')->nullable();
            $table->string('background_color')->nullable();
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
        Schema::dropIfExists('config_social_topbars');
    }
}
