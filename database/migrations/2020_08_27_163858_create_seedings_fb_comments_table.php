<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeedingsFbCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seedings_fb_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('content')->nullable();
            $table->string('time')->nullable();
            $table->integer('likes')->nullable();
            $table->smallInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->string('title_image')->nullable();
            $table->string('alt_image')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seeding_fb_comments');
    }
}
