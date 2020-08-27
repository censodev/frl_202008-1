<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->default(0);
            $table->string('title');
            $table->string('alias');
            $table->string('alias_external')->nullable();
            $table->integer('type');
            $table->integer('section_scroll')->nullable();
            $table->integer('show_menu_alias')->nullable();
            $table->string('icons')->nullable();
            $table->string('images')->nullable();
            $table->string('title_image')->nullable();
            $table->string('alt_image')->nullable();
            $table->smallInteger('ordering')->nullable();
            $table->longText('description')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_desciption')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_google')->nullable();
            $table->text('seo_facebook')->nullable();
            $table->smallInteger('is_feature')->default(0);
            $table->smallInteger('is_show_menu_main')->default(0);
            $table->smallInteger('is_show_menu_landingpage')->default(0);
            $table->smallInteger('is_show_menu_landingpage_single')->default(0);
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
        Schema::dropIfExists('categories');
    }
}
