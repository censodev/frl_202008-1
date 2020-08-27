<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->string('title');
            $table->string('title_sub')->nullable();
            $table->string('alias');
            $table->integer('view')->nullable();
            $table->integer('rating')->nullable();
            $table->longText('images')->nullable();
            $table->longText('title_image')->nullable();
            $table->longText('alt_image')->nullable();
            $table->longText('videos')->nullable();
            $table->longText('sapo')->nullable();
            $table->longText('description')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_desciption')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_google')->nullable();
            $table->text('seo_facebook')->nullable();
            $table->longText('related_post')->nullable();
            $table->longText('related_gallery')->nullable();
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
        Schema::dropIfExists('galleries');
    }
}
