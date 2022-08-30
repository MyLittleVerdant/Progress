<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('key');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('picture')->nullable();
            $table->string('signature')->nullable();
            $table->string('CEO_name')->nullable();
            $table->string('first_quarter_num')->nullable();
            $table->string('first_quarter_title')->nullable();
            $table->string('second_quarter_num')->nullable();
            $table->string('second_quarter_title')->nullable();
            $table->string('third_quarter_num')->nullable();
            $table->string('third_quarter_title')->nullable();
            $table->string('fourth_quarter_num')->nullable();
            $table->string('fourth_quarter_title')->nullable();
            $table->integer('sort')->default(500);
            $table->string('whale')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about');
    }

}
