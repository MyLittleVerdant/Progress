<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        date_default_timezone_set('Europe/Moscow');
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->dateTime("date")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('preview_title');
            $table->string('detail_title');
            $table->text('preview_description');
            $table->text('detail_description');
            $table->string("main_picture")->nullable();;
            $table->string("preview_picture")->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
