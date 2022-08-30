<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('file')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('relation_id');
            $table->string('relation_name');
            $table->integer('sort')->default(500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medias');
    }
}
