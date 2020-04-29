<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
                $table->engine = "InnoDB";
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('title');
                $table->string('slug');
                $table->text('description');
                $table->text('body');
                $table->text('images');
                $table->string('tags');
                $table->integer('viewCount')->default(0);
                $table->integer('commentCount')->default(0);
                $table->timestamps();
            });
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
