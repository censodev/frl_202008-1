<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigFootersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_footers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('footer_title')->nullable();
            $table->longText('footer_description')->nullable();
            $table->longText('footer_contact_info')->nullable();
            $table->longText('footer_copyright')->nullable();
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
        Schema::dropIfExists('config_footers');
    }
}
