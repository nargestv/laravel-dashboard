<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('courses');
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type', 10);
            $table->string('title')->collate('utf8_general_ci');
            $table->string('slug');
            $table->text('description')->collate('utf8_general_ci');
            $table->text('body')->collate('utf8_general_ci');
            $table->string('price', 50);
            $table->text('images');
            $table->string('tags');
            $table->string('time', 15)->default('00:00:00');
            $table->integer('viewCount')->default(0);
            $table->integer('commentCount')->default(0);
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
        Schema::dropIfExists('courses');
    }
}
