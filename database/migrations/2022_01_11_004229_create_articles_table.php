<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('source')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->text('image_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->text('content');
            $table->string('type_name');
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('client_applications');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
