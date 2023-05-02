<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionsToDealsFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->integer('upper_position_x')->nullable();
            $table->integer('upper_position_y')->nullable();
            $table->integer('upper_rotation_y')->nullable();
            $table->integer('lower_position_x')->nullable();
            $table->integer('lower_position_y')->nullable();
            $table->integer('lower_rotation_y')->nullable();
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
            $table->dropColumn('upper_position_x');
            $table->dropColumn('upper_position_y');
            $table->dropColumn('upper_rotation_y');
            $table->dropColumn('lower_position_x');
            $table->dropColumn('lower_position_y');
            $table->dropColumn('lower_rotation_y');
        });
    }
}
