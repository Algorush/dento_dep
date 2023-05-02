<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsLowerFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals_lower_files', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('deal_id')->unsigned();
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');

            $table->string('original_name')->nullable();
            $table->string('file_path')->nullable();

            $table->integer('position')->default(1);

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
        Schema::dropIfExists('deals_lower_files');
    }
}
