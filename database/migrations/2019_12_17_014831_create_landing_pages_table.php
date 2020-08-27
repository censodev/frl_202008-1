<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->string('title');
            $table->string('alias');
            $table->text('ldp_images')->nullable();
            $table->text('ldp_description')->nullable();
            $table->longText('data_title')->nullable();
            $table->longText('data_background')->nullable();
            $table->longText('data_image')->nullable();
            $table->longText('data_image_title')->nullable();
            $table->longText('data_image_alt')->nullable();
            $table->longText('data_content')->nullable();
            $table->longText('data_title_form')->nullable();
            $table->longText('data_icon_form')->nullable();
            $table->longText('data_check_show')->nullable();
            $table->longText('data_form')->nullable();
            $table->longText('col_title_why')->nullable();
            $table->longText('col_icon_why')->nullable();
            $table->longText('col_description_why')->nullable();
            $table->longText('images_gym')->nullable();
            $table->longText('title_image_gym')->nullable();
            $table->longText('alt_image_gym')->nullable();
            $table->longText('col_title_gym')->nullable();
            $table->longText('col_icon_gym')->nullable();
            $table->longText('col_description_gym')->nullable();
            $table->longText('col_title_count')->nullable();
            $table->longText('col_icon_count')->nullable();
            $table->longText('col_description_count')->nullable();
            $table->longText('col_title_commitment')->nullable();
            $table->longText('col_icon_commitment')->nullable();
            $table->longText('col_description_commitment')->nullable();
            $table->longText('col_title_customerfeedback_video')->nullable();
            $table->longText('col_customerfeedback_video')->nullable();
            $table->longText('banners')->nullable();
            $table->longText('subjects')->nullable();
            $table->longText('trainers')->nullable();
            $table->longText('galleries')->nullable();
            $table->longText('branchs')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_desciption')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_google')->nullable();
            $table->text('seo_facebook')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->smallInteger('is_home_page')->default(0);
            $table->smallInteger('show_main_menu')->default(0);
            $table->smallInteger('hide_menu_on_page')->default(0);
            $table->smallInteger('hide_form_on_page')->default(0);
            $table->smallInteger('hide_comment_on_page')->default(0);
            $table->smallInteger('hide_copyright_on_page')->default(0);
            $table->smallInteger('show_footer')->default(0);
            $table->smallInteger('status')->default(1);
        });
    }
    /*public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->string('title');
            $table->string('alias');
            $table->longText('images_gym')->nullable();
            $table->string('title_image_gym')->nullable();
            $table->string('alt_image_gym')->nullable();
            $table->longText('data')->nullable();
            $table->text('banner')->nullable();
            $table->text('subject')->nullable();
            $table->text('trainer')->nullable();
            $table->text('gallery')->nullable();
            $table->text('branch')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_desciption')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_google')->nullable();
            $table->text('seo_facebook')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->smallInteger('is_home_page')->default(0);
            $table->smallInteger('show_main_menu')->default(0);
            $table->smallInteger('hide_menu_on_page')->default(0);
            $table->smallInteger('hide_form_on_page')->default(0);
            $table->smallInteger('hide_comment_on_page')->default(0);
            $table->smallInteger('hide_copyright_on_page')->default(0);
            $table->smallInteger('is_footer')->default(0);
            $table->smallInteger('status')->default(1);
        });
    }*/

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
}
