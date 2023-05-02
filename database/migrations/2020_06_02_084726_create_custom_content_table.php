<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_content', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('point_image_1')->nullable();
            $table->text('point_text_1')->nullable();

            $table->string('point_image_2')->nullable();
            $table->text('point_text_2')->nullable();

            $table->string('point_image_3')->nullable();
            $table->text('point_text_3')->nullable();

            $table->string('point_image_4')->nullable();
            $table->text('point_text_4')->nullable();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('custom_content');
    }
}
