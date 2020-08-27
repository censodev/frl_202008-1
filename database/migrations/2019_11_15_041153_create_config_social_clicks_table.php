<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSocialClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_social_clicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('social_id')->nullable();
            $table->date('date')->nullable();
            $table->char('ip', 30)->nullable();
            $table->integer('number_click')->nullable();
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
        Schema::dropIfExists('config_social_clicks');
    }
}
