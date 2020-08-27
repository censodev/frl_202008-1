<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomepageManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('related_slider')->nullable();
            $table->string('title_about')->nullable();
            $table->string('images_about')->nullable();
            $table->string('title_image_about')->nullable();
            $table->string('alt_image_about')->nullable();
            $table->string('title_about_image')->nullable();
            $table->longText('content_about')->nullable();
            $table->string('title_button_about')->nullable();
            $table->text('button_link_about')->nullable();
            $table->string('title_service')->nullable();
            $table->string('title_service_sub')->nullable();
            $table->longText('content_service')->nullable();
            $table->string('title_button_service')->nullable();
            $table->text('button_link_service')->nullable();
            $table->string('service_phone')->nullable();
            $table->string('images_service')->nullable();
            $table->longText('related_service')->nullable();
            $table->string('title_funfact')->nullable();
            $table->string('images_funfact')->nullable();
            $table->longText('funfact_number')->nullable();
            $table->longText('funfact_description')->nullable();
            $table->string('col_title')->nullable();
            $table->string('col_title_sub')->nullable();
            $table->longText('col_content')->nullable();
            $table->string('col_image')->nullable();
            $table->longText('item_col_title')->nullable();
            $table->longText('item_col_icon')->nullable();
            $table->longText('item_col_description')->nullable();
            $table->text('item_col_link')->nullable();
            $table->string('title_gallery')->nullable();
            $table->string('title_gallery_sink')->nullable();
            $table->longText('related_gallery')->nullable();
            $table->string('title_team')->nullable();
            $table->string('images_team')->nullable();
            $table->longText('related_team')->nullable();
            $table->string('title_feedback')->nullable();
            $table->string('title_feedback_sink')->nullable();
            $table->longText('content_feedback')->nullable();
            $table->string('images_feedback')->nullable();
            $table->string('title_news')->nullable();
            $table->string('title_news_sink')->nullable();
            $table->string('images_news')->nullable();
            $table->longText('related_post')->nullable();
            $table->longText('related_partner')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->smallInteger('home_default')->default(0);
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
        Schema::dropIfExists('homepage_managers');
    }
}
