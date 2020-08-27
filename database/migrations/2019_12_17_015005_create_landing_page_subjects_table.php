<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingPageSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('images')->nullable();
            $table->string('title_image')->nullable();
            $table->string('alt_image')->nullable();
            $table->text('link')->nullable();
            $table->text('link_title')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('landing_page_subjects');
    }
}
