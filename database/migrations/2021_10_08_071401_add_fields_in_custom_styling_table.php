<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInCustomStylingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_styling', function (Blueprint $table) {
            $table->string('background_color')->nullable();
            $table->string('progressbar_color')->nullable();
            $table->string('progressbar_background_color')->nullable();
        });

        Schema::table('custom_content', function (Blueprint $table) {
            $table->string('point_text_header_1')->nullable();
            $table->string('point_text_header_2')->nullable();
            $table->string('point_text_header_3')->nullable();
            $table->string('point_text_header_4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 
    }
}
