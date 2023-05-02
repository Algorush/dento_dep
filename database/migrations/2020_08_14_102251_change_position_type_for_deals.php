<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePositionTypeForDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->float('upper_position_x')->change();
            $table->float('upper_position_y')->change();
            $table->float('upper_rotation_y')->change();
            $table->float('lower_position_x')->change();
            $table->float('lower_position_y')->change();
            $table->float('lower_rotation_y')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->integer('upper_position_x')->change();
            $table->integer('upper_position_y')->change();
            $table->integer('upper_rotation_y')->change();
            $table->integer('lower_position_x')->change();
            $table->integer('lower_position_y')->change();
            $table->integer('lower_rotation_y')->change();
        });
    }
}
